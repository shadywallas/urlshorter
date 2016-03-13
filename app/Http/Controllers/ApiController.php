<?php

namespace App\Http\Controllers;

use app\Managers\UrlShortener;
use App\User;
use Illuminate\Validation\ValidationException;
use Request;
use Validator;

class ApiController extends Controller
{
    public function shortenUrl(\Illuminate\Http\Request $request)
    {
        try {
            $this->validate($request, [
                'url' => 'required',
                'code' => 'unique:urls,short_code',
            ]);
        } catch (ValidationException $e) {
            return ['status' => false, 'message' =>[ $e->getMessage()]];
        }
        $shorter = new UrlShortener();
        $code = $shorter->shortMyUrl($request->get('url'), $request->get('code', null));

        if (!$code) {
            return ['status' => false, 'message' => $shorter->getErrors()];
        }
        return ['status' => true, 'short_url' => url('open/'.$code)];


    }

}
