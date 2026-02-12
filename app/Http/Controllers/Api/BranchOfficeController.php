<?php

namespace App\Http\Controllers\Api;

use App\Models\BranchOfficeSchedule;
use DB;
use URL;
use App\Models\Schedule;
use App\Models\BranchOffice;
use Illuminate\Http\Request;
use App\Repositories\BranchOfficeRepository;
use App\Http\Controllers\AppBaseController;

class BranchOfficeController extends AppBaseController
{
    //
    private $branchOfficeRepository;

    public function __construct(BranchOfficeRepository $branchOfficeRepo)
    {
        $this->branchOfficeRepository = $branchOfficeRepo;
    }

    /**
     * get all branches
     */
    public function getBranches()
    {
        $branches = BranchOffice::select('id', 'description', DB::raw('CONCAT("'.URL::to('../storage/app/japam/branch_office').'/", image) as url_image'))
            ->get();

        return response()->json(['data' => $branches]);
    }
    /**
     * get details branch office
     */
    public function getDetailsBranchOffice($branchOffice)
    {
        $branchOffice = BranchOffice::select('branch_office.*', DB::raw('CONCAT("'.URL::to('../storage/app/japam/branch_office').'/", image) as image'))
            ->find($branchOffice);

        $forWeek = array();
        $forSaturday = array();
        $schedules = $branchOffice->schedule;
        $countSchedules = count($branchOffice->schedule);
        for ($i = 0; $i < $countSchedules; $i++)
        {
            if ($schedules[$i]->work_day == 'week')
                array_push($forWeek, [
                    'id' => $schedules[$i]->id,
                    'area' => $schedules[$i]->area,
                    'work_day' => $schedules[$i]->work_day,
                    'begin_time' => $schedules[$i]->begin_time,
                    'end_time' => $schedules[$i]->end_time
                ]);

            if ($schedules[$i]->work_day == 'saturday')
                array_push($forSaturday, [
                    'id' => $schedules[$i]->id,
                    'area' => $schedules[$i]->area,
                    'work_day' => $schedules[$i]->work_day,
                    'begin_time' => $schedules[$i]->begin_time,
                    'end_time' => $schedules[$i]->end_time
                ]);
        }

        $branchOffice->weekSchedule = $forWeek;
        $branchOffice->saturdaySchedule = $forSaturday;

        return response()->json(['branchOffice' => $branchOffice]);
    }
}
