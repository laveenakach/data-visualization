<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = [
        'intensity', 'likelihood', 'relevance', 'year', 'country', 'topics', 'region', 'city'
    ];
}
