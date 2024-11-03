<?php

namespace App\Services;

use App\Jobs\SalesCsvProcess;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Bus;

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

            $chunks = array_chunk($fileData, 500);
            $header = [];
            foreach($chunks as $key => $chunk) {
                // Get File Content and save it as an array
                $data = array_map('str_getcsv', $chunk);

                if ($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                // Start The Job
                // SalesCsvProcess::dispatch($data);
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
            throw $th;
        }
    }
}
