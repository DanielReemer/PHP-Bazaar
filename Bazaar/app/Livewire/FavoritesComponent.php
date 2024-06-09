<?php

namespace App\Livewire;

use App\Models\FavoriteAdvert;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Advert;
use App\Filters\AdvertFilter;
use Livewire\WithPagination;

class FavoritesComponent extends Component
{
    use WithPagination;

    const NUMBER_OF_ADVERTS = 3;

    public $data;
    public $filter;
    public $isChanged;
    public $myProductsSort;

    public function mount($data)
    {
        $this->data = json_decode($data, true);
        $this->filter = '';
        $this->myProductsSort = 'desc';
    }

    public function updatedFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.favorites-component', [
            'favorites' => $this->getFavorites(),
        ]);
    }

    private function getFavorites() : LengthAwarePaginator
    {
        $query = FavoriteAdvert::where('user_id', Auth::id())
            ->leftJoin('adverts', 'favorite_adverts.advert_id', '=', 'adverts.id')
            ->select('favorite_adverts.*', 'adverts.created_at as advert_created_at')
            ->with('advert');

        $sorts = [
            ['type' => 'asc', 'row' => 'advert_created_at', 'direction' => 'asc'],
            ['type' => 'desc', 'row' => 'advert_created_at', 'direction' => 'desc'],
        ];

        AdvertFilter::apply($query, $this->filter);

        self::applyOrdering($query, $sorts);

        $products = $query->paginate(FavoritesComponent::NUMBER_OF_ADVERTS);

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
