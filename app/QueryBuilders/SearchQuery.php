<?php
namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SearchQuery extends Builder
{
    public function search()
    {
        if (request('search')) {
            return $this->where('name', 'LIKE', '%' .request('search'). '%')->get();
        }
        return $this->all();
    }
}