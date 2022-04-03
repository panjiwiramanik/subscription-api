<?php

namespace App\Repository\Subscribers;

use App\Models\Sites;
use App\Models\Subscribers;
use App\Models\SiteSubscribers;
use Illuminate\Http\Request;

class EloquentSubscribersRepository implements SubscribersRepository
{
    public function show()
    {
        return Subscribers::all();
    }

    public function store(Request $request)
    {
        $subscriber = new Subscribers;
        $subscriber->name = $request->name;
        $subscriber->email = $request->email;
        $subscriber->save();
        
        return $subscriber;
    }

    public function subscribeSite($siteId, $subscriberId)
    {
        $siteSubscriber = new SiteSubscribers;
        $siteSubscriber->site_id = $siteId;
        $siteSubscriber->subscriber_id = $subscriberId;
        $siteSubscriber->save();

        return $siteSubscriber->load('site', 'subscriber');
    }

    public function checkSite(Request $request)
    {
        $site = Sites::where('website_url', $request->website_url)->first();

        return $site ? $site->id : false;
    }

    public function checkAlreadySubscribe(Request $request, $siteId)
    {
        $subscriber = Subscribers::where('email', $request->email)->first();
        if ($subscriber) {
            if (count($subscriber->subscriptions->where('site_id', $siteId))) {
                return [
                    'is_subscribed' => true, 
                    'id' => $subscriber->id
                ];
            }
            
            return [
                'is_subscribed' => false, 
                'id' => $subscriber->id
            ];
        } else {
            $subscriber = new Subscribers;
            $subscriber->name = $request->email;
            $subscriber->email = $request->email;
            $subscriber->save();
            
            return [
                'is_subscribed' => false, 
                'id' => $subscriber->id
            ];
        }
    }
}
