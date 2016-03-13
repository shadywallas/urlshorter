<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitsRepository extends Model
{
    protected $table = "visits";
    protected $fillable = ['url_id','request','ip'];
}
