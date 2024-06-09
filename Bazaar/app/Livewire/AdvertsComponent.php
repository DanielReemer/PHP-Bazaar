<?php

namespace App\Livewire;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use App\Models\Advert;
use App\Filters\AdvertFilter;
use Livewire\WithPagination;

class AdvertsComponent extends Component
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
        return view('livewire.adverts-component', [
            'adverts' => $this->getAdverts(),
        ]);
    }

    private function getAdverts() : LengthAwarePaginator
    {
        $query = Advert::where('post_status_id', '!=', 4)->with('owner');

        $sorts = [
            ['type' => 'asc', 'row' => 'created_at', 'direction' => 'asc'],
            ['type' => 'desc', 'row' => 'created_at', 'direction' => 'desc'],
        ];

        AdvertFilter::apply($query, $this->filter);

        self::applyOrdering($query, $sorts);

        $products = $query->paginate(AdvertsComponent::NUMBER_OF_ADVERTS);

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
