<?php

use App\Models\Cctv;
use App\Models\FomoCompany;
use App\Models\FomoCompanyReview;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
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
    $dirs = Storage::disk('public')->directories('capture');
    $dirs_r2 = Storage::disk('r2')->directories('frenkibucket/capture');
    rsort($dirs_r2);
    rsort($dirs);
    foreach ($dirs as $key => $dir) {
        if ($key > 24) {
            Storage::disk('public')->deleteDirectory($dir);
        }
    }
    foreach ($dirs_r2 as $key => $dir) {
        if ($key >= 48) {
            Storage::disk('r2')->deleteDirectory($dir);
        }
    }
});
Artisan::command('update_cctv_db', function () {
    try {
        $data = Http::timeout(10)->get('https://mam.jogjaprov.go.id/api/v1/cctvs?page[size]=246&fields[cctvs]=stream-url,stream-name')->json()['data'];
        foreach ($data as $d) {
            Cctv::updateOrCreate([
                'stream_name' => $d['attributes']['stream-name'],
            ], [
                'stream_url' => $d['attributes']['stream-url'],
            ]);
        }
    } catch (Exception $e) {
        Log::error('Exception' . $e->getMessage());
        Http::withHeaders(
            ['Content-Type' => 'application/json']
        )->post('https://ntfy.frenki.id', [
            'topic' => 'general',
            'title' => 'Error Fetch MAM',
            'message' => $e->getMessage()
        ]);
    }
});
Artisan::command('capture', function () {
    // create progress bar
    try {
        // $data = Http::timeout(10)->get('https://mam.jogjaprov.go.id/api/v1/cctvs?page[size]=246&fields[cctvs]=stream-url,stream-name')->json()['data'];
    } catch (Exception $e) {
        // Log::error('Exception' . $e->getMessage());
        // Http::withHeaders(
        //     ['Content-Type' => 'application/json']
        // )->post('https://ntfy.frenki.id', [
        //     'topic' => 'general',
        //     'title' => 'Error Fetch MAM',
        //     'message' => $e->getMessage()
        // ]);
    }
    $data = Cctv::where('error_count', 0)->get()->toArray();
    // dd(count($data));
    $bar = $this->output->createProgressBar(count($data));
    $errorCount = 0;
    $errorData = array();
    foreach ($data as $d) {
        $bar->advance();
        $captureDirectory = now()->format('Y-m-d_H');

        if (!is_dir(storage_path('app/public/capture/' . $captureDirectory))) {
            mkdir(storage_path('app/public/capture/' . $captureDirectory), 0777, true);
        }
        try {
            $process = Process::run('ffmpeg -i ' . $d['stream_url'] . ' -vframes 1 -q:v 2 ' . storage_path('app/public/capture/' . $captureDirectory . '/' . $d['stream_name'] . '.jpg'));
            // Cctv::updateOrCreate([
            //     'stream_name' => $d['stream-name'],
            // ],[
            //     'stream_url' => $d['stream-url'],
            // ]);

            $storagePath = 'capture/' . $captureDirectory . '/' . $d['stream_name'] . '.jpg';
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('r2')->put($storagePath, file_get_contents(storage_path('app/public/' . $storagePath)));
            } else {
                $errorData[] = $d['stream_name'];
                Cctv::where('stream_name', $d['stream_name'])->increment('error_count');
            }
        } catch (Exception $e) {
            Log::error('Exception' . $e->getMessage());

            // implement throttling
            if ($errorCount < 3) {
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
    if (count($errorData) > 0) {

        Http::withHeaders(
            ['Content-Type' => 'application/json']
        )->post('https://ntfy.frenki.id', [
            'topic' => 'cctv',
            'title' => 'daftar cctvs yang tidak dapat diakses',
            'message' => implode("\n", $errorData),
        ]);
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
                'title' => 'Lapor! Ada Galon!',
                'message' => "Lapor! Ada galon di KlikIndomaret!"
            ]);
        }
    }
})->purpose('check galon di klik indomaret');

Artisan::command('download-image {name?}', function ($name = null) {
    Storage::makeDirectory($name);
    $storagePath = storage_path($name);
    // dd($storagePath.'/'.$name);
    $dirs_r2 = Storage::disk('r2')->directories('capture');
    $bar = $this->output->createProgressBar(count($dirs_r2));
    foreach ($dirs_r2 as $dir) {
        Process::run('cd storage/app/' . $name . ' && curl https://bucket.frenki.id/' . $dir . '/' . $name . '.jpg > ' . $name . '-' . str_replace('capture/', '', $dir) . '.jpg');
        $bar->advance();
    }
    $bar->finish();
});


