<?php

namespace App\Services;

class QueryBus
{
    /**
     * dispatch function
     *
     * @param [type] $query
     * @return void
     */
    public function dispatch($query)
    {
        $handlerClass = str_replace('Queries', 'Handlers\Queries', get_class($query)) . 'Handler';
        return app($handlerClass)->handle($query);
    }
}
