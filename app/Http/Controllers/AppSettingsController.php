<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAppSettingsRequest;
use App\Http\Requests\UpdateAppSettingsRequest;
use App\Models\AppSettings;
use App\Repositories\AppSettingsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AppSettingsController extends AppBaseController
{
    /** @var  AppSettingsRepository */
    private $appSettingsRepository;

    public function __construct(AppSettingsRepository $appSettingsRepo)
    {
        $this->appSettingsRepository = $appSettingsRepo;
    }

    /**
     * Get status.
     *
     * @return Response
     */

    public function getPaymentStatus(){
        $status = AppSettings::where('id', '=', 1)->first();

        $txtStatus = $status->pay_control == 'on' ? 'Activados' : 'Desactivados';

        return response()->json([
            'message' => 'Status: <b>Pagos '.$txtStatus.'<b>',
            'status' => $status->pay_control,
        ], 200);
    }

    /**
     * Display a listing of the AppSettings.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->appSettingsRepository->pushCriteria(new RequestCriteria($request));
        $appSettings = $this->appSettingsRepository->all();

        return view('app_settings.index')
            ->with('appSettings', $appSettings);
    }

    /**
     * Update setting.
     *
     * @param id $id
     * @param Request $request
     * @return Response
     */
    public function update($id, UpdateAppSettingsRequest $request)
    {
        $status = $request->input('status');

        $appSettings = $this->appSettingsRepository->findWithoutFail($id);

        if (empty($appSettings)) {
            return response()->json(['message' => 'Ocurrió un error al realizar la acción, intente más tarde.'], 404);
        }

        $appSettings->pay_control == 'on' ? $status = 'off' : $status = 'on' ;

        $appSettings->update(['pay_control' => $status]);
        $appSettings->save();

        $txtStatus = $appSettings->pay_control == 'on' ? 'Activados' : 'Desactivados';

        return response()->json([
            'message' => 'Status: <b>Pagos '.$txtStatus.'<b>',
            'status' => $appSettings->pay_control,
        ], 200);
    }
}
