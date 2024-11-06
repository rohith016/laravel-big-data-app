<?php

namespace App\Queries;

class GetSalesByAttributesQuery
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $amount = null,
        public ?string $description = null
    )
    {}
}
