<?php

namespace App\Http\Controllers;

use App\District;
use App\Sector;
use Illuminate\Http\Request;

class CellsController extends Controller
{
    public function cellsBySector(Sector $sector)
    {
        return $sector->cells()->get();
    }
}
