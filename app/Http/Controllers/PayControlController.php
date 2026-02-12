<?php

namespace App\Http\Controllers;

use DB;
use App\Models\PayControl;
use Illuminate\Http\Request;
use App\DataTables\PayControlDataTable;
use App\Http\Controllers\AppBaseController;

class PayControlController extends AppBaseController
{

    public function __construct()
    {
    }

    public function index(PayControlDataTable $payControlDataTable)
    {
        return $payControlDataTable->render('paycontrol.index');
    }

    public function getTotals(Request $requests){
        $payControl = PayControl::select('platform',DB::raw('COUNT(*) AS total'))
            ->where('pay_status', 'pagado')
            ->where('platform', '!=','app')
            ->whereBetween('pay_date', [$requests->begin, $requests->end])
            ->groupBy('platform')
            ->get();

        $totals = [
            'android' => 0,
            'ios' => 0,
            'web' => 0,
            'total' => 0
        ];
        foreach ($payControl as $pay){
            $totals['total'] += $pay->total;
            $totals[$pay->platform] = $pay->total;
        }
        return response()->json($totals);
    }
}
