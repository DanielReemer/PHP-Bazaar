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
        $products = null;
        $user = Auth::user();

        switch ($this->data['type']) {
            case 'hired':
                $products = HiredProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert')
                    ->paginate(ProductsComponent::NUMBER_OF_ADVERTS);
                break;
            case 'bought':
                $products = BoughtProduct::where('user_id', Auth::id())
                    ->with('user')
                    ->with('advert')
                    ->paginate(ProductsComponent::NUMBER_OF_ADVERTS);
                break;
            case 'hired_out':
                $products = HiredProduct::whereHas('advert', function ($advert) use ($user) {
                    $advert->whereBelongsTo($user, 'owner');
                })
                    ->with('user')
                    ->with('advert');

                AdvertFilter::apply($products, $this->filter);

                
                if ($this->myProductsSort == 'from_asc') {
                    $products->orderBy('from', 'asc');
                } elseif ($this->myProductsSort == 'from_desc') {
                    $products->orderBy('from', 'desc');
                } elseif ($this->myProductsSort == 'to_desc') {
                    $products->orderBy('to', 'desc');
                } elseif ($this->myProductsSort == 'to') {
                    $products->orderBy('to', 'desc');
                } 

                $products = $products->paginate(ProductsComponent::NUMBER_OF_ADVERTS);
                break;
            case 'my_product':
                $query = Advert::whereBelongsTo($user, 'owner')->with('owner');
                AdvertFilter::apply($query, $this->filter);

                if ($this->myProductsSort == 'asc') {
                    $query->orderBy('expiration_date', 'asc');
                } elseif ($this->myProductsSort == 'desc') {
                    $query->orderBy('expiration_date', 'desc');
                }

                $products = $query->paginate(ProductsComponent::NUMBER_OF_ADVERTS);
                break;
            default:
                abort(404);
        }

        return $products;
    }
}
