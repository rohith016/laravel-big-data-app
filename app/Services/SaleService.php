<?php

namespace App\Services;

use App\Jobs\{
    SalesCsvProcess,
    ExportCsvBatchProcess
};
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Storage;
use App\Models\Sale;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;


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
    /**
     * exportSalesData function
     *
     * @return void
     */
    public function exportSalesData(){
        $name = "app/public/".time()."exported_csv.csv";
        $file = storage_path($name);
        $fileHandle =  fopen($file, 'w');

        fputcsv($fileHandle, [
            "name",
            "amount",
            "description",
        ]);

        fclose($fileHandle);

        // $batch = Bus::batch([])->dispatch();
        $batch = Bus::batch([])->then(function ($batch) use ($file) {
            // This code runs when the entire batch has finished processing

            // Here you could send a notification or update the status
            // $user = auth()->user();
            // Notification::send($user, new FileReadyNotification($file));
            Notification::create([
                'notification' => 'csv exported',
                'data' => $file
            ]);


            // Optionally, log or broadcast the completion event
        })->catch(function ($batch, $exception) {
            // Handle any errors that occur within the batch
        })->dispatch();


        Sale::chunk(10000, function ($dataChunk) use ($file, $batch) {
            $batch->add(new ExportCsvBatchProcess($dataChunk, $file));
        });


        return $batch -> id;
    }
}
