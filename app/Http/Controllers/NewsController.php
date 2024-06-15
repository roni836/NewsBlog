<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        return view('news.index');
    }
    public function index2()
    {
        return view('news.index2');
    }

    public function getData()
    {
        $response = Http::get('https://timesofindia.indiatimes.com/rssfeeds/-2128838597.cms?feedtype=json');
        $data = $response->json();
        return response()->json(['data' => $data]);
    }
}
