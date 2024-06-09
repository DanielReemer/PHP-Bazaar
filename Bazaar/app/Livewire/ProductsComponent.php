<?php

namespace App\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Models\Advert;
use App\Models\HiredProduct;
use App\Models\BoughtProduct;
use Illuminate\Support\Facades\Auth;
use App\Filters\AdvertFilter;
use Livewire\WithPagination;

class ProductsComponent extends Component
{
    use WithPagination;

    const NUMBER_OF_ADVERTS = 3;

    public $data;
    public $filter;
    public $isChanged;
    public $myProductsSort;

    public function mount()
    {
        $this->filter = '';
        $this->myProductsSort = 'asc';
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.products-component', [
            'products' => $this->getProducts(),
        ]);
    }

    private function getProducts() : LengthAwarePaginator
    {
        $user = Auth::user();

        switch ($this->data['type']) {
            case 'hired':
                $query = HiredProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert');

                $sorts = [
                    ['type' => 'from_asc', 'row' => 'from', 'direction' => 'asc'],
                    ['type' => 'from_desc', 'row' => 'from', 'direction' => 'desc'],
                    ['type' => 'to_desc', 'row' => 'to', 'direction' => 'desc'],
                    ['type' => 'to', 'row' => 'to', 'direction' => 'desc']
                ];
                break;
            case 'bought':
                $query = BoughtProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert');

                $sorts = [
                    ['type' => 'asc', 'row' => 'created_at', 'direction' => 'asc'],
                    ['type' => 'desc', 'row' => 'created_at', 'direction' => 'desc']
                ];
                break;
            case 'hired_out':
                $query = HiredProduct::whereHas('advert', function ($advert) use ($user) {
                    $advert->whereBelongsTo($user, 'owner');
                })
                    ->with('user')
                    ->with('advert');

                $sorts = [
                    ['type' => 'from_asc', 'row' => 'from', 'direction' => 'asc'],
                    ['type' => 'from_desc', 'row' => 'from', 'direction' => 'desc'],
                    ['type' => 'to_desc', 'row' => 'to', 'direction' => 'desc'],
                    ['type' => 'to', 'row' => 'to', 'direction' => 'desc']
                ];
                break;
            case 'my_product':
                $query = Advert::whereBelongsTo($user, 'owner')->with('owner');

                $sorts = [
                    ['type' => 'asc', 'row' => 'created_at', 'direction' => 'asc'],
                    ['type' => 'desc', 'row' => 'created_at', 'direction' => 'desc']
                ];
                break;
            default:
                abort(404);
        }

        AdvertFilter::apply($query, $this->filter);

        self::applyOrdering($query, $sorts);

        $products = $query->paginate(ProductsComponent::NUMBER_OF_ADVERTS);

        return $products;
    }

    private function applyOrdering($query, $sorts) {
        foreach($sorts as $sort) {
            if ($this->myProductsSort == $sort['type']) {
                $query->orderBy($sort['row'], $sort['direction']);
            }
        }
    }
}
