<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Storage;

class EmailService
{
    /**
     * sendBulkEmails function
     *
     * @param [type] $file
     * @return void
     */
    public function sendBulkEmails($file){
        try {
            // upload file to storage
            // $filePath = $file->store('emails_csv');
            // $fileData = file(Storage::path($filePath));
            $fileData = file($file);

            $batch = Bus::batch([])->dispatch();

            $chunks = array_chunk($fileData, 500);
            $header = [];
            foreach($chunks as $key => $chunk){
                $data = array_map('str_getcsv', $chunk);

                if($key === 0){
                    $header = $data[0];
                    unset($data[0]);
                }

                dd($data);

                $batch->add(new SendEmailJob($data));
            }

            return ['status' => true, 'message' => 'CSV file has been uploaded successfully.'];
        } catch (\Throwable $th) {
            //throw $th;
            return ['status' => false, 'message' => $th->getMessage()];
        }

    }

}
