<?php
namespace App\Repository\Subscribers;

use App\Models\Subscribers;
use Illuminate\Http\Request;

interface SubscribersRepository
{
    public function show();
    public function store(Request $request);
    public function checkSite(Request $request);
    public function checkAlreadySubscribe(Request $request, $siteId);
    public function subscribeSite($siteId, $subscriberId);
}
