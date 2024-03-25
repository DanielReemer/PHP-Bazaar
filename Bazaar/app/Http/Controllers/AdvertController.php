<?php

namespace App\Http\Controllers;

use App\Abstracts\AbstractAdvertCsvHandler;
use App\Abstracts\AbstractQueue;
use App\Interfaces\ICsvHandler;
use App\Models\Advert;
use App\Models\LandingspageUrl;
use App\Models\Role;
use App\Models\AdvertQueue;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

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
            'showUrlInput' => $isBusinessAccount,
        ];

        return view('adverts.new-advert', $data);
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

        // Check wheter Post Limit Has Been reached;
        if (! ($this->limitCheck($isRental))) {
            return redirect()->back()->with('error', trans()->get('advertPostForm.maximumReached'));
        }
        $advert = $this->createNewAdvert($request->title, $request->description, (int) $isRental);
        $advert->save();

        if ($request->customUrl && Auth::user()->role()->value('value') === Role::ROLE_BUSINESS_ADVERTISER) {
            $landingPageUrl = new LandingspageUrl();
            $landingPageUrl->url = $request->customUrl;
            $landingPageUrl->advert()->associate($advert);
            $landingPageUrl->save();
        }

        return redirect()->route('dashboard');
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

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advert $advert) : View
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advert $advert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advert $advert)
    {
        //
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
