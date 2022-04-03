<?php

namespace App\Http\Controllers;

use App\Models\Subscribers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Repository\Subscribers\EloquentSubscribersRepository;
use App\Utils\Response;

class SubscribersController extends Controller
{
    use Response;

    protected $eloquentSubscribers;

    public function __construct(EloquentSubscribersRepository $eloquentSubscribers) {
        $this->eloquentSubscribers = $eloquentSubscribers;
    }

    public function show() {
        $subscribers = $this->eloquentSubscribers->show();

        if (!$subscribers->isEmpty()){
            return $this->responseWithDataCount($subscribers);
        }

        return $this->responseDataNotFound('There is no available data');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return $this->responseWithValidation($validator->errors());
        }

        $subscribers = $this->eloquentSubscribers->store($request);
        if (!empty($subscribers)){
            return $this->responseWithData($subscribers, "Subscriber created");
        }

        return $this->responseWithError();
    }

    public function subscribeSite(Request $request) {
        $validator = Validator::make($request->all(), [
            'website_url' => 'required|max:255',
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithValidation($validator->errors());
        }

        $siteId = $this->eloquentSubscribers->checkSite($request);

        if (!$siteId) {
            return $this->responseWithError('Website url not found');
        }

        $isAlreadySubscribe = $this->eloquentSubscribers->checkAlreadySubscribe($request, $siteId);

        if ($isAlreadySubscribe['is_subscribed']) {
            return $this->responseWithError('Email already subscribed');
        }

        $subscribers = $this->eloquentSubscribers->subscribeSite($siteId, $isAlreadySubscribe['id']);
        if (!empty($subscribers)){
            return $this->responseWithData($subscribers, "Successfully subscribe site");
        }

        return $this->responseWithError();
    }
}
