<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    protected $fillable = [
        'website_url',
        'website_name',
        'owner'
    ];
}
