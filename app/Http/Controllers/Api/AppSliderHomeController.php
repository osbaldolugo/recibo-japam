<?php

namespace App\Http\Controllers\Api;

use App\Models\AppSliderHome;
use DB;
use URL;
use App\Repositories\AppSliderHomeRepository;
use App\Http\Controllers\AppBaseController;

class AppSliderHomeController extends AppBaseController
{
    //
    private $appSliderHomeRepository;

    public function __construct(AppSliderHomeRepository $appSliderRepo)
    {
        $this->appSliderHomeRepository = $appSliderRepo;
    }

    /**
     * get all images from slider home
     */
    public function getImagesSliderHome()
    {
        $images = AppSliderHome::select('id', 'status', DB::raw('CONCAT("'.URL::to('../storage/app/japam/app_slider_home').'/", image) as image'))
            ->where('status', '=', 'habilitada')
            ->orderBy('id', 'ASC')
            ->get();

        return response()->json(['data' => $images]);
    }
}
