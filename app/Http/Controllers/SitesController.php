<?php

namespace App\Http\Controllers;

use App\Models\Sites;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Repository\Sites\EloquentSitesRepository;
use App\Utils\Response;

class SitesController extends Controller
{
    use Response;

    protected $eloquentSites;

    public function __construct(EloquentSitesRepository $eloquentSites) {
        $this->eloquentSites = $eloquentSites;
    }

    public function show() {
        $sites = $this->eloquentSites->show();

        if (!$sites->isEmpty()){
            return $this->responseWithDataCount($sites);
        }

        return $this->responseDataNotFound('There is no available data');
    }
}
