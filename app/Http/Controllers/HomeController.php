<?php

namespace App\Http\Controllers;

use App\UrlsRepository;
use App\VisitsRepository;
use Illuminate\Support\Facades\Redirect;
use Request;
use Validator;

class HomeController extends Controller
{
    public function home(){
        return view('home');
    }
    public function open(\Illuminate\Http\Request $request,$code)
    {

        $url = UrlsRepository::where('short_code',$code)->first();
        if(!$url){
            return App::abort(404);
        }

        VisitsRepository::create(['url_id' => $url->id, 'request' => json_encode($request),'ip'=>$request->ip()]);
        return Redirect::to($url->original_url);

    }


}
