<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSubscribers extends Model
{
    protected $fillable = [
        'site_id',
        'subscriber_id'
    ];

    /**
     * Relation
     */
    public function site() {
        return $this->hasOne(Sites::class, 'id', 'site_id');
    }

    public function subscriber() {
        return $this->hasOne(Subscribers::class, 'id', 'subscriber_id');
    }
}
