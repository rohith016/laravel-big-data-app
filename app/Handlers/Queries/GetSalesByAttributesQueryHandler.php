<?php

namespace App\Handlers\Queries;

use App\Queries\GetSalesByAttributesQuery;
use App\Models\Sale;

class GetSalesByAttributesQueryHandler
{
    /**
     * handle function
     *
     * @param GetSalesByAttributesQuery $query
     * @return void
     */
    public function handle(GetSalesByAttributesQuery $query)
    {
        $saleQuery = Sale::query();

        $saleQuery->when($query->name, function ($query, $name){
            return $query->where('name', 'like', "%{$name}%");
        });

        $saleQuery->when($query->amount, function ($query, $amount){
            return $query->where('amount', 'like', "%{$amount}%");
        });

        $saleQuery->when($query->description, function ($query, $description){
            return $query->where('description', 'like', "%{$description}%");
        });


        return $saleQuery->latest()->paginate(100);

    }
}
