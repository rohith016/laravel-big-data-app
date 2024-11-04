<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ExportCsvBatchProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $chunkArray;
    public $file;
    /**
     * Create a new job instance.
     */
    public function __construct($chunkArray, $file)
    {
        $this -> chunkArray = $chunkArray;
        $this -> file = $file;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileHandle = fopen($this->file, 'a');

        // lock the file handle
        if(flock($fileHandle, LOCK_EX)){
            foreach ($this-> chunkArray as $items) {
                fputcsv($fileHandle, [
                    $items -> name,
                    $items -> amount,
                    $items -> description,
                ]);
            }
            flock($fileHandle, LOCK_UN); // unlock the file handle
        }

        fclose($fileHandle);
    }
}
