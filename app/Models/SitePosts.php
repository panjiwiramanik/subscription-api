<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitePosts extends Model
{
    protected $fillable = [
        'site_id',
        'title',
        'description'
    ];

    /**
     * Relation
     */
    public function site() {
        return $this->hasOne(Sites::class, 'id', 'site_id');
    }
}
