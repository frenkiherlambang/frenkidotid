<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('test-schedule', function () {
    Log::info('scheduling test');
})->purpose('Scheduling test');

Artisan::command('parse-cpns', function () {
    // Get the JSON file path
    $jsonFilePath = database_path('cpns.json');

    // Check if the file exists
    if (!file_exists($jsonFilePath)) {
        $this->error('JSON file does not exist.');
        return;
    }

    // Read the JSON file content
    $jsonContent = file_get_contents($jsonFilePath);

    // Parse the JSON data into an array
    $data = json_decode($jsonContent, true);

    // Check if JSON parsing was successful
    if ($data === null) {
        $this->error('Error parsing JSON data.');
        return;
    }

    // Define the CSV file path
    $csvFilePath = storage_path('app/cpns.csv');

    // Open the CSV file for writing
    $csvFile = fopen($csvFilePath, 'w');

    // Write a header row if needed
    // fputcsv($csvFile, ['Column1', 'Column2', ...]);

    // Loop through the data and write each item to the CSV file
    foreach ($data as $item) {
        // Write the item to the CSV file
        fputcsv($csvFile, $item);
    }

    // Close the CSV file
    fclose($csvFile);

    $this->info('JSON data has been successfully converted to a CSV file.');
});
Artisan::command('delete-old-cctv-images', function () {
    $dirs = Storage::disk('public')->allDirectories('capture');
    rsort($dirs);
    foreach($dirs as $key => $dir) {
        if($key > 24)
        {
            Storage::disk('public')->deleteDirectory($dir);
        }

    }
});
Artisan::command('capture', function () {
    // create progress bar
    try {
        $data = Http::timeout(10)->get('https://mam.jogjaprov.go.id/api/v1/cctvs?page[size]=246&fields[cctvs]=stream-url,stream-name')->json()['data'];

    } catch (Exception $e) {
        Log::error('Exception'. $e->getMessage());
        Http::withHeaders(
            ['Content-Type' => 'application/json']
        )->post('https://ntfy.frenki.id', [
            'topic' => 'general',
            'title' => 'Error Fetch MAM',
            'message' => $e->getMessage()
        ]);
    }
    $bar = $this->output->createProgressBar(count($data));
    $errorCount = 0;
    foreach ($data as $d) {
        $bar->advance();
        $captureDirectory = now()->format('Y-m-d_H');

        if (!is_dir(storage_path('app/public/capture/' . $captureDirectory))) {
            mkdir(storage_path('app/public/capture/' . $captureDirectory), 0777, true);
        }
        try {
            $process = Process::run('ffmpeg -i ' . $d['attributes']['stream-url'] . ' -vframes 1 -q:v 2 ' . storage_path('app/public/capture/' . $captureDirectory . '/' . $d['attributes']['stream-name'] . '.jpg'));

            $storagePath = 'capture/' . $captureDirectory . '/' . $d['attributes']['stream-name'] . '.jpg';
            if(Storage::disk('public')->exists($storagePath)) {
                Storage::disk('r2')->put($storagePath, file_get_contents(storage_path('app/public/' . $storagePath)));
            } else {
                Http::withHeaders(
                    ['Content-Type' => 'application/json']
                )->post('https://ntfy.frenki.id', [
                    'topic' => 'cctv',
                    'title' => $d['attributes']['stream-name'] . 'tidak dapat diakses',
                    'message' => $d['attributes']['stream-name'] . 'tidak dapat diakses'
                ]);
            }
        } catch( Exception $e ) {
            Log::error('Exception'. $e->getMessage());

            // implement throttling
            if($errorCount < 3) {
                Http::withHeaders(
                    ['Content-Type' => 'application/json']
                )->post('https://ntfy.frenki.id', [
                    'topic' => 'general',
                    'title' => 'Error Capture CCTV',
                    'message' => $e->getMessage()
                ]);
                $errorCount++;
            }

        }
    }
    $bar->finish();
})->purpose('Capture command run successfully!');

Artisan::command('check-galon', function () {
    if (!Storage::disk('local')->exists('cart-count.json')) {
        Storage::disk('local')->put('cart-count.json', '0');
    }
    $cartCount = Storage::disk('local')->get('cart-count.json');
    if ($cartCount < 2) { // if cart count is less than expecte d
        // add galon count
        $addGalonToCart = Http::withHeaders([
            'Content-Type' => 'application/json',
            'User-Agent' => 'okhttp/3.12.10',
        ])->get('https://api.klikindomaret.com/api/ShoppingCart/ModifyCart?regionID=b4343c0c-6648-4206-87b0-c283d89ce2ee&scId=&cId=9fb33423-fab4-48d8-8424-b35ddd618739&cartRef=mobile&mod=add&id=&isPair=false&mfp_id=6a161e76-3261-4848-9600-7a12362d0f63&qty=1&pId=4cc4d6a7-3aba-47de-858b-5be150bbbcb3&buyFromPage=&Origin=Android&NearestStoreLocation=&ChildDOB=&CustomerLatitude=-7.78764&CustomerLongitude=110.452008&StoreCode=T26X&StoreCodeDest=&FlashSaleID=00000000-0000-0000-0000-000000000000&FlashsalePromoCode=');

        if ($addGalonToCart->json()[0]['Success']) { // if addGalonToCart was successful
            // check cart count
            $getMyCartCount = Http::withHeaders([
                'Content-Type' => 'application/json',
                'User-Agent' => 'okhttp/3.12.10',
            ])
                ->get('https://api.klikindomaret.com/api/ShoppingCart/GetMyCartCount?customerId=9fb33423-fab4-48d8-8424-b35ddd618739');
                // update cart count
            Storage::disk('local')->put('cart-count.json', intval($getMyCartCount->body()[1]));
            Http::withHeaders(
                ['Content-Type' => 'application/json']
            )->post('https://ntfy.frenki.id', [
                'topic' => 'general',
                'title' => 'Lapor! ada Galon!',
                'message' => "Lapor!ada galon di KlikIndomaret!"
            ]);
        }
    }

})->purpose('check galon di klik indomaret');
