<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

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


Artisan::command('capture', function () {
    // create progress bar
    $data = Http::get('https://mam.jogjaprov.go.id/api/v1/cctvs?page[size]=246&fields[cctvs]=stream-url,stream-name')->json()['data'];
    $bar = $this->output->createProgressBar(count($data));
    foreach($data as $d){
        $bar->advance();
        if(!is_dir(storage_path('app/public/capture/'.now()->format('Y-m-d')))){
            mkdir(storage_path('app/public/capture/'.now()->format('Y-m-d')));
        }
        $process = Process::run('ffmpeg -i '.$d['attributes']['stream-url'].' -vframes 1 -q:v 2 '.storage_path('app/public/capture/'.now()->format('Y-m-d').'/'.$d['attributes']['stream-name'].'.jpg'));
    }
    $bar->finish();
})->purpose('Capture command run successfully!');