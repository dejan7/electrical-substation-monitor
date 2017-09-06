<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substation extends Model
{
    protected $table = "substations";

    protected $guarded = ['id'];
}