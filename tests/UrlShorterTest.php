<?php

use app\Managers\UrlShortener;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UrlShorterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUrlIsValidShouldAssertTrue()
    {

        /**  mocking used at the start to run  all test cases  $url_Shorter
        $url_Shorter = $this->getMock('app\Managers\UrlShortener',['validateUrl']);
        $url_Shorter->method('validateUrl')->willReturn(true);
         **/
        $url_Shorter= new UrlShortener();
        $url = "https://en.wikipedia.org/wiki/H-I";
        $this->assertTrue($url_Shorter->validateUrl($url));
    }
    public function testUrlInValidShouldAssertFalse()
    {
         /**  mocking used at the start to run  all test cases  $url_Shorter
        $url_Shorter = $this->getMock('app\Managers\UrlShortener',['validateUrl']);
           $url_Shorter->method('validateUrl')->willReturn(false);
           */
        $url_Shorter= new UrlShortener();
        $url = "httpdss://en.wikipedia.org/wiki/H-I";
        $this->assertFalse($url_Shorter->validateUrl($url));
    }
    public function testCheckShortCodeShouldAssertTrueWhenCode_5625(){
        $url_Shorter= new UrlShortener();
        $this->assertTrue($url_Shorter->checkShortCode(5625));

    }
    public function testCheckShortCodeShouldAssertFalseWhenCode_shady_reservved(){
        $url_Shorter= new UrlShortener();
        $this->assertFalse($url_Shorter->checkShortCode('shady_reservved'));
    }

    public function testGetOrSetCodeShouldAssertShadyWhenCodeIsShady(){
        $url_Shorter= new UrlShortener();
        $this->assertEquals('shady',$url_Shorter->getOrSetCode('shady'));
    }

    public function testshortMyUrlShouldAssertTrueWhenURLIsValid(){

        $url_Shorter = $this->getMock('app\Managers\UrlShortener',['generateUniqueCode']);
        $url_Shorter->method('generateUniqueCode')->willReturn("g5d6d");
        $url = "https://en.wikipedia.org/wiki/H-I";
        $this->assertEquals('g5d6d',$url_Shorter->shortMyUrl($url));
    }

    public function testshortMyUrlShouldAssertTrueWhenURLIsValidAndCodeISFree(){
        $url_Shorter= new UrlShortener();
        $url = "https://en.wikipedia.org/wiki/H-I";
        $code = "shady";
        $this->assertEquals('shady',$url_Shorter->shortMyUrl($url,$code));
    }

}
