<?php

namespace App\Jobs;

use Throwable;
use App\Models\Sale;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class SalesCsvProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this -> data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bulkInsert = [];

        foreach ($this -> data as $row){
            // Sale::create([
            //     'name' => $row[0],
            //     'amount' => $row[1],
            //     'description' => $row[2],
            // ]);

            $bulkInsert[] = [
                'name' => $row[0],
                'amount' => $row[1],
                'description' => $row[2],
            ];

            DB::table('sales')->insert($bulkInsert);
            $bulkInsert = [];
        }
    }
}
