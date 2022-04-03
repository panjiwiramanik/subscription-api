<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    protected $table = 'subscribers';
    protected $fillable = [
        'name',
        'email'
    ];

    public function subscriptions() {
        return $this->hasMany(SiteSubscribers::class, 'subscriber_id');
    }
}
