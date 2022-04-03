<?php

namespace App\Http\Controllers;

use App\Models\SitePosts;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Repository\SitePosts\EloquentSitePostsRepository;
use App\Utils\Response;

class SitePostsController extends Controller
{
    use Response;

    protected $eloquentSitePosts;

    public function __construct(EloquentSitePostsRepository $eloquentSitePosts) {
        $this->eloquentSitePosts = $eloquentSitePosts;
    }

    public function show() {
        $sitePosts = $this->eloquentSitePosts->show();

        if (!$sitePosts->isEmpty()){
            return $this->responseWithDataCount($sitePosts);
        }

        return $this->responseDataNotFound('There is no available data');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|unique:site_posts,title',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->responseWithValidation($validator->errors());
        }

        $sitePosts = $this->eloquentSitePosts->store($request);
        if (!empty($sitePosts)){
            $this->eloquentSitePosts->sendEmailBroadcast($sitePosts);

            return $this->responseWithData($sitePosts, "Post created");
        }

        return $this->responseWithError();
    }
}