Artisan::command('fomo:getreview', function () {
    if (!Storage::disk('local')->exists('fomo_companyReviewCount.json')) {
        Storage::disk('local')->put('fomo_companyReviewCount.json', '0');
    }
    $headers = [
        'Authorization' => 'Basic Mzc4NDk6YnNJcm5zenJYbFBTQUhCTnhMU0hieUNMV3NlUkVD',
        'Cookie' => 'ARRAffinity=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7; ARRAffinitySameSite=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7',
        'User-Agent' => 'okhttp/3.12.10',
    ];
    $request = Http::withHeaders($headers)->get('https://fomo.azurewebsites.net/salary?page=2&limit=30');
    // print_r(json_decode($request->body())->data);
    foreach (json_decode($request->body())->data as $value) {


        // dd($value->inner->user->profilePictureUrl);


        if ($value->inner->type == 'SALARY') {
            if($value->inner->user->profilePictureUrl) {
                $response = Http::get($value->inner->user->profilePictureUrl);

                $imageContent = $response->body();

                $imageName = substr($value->inner->user->profilePictureUrl, strrpos($value->inner->user->profilePictureUrl, '/') + 1);

                Storage::disk('public')->put('company-images/' . $imageName, $imageContent);

                $imageUrl = Storage::disk('public')->url('company-images/' . $imageName);
            }

            // print_r($value->inner);
            FomoCompany::updateOrCreate([
                'company_id' => $value->inner->user->companyId,
                'jobTitle' => $value->inner->jobTitle->value,

            ], [
                'company_name' => $value->inner->user->companyName,
                'baseMonthlySalaryInRupiah' => $value->inner->baseMonthlySalaryInRupiah,
                'annualBonusInRupiah' => $value->inner->annualBonusInRupiah,
                'roleLevel' => $value->inner->roleLevel != null ? $value->inner->roleLevel->value : null,
                'yearsOfExperience' => $value->inner->yearsOfExperience,
                'company_image' => isset($imageUrl) ? $imageUrl : null,
            ]);
        }
    }
});


Artisan::command('fomo:companyreview', function () {

    if (!Storage::disk('local')->exists('fomo_companyReviewCount.json')) {
        Storage::disk('local')->put('fomo_companyReviewCount.json', '0');
    }

    $prevReviewCount = Storage::disk('local')->get('fomo_companyReviewCount.json');
    $currentReviewCount = FomoCompanyReview::count();
    // dump('prev: '.$prevReviewCount);
    // dump('current: '.$currentReviewCount);
    // while (Storage::disk('local')->get('fomo_companyReviewCount.json') != FomoCompanyReview::count()) {
    // dump('prev: '.Storage::disk('local')->get('fomo_companyReviewCount.json'));
    // dump('current: '.FomoCompanyReview::count());
    // sleep(5);

    Storage::disk('local')->put('fomo_companyReviewCount.json', intval(FomoCompanyReview::count()));
    $headers = [
        'Authorization' => 'Basic Mzc4NDk6YnNJcm5zenJYbFBTQUhCTnhMU0hieUNMV3NlUkVD',
        'Cookie' => 'ARRAffinity=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7; ARRAffinitySameSite=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7'
    ];
    $request = Http::withHeaders($headers)->get('https://fomo.azurewebsites.net/companyReview?page=2');
    // print_r(json_decode($request->body())->data);
    $i = 1;
    foreach (json_decode($request->body())->data as $value) {

        if ($value->inner->type == 'COMPANY_REVIEW') {
            $i++;
            // print_r($value->inner);

            FomoCompanyReview::updateOrCreate([
                'company_id' => $value->inner->user->companyId,
                'activity_id' => $value->inner->activityId
            ], [
                'company_id' => $value->inner->user->companyId,
                'company_name' => $value->inner->user->companyName,
                'pros' => implode(' | ', $value->inner->pros),
                'cons' => implode(' | ', $value->inner->cons),
                'rating' => $value->inner->rating,
                'job_title' => $value->inner->jobTitle->value,
                'title' => $value->inner->title,
                'content' => $value->inner->content,
                'number_of_likes' => $value->inner->numberOfLikes,
                'number_of_dislikes' => $value->inner->numberOfDislikes,
                'number_of_comments' => $value->inner->numberOfComments
            ]);
        }
    }
    // }


    // dump('CurrentReviewCount:'.$reviewCount);
    // if($reviewCount == FomoCompanyReview::count()) {
    //     dump('reviewCountStopped:'.$reviewCount);
    //     return;
    // }


});
