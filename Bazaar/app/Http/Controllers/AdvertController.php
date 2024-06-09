<?php

namespace App\Http\Controllers;

use App\Abstracts\AbstractAdvertCsvHandler;
use App\Abstracts\AbstractQueue;
use App\Interfaces\ICsvHandler;
use App\Models\Advert;
use App\Models\Bids;
use App\Models\HiredProduct;
use App\Models\ReturnImages;
use App\Models\User;

use App\Models\AdvertReview;
use App\Models\FavoriteAdvert;
use App\Models\Role;

use App\Models\AdvertQueue;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdvertController extends Controller
{
    const MAX_ADVERT_NUM = 4;

    const MAX_TITLE_LENGHT = 50;
    private ICsvHandler $csvHandler;
    private AbstractQueue $advertQueue;

    public function __construct(AbstractAdvertCsvHandler $csvHandler)
    {
        $this->csvHandler = $csvHandler;
        $this->advertQueue = new AdvertQueue();
    }

    public function show($id) {
        $advert = Advert::where('id', $id)
            ->with('owner')
            ->first();

        $bids = Bids::where('advert_id', $id)->orderBy('created_at', 'desc')->get();

        $qrCode = QrCode::size(200)
            ->generate(route('advert.show', ['id' => $id]));

        $reviews = AdvertReview::where('advert_id', $id)
            ->with('advert')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $favoritedColor = FavoriteAdvert::isFavorited($id) ? 'yellow' : 'gray';

        $data = [
            'advert' => $advert,
            'qrcode' => $qrCode,
            'reviews' => $reviews,
            'favorited' => $favoritedColor,
            'bids' => $bids,
        ];

        return view('adverts.advert', compact('data'));
    }

    public function hire($id, Request $request) {
        $request->validate([
            'rent_start' => 'required|date|after_or_equal:now',
            'rent_end' => 'required|date|after:'.$request->input('rent_start'),
        ]);

        $advert = Advert::where('id', $id)->first();
        $failed = self::validateAvailability($advert, $request->input('rent_start'), $request->input('rent_end'));

        if($failed) {
            return to_route('advert.show', ['id' => $id]);
        }

        HiredProduct::create([
            'advert_id' => $advert->id,
            'user_id' => Auth::id(),
            'from' => $request->input('rent_start'),
            'to' => $request->input('rent_end'),
        ]);
        return to_route('advert.show', ['id' => $id]);
    }

    private function validateAvailability($advert, $start, $end) {
        $hires = HiredProduct::where('advert_id', $advert->id)
            ->get();

        foreach ($hires as $hiredProduct) {
            if($hiredProduct->from >= $start && $hiredProduct->from <= $end
            || $hiredProduct->to >= $start && $hiredProduct->to <= $end) {
                return true;
            }
        }

        return false;
    }

    public function bid($id, Request $request) {
        $request->validate([
            'money' => 'required|numeric',
        ]);

        $bids = Bids::where('user_id', Auth::id())->get();
        $amountOfValidBids = 0;
        $largerThanTop = true;
        $userIsTopBid = false;

        foreach ($bids as $bid) {
            $topBidOnPost = Bids::where('advert_id', $id)->orderBy('money', 'desc')->first();

            if($topBidOnPost != null && $topBidOnPost->money > $request->money) {
                $largerThanTop = false;
            }
            if($bid->advert->post_status_id != 4 || $topBidOnPost->user_id == Auth::id()) {
                $amountOfValidBids++;
            }
            if($topBidOnPost != null && $topBidOnPost->user_id == Auth::id()) {
                $amountOfValidBids++;
            }
        }

        if($amountOfValidBids >= self::MAX_ADVERT_NUM || !$largerThanTop || $userIsTopBid) {
            return to_route('advert.show', ['id' => $id]);
        }

        Bids::create([
            'user_id' => Auth::id(),
            'advert_id' => $id,
            'money' => $request->input('money'),
        ]);

        return to_route('advert.show', ['id' => $id]);
    }

    public function returnShow ($id) {
        $hired_advert = HiredProduct::where('id', $id)->first();
        $advert = $hired_advert->advert;
        $cost = date_diff(new DateTime($hired_advert->from), new DateTime($hired_advert->to))->days * 1.35;

        return view('adverts.return-advert', ['advert' => $advert, 'hired_advert' => $hired_advert, 'cost' => $cost]);
    }

    public function return ($id, Request $request) {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,jpg,png,gif|max:10000',
        ]);

        $hired_advert = HiredProduct::where('id', $id)->first();
        $advert = $hired_advert->advert;

        foreach($request->file('images') as $image) {
            $originalFileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $newFileName = $originalFileName.'.'.$image->getClientOriginalExtension();
            $storePath = 'public/adverts/return/'.$id;

            $image->storeAs($storePath, $newFileName, 'local');

            ReturnImages::create([
                'hired_product_id' => $id,
                'url' => $storePath.'/'.$newFileName,
            ]);
        }

        $hired_advert->returned = true;
        $hired_advert->total_wear_cost = date_diff(new DateTime($hired_advert->from), new DateTime($hired_advert->to))->days * 1.35;
        $hired_advert->save();

        return to_route('products.show', ['type' => 'hired']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $account = Auth::user();
        $isBusinessAccount = $account->role()->value('value') === Role::ROLE_BUSINESS_ADVERTISER;

        $data = [
            'createLabel' => trans()->get('advertPostForm.create'),
            'titleLabel' => trans()->get('advertPostForm.title'),
            'descriptionLabel' => trans()->get('advertPostForm.description'),
            'isRentalLabel' => trans()->get('advertPostForm.is_rental'),
            'postButtonText' => trans()->get('advertPostForm.post'),
            'uploadFileLabel' => trans()->get('advertPostForm.csvFile'),
            'uploadButtonText' => trans()->get('advertPostForm.upload'),
            'isBusiness' => $isBusinessAccount,
        ];

        return view('adverts.new-advert', $data);
    }

    public function getAdvertsInJson(Request $request, $key) : JsonResponse
    {
        $apiKey = $key;

        // Validate the API key
        $user = User::where('api_key', $apiKey)->first();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $adverts = $user->adverts;

        return response()->json($adverts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $maxTitleString = 'max:';
        $maxTitleString .= AdvertController::MAX_TITLE_LENGHT;

        $request->validate([
            'title' => ['required', 'string', $maxTitleString],
            'description' => ['string', 'max:255'],
            'customUrl' => ['nullable', 'url'],
        ]);

        $isRental = filter_var($request->rental, FILTER_VALIDATE_BOOLEAN);

        // Check whether Post Limit Has Been reached;
        if (! ($this->limitCheck($isRental))) {
            return redirect()->back()->with('error', trans()->get('advertPostForm.maximumReached'));
        }
        $advert = $this->createNewAdvert($request->title, $request->description, (int) $isRental);
        $advert->save();

        return redirect()->route('dashboard')->with('success', __('advert.success'));
    }

    public function storeCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');

        try {
            $fileData = $this->csvHandler->parseCsvFile($file);
            $this->processFileData($fileData);
            $this->saveAdvertsFromQueue();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } finally {
            $this->advertQueue->reset();
        }

        return redirect()->route('dashboard')->with('success', __('advert.successMultiple'));
    }

    private function limitCheck(bool $isRental)
    {
        $user = Auth::user();
        $advertCount = $user->countAdverts($isRental);

        if ($advertCount >= AdvertController::MAX_ADVERT_NUM) {
            return false;
        }

        return true;
    }

    private function createNewAdvert(string $title, string $description, bool $isRental) : Advert
    {
        if ($title === null || $description === null || $isRental === null) {
            throw new Exception(trans()->get('advertPostForm.uploadFailed'));
        }

        $isRental = (int) $isRental;
        $advert = new Advert();
        $advert->title = $title;
        $advert->description = $description;
        $advert->is_rental = $isRental;
        $advert->owner()->associate(Auth::user());

        return $advert;
    }

    private function processFileData($fileData) : void
    {
        $currentNumberOfNormalPosts = Auth::user()->countAdverts(false);
        $currentNumberOfRentals = Auth::user()->countAdverts(true);

        foreach ($fileData as $record) {
            try {
                $this->processRecord($record, $currentNumberOfNormalPosts, $currentNumberOfRentals);
            } catch (Exception $e) {
                throw $e;
            }
        }
    }

    private function processRecord($record, int &$currentNumberOfNormalPosts, int &$currentNumberOfRentals) : void
    {
        $failedMessage = trans()->get('advertPostForm.uploadFailed');
        $maxNumPostMessage = trans()->get('advertPostForm.maximumReached');
        $title = $record['Title'] ?? throw new Exception($failedMessage);
        $description = $record['Description'] ?? throw new Exception($failedMessage);
        $is_rental = filter_var($record['Is_Rental'], FILTER_VALIDATE_BOOL) ?? throw new Exception($failedMessage);

        if (($currentNumberOfNormalPosts >= AdvertController::MAX_ADVERT_NUM && ! ($is_rental)) || ($currentNumberOfRentals >= AdvertController::MAX_ADVERT_NUM && $is_rental)) {
            throw new Exception($maxNumPostMessage);
        }
        if (empty($title))
        {
            throw new Exception($failedMessage);
        }

        $advert = $this->createNewAdvert($title, $description, $is_rental);
        $this->advertQueue->enqueue($advert);

        if ($is_rental) {
            $currentNumberOfRentals++;
        } else {
            $currentNumberOfNormalPosts++;
        }
    }

    private function saveAdvertsFromQueue() : void
    {
        while (! $this->advertQueue->isEmpty()) {
            $this->advertQueue->dequeue()->save();
        }
    }
}
