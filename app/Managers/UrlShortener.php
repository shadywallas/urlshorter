<?php
namespace app\Managers;

use App\UrlsRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\CountValidator\Exception;

class UrlShortener
{
    private $errors = [];

    public function validateUrl($url)
    {
        $client = new Client();
        try {
            $res = $client->request('GET', $url);
        } catch (ConnectException $e) {

            return false;
        } catch (RequestException $e) {
            return false;
        } catch (Exception $e) {
            Log::error($e);
            return false;
        }

        if ($res->getStatusCode() == 200) {
            return true;
        }
        return false;
    }

    /**
     * sould return true if valid
     * @param $code
     * @return bool
     */
    public function checkShortCode($code)
    {
        if (DB::table('urls')->where('short_code', $code)->pluck('id')) {
            return false;
        }
        return true;

    }

    /**
     * @param null $code
     * @return bool|null|string
     */
    public function getOrSetCode($code = null)
    {
        if (!$code) {
            $code = $this->generateUniqueCode();
        }
        if (!$this->checkShortCode($code)) {
            return false;
        }
        return $code;
    }

    public function generateUniqueCode()
    {
        do {
            $code = str_random(5);
        } while (!$this->checkShortCode($code));
        return $code;

    }

    public function shortMyUrl($url, $code = null)
    {

        if (!$this->validateUrl($url)) {
            $this->setErrors('Invalid url');
            return false;
        };
        $code = $this->getOrSetCode($code);
        if (!$code) {
            $this->setErrors('provided code already taken');
            return false;
        }

        UrlsRepository::create(['original_url' => $url, 'short_code' => $code]);

        return $code;
    }

    public function getErrors()
    {
        return $this->errors;

    }
    public function setErrors($error)
    {
        array_push($this->errors,$error);
        return $this->getErrors();

    }

}