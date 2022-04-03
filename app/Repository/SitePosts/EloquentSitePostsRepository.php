<?php

namespace App\Repository\SitePosts;

use App\Models\SitePosts;
use App\Models\SiteSubscribers;
use Illuminate\Http\Request;
use App\Jobs\SendEmail;
use Carbon\Carbon;

class EloquentSitePostsRepository implements SitePostsRepository
{
    public function show()
    {
        if ($id = request()->id) {
            return SitePosts::where('site_id', $id)->get();
        } else if ($url = request()->website_url) {
            return SitePosts::join('sites', 'sites.id', '=', 'sites_posts.site_id')->where('sites.website_url', $url)->get();
        }

        return SitePosts::all();
    }

    public function store(Request $request)
    {
        $sitePosts = new SitePosts;

        // ONLY SAVE FOR SEEDED SITE ID IF NOT INCLUDED
        $sitePosts->site_id = $request->site_id ?? 1;

        $sitePosts->title = $request->title;
        $sitePosts->description = $request->description;
        $sitePosts->save();
        
        return $sitePosts;
    }

    public function sendEmailBroadcast($sitePosts)
    {
        $subscribers = \App\Models\SiteSubscribers::with('site', 'subscriber')->where('site_id', $sitePosts->site_id)->get();
        foreach ($subscribers as $subscriber) {
            $data = [
                "from"    =>  config("mail.from.address"),
                "fromname"    =>  config("mail.from.name"),
                "template"    =>  "emailtemplate/newpost",
                "data"      =>  [
                    "subscriber_name" => $subscriber->subscriber->name,
                    "website_url" => $sitePosts->site->website_url,
                    "post_title" => $sitePosts->title,
                    "post_description" => $sitePosts->description
                ],
                "subject"   =>  "New post from {$sitePosts->site->website_url}",
                "recipient" =>  $subscriber->subscriber->email
            ];
            $job = (new SendEmail($data))->delay(Carbon::now()->addSeconds(10));
            dispatch($job);
        }
    }
}
