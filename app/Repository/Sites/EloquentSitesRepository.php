<?php

namespace App\Repository\Sites;

use App\Models\Sites;
use Illuminate\Http\Request;

class EloquentSitesRepository implements SitesRepository
{
    public function show()
    {
        return Sites::all();
    }
}
