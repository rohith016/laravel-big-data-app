<?php

namespace App\Handlers\Commands;

use App\Models\Sale;
use App\Commands\CreateSalesCommand;

class CreateSalesCommandHandler
{
    /**
     * Create a new class instance.
     */
    public function handle(CreateSalesCommand $command)
    {
        try {
            return Sale::create([
                'name' => $command->name,
                'amount' => $command->amount,
                'description' => $command->description,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
