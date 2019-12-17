<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Report extends Model
{
   public static function count($distId, $catId)
    {
        return DB::table('facilities')
            ->join('sectors', 'sectors.id', '=', 'facilities.sector_id')
            ->join('districts', 'districts.id', '=', 'sectors.district_id')
            ->where([
                ['facilities.category_id','=',$catId],
                ['sectors.district_id','=',$distId]
            ])->count();
    }
}
