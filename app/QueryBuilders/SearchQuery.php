<?php
namespace App\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SearchQuery extends Builder
{
    public function search(): self
    {
        if(request()->has('search')) {
            return $this->where('name', 'Like', '%'.request('search').'%');
        }
        return $this;
    }
}