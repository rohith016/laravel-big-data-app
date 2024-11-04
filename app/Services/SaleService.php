<?php

namespace App\Services;

use App\Jobs\SalesCsvProcess;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Storage;

class SaleService
{
    /**
     * uploadCsv function
     *
     * @param [type] $file
     * @return void
     */
    public function uploadCsv($file)
    {
        try {
            // method 1 - upload the file to storage folder and read the file
            // $filePath = $file->store('csv_uploads');
            // $fileData = Storage::path($filePath);
            // $fileData = file($fileData);
            // method 2 - retirieve the file data without saving it to storage
            $fileData = file($file);

            $batch = Bus::batch([])->dispatch();

            $chunks = array_chunk($fileData, 10000);
            $header = [];
            foreach($chunks as $key => $chunk) {
                // Get File Content and save it as an array
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                // add The Job to the batch
                $batch->add(new SalesCsvProcess($data));
            }
            return ['status' => true, 'message' => 'CSV file has been uploaded successfully.', 'data' => $batch->id ?? null];
        } catch (\Throwable $th) {
            // throw $th;
            return ['status' => false,'message' => $th->getMessage()];
        }

    }
    /**
     * processCSV function
     *
     * @param [type] $file
     * @return void
     */
    // public function processCSV($file){
    //     $filePath = $file->store('csv_uploads');
    //     $batch = Bus::batch([])->dispatch();
    //     $jobs = [];
    //     $chunkSize = 500;

    //     LazyCollection::make(function () use ($filePath) {
    //         $file = fopen(Storage::path($filePath), 'r');

    //         // Loop through each line until EOF
    //         while (($line = fgetcsv($file)) !== false) {
    //             yield $line;
    //         }

    //         // Close the file after reading
    //         fclose($file);
    //     })->chunk($chunkSize)
    //       ->each(function ($lines) use (&$jobs) {
    //           // Convert chunked lines into array format
    //           $data = $lines->toArray();

    //           // Create a job with the chunk of data
    //           $jobs[] = new SalesCsvProcess($data);
    //     });

    //     $batch->add($jobs);

    //     return ['status' => true, 'message' => 'CSV file has been uploaded successfully.', 'data' => $batch->id ?? null];

    // }
    /**
     * getBatch function
     *
     * @param [type] $batchId
     * @return void
     */
    public function getBatch($batchId) {
        try {
            //code...
            return Bus::findBatch($batchId);
        } catch (\Throwable $th) {
            // throw $th;
            return null;

        }
    }
}
