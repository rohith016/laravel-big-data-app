<?php

namespace App\Commands;

class CreateSalesCommand
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?float $amount = 0,
        public ?string $description = null
    )
    {}
}
