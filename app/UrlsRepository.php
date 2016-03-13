<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UrlsRepository extends Model
{
    protected $table = "urls";
    protected $fillable = ['original_url','short_code'];
}
