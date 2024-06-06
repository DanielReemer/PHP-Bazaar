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

    public function mount()
    {
        $this->filter = '';
        $this->isChanged = false;
    }
    
    public function updatedFilter()
    {
        $this->isChanged = true;
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
                    ->with('advert')
                    ->paginate(ProductsComponent::NUMBER_OF_ADVERTS); 
                break;
            case 'my_product':
                $query = Advert::whereBelongsTo($user, 'owner')->with('owner');
                AdvertFilter::apply($query, $this->filter);
                $products = $query->paginate(ProductsComponent::NUMBER_OF_ADVERTS); 
                break;
            default:
                abort(404);
        }

        return $products;
    }
}
