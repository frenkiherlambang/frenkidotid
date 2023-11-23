<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FomoCompanyReview;
use Illuminate\Support\Facades\Http;

class FomoController extends Controller
{
    public function companyReview(Request $request)
    {
        $companies = FomoCompanyReview::orderBy('number_of_dislikes', 'desc')->paginate()->withQueryString();
        return view('fomo.company.index', compact('companies'));
    }

    public function companyComments(Request $request, int $activityId)
    {
        $headers = [
            'Authorization' => 'Basic Mzc4NDk6YnNJcm5zenJYbFBTQUhCTnhMU0hieUNMV3NlUkVD',
            'Cookie' => 'ARRAffinity=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7; ARRAffinitySameSite=cf18e8207138f47a7b4a4eebc73ec3a1b7a03719e40af63eca3d1dcb9e7d8ee7'
        ];
        $request = Http::withHeaders($headers)->get('https://fomo.azurewebsites.net/activity/'.$activityId.'/commentsV3?sortMode=RECENT');
        return view('fomo.company.comments', [
            'data' =>  json_decode($request->body())->data,
        ]);

    }
}
