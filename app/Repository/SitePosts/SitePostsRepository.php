<?php
namespace App\Repository\SitePosts;

use App\Models\SitePosts;
use Illuminate\Http\Request;

interface SitePostsRepository
{
    public function show();
    public function store(Request $request);
    public function sendEmailBroadcast($sitePosts);
}
