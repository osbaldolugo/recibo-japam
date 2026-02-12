<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PMOSpecialityDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOSpecialityRequest;
use App\Http\Requests\UpdatePMOSpecialityRequest;
use App\Repositories\PMOSpecialityRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOSpecialityController extends AppBaseController
{
    /** @var  PMOSpecialityRepository */
    private $pMOSpecialityRepository;

    public function __construct(PMOSpecialityRepository $pMOSpecialityRepo)
    {
        $this->pMOSpecialityRepository = $pMOSpecialityRepo;
    }

    /**
     * Display a listing of the PMOSpeciality.
     *
     * @param PMOSpecialityDataTable $pMOSpecialityDataTable
     * @return Response
     */
    public function index(PMOSpecialityDataTable $pMOSpecialityDataTable)
    {
        return $pMOSpecialityDataTable->render('p_m_o_specialities.index');
    }

    /**
     * Show the form for creating a new PMOSpeciality.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_specialities.create');
    }

    /**
     * Store a newly created PMOSpeciality in storage.
     *
     * @param CreatePMOSpecialityRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOSpecialityRequest $request)
    {
        $input = $request->all();

        $pMOSpeciality = $this->pMOSpecialityRepository->create($input);

        return response()->json(array("success" => 1, "pMOSpecialty"=> $pMOSpeciality));
    }

    /**
     * Display the specified PMOSpeciality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);

        if (empty($pMOSpeciality)) {
            Flash::error('P M O Speciality not found');

            return redirect(route('pMOSpecialities.index'));
        }

        return view('p_m_o_specialities.show')->with('pMOSpeciality', $pMOSpeciality);
    }

    /**
     * Show the form for editing the specified PMOSpeciality.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);

        if (empty($pMOSpeciality)) {
            return response()->json(array("success" => 0, "msg"=> "No se encontró el ID"));
        }

        return response()->json(array("success" => 1, "pMOSpecialty"=> $pMOSpeciality));
    }

    /**
     * Update the specified PMOSpeciality in storage.
     *
     * @param  int              $id
     * @param UpdatePMOSpecialityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOSpecialityRequest $request)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);

        if (empty($pMOSpeciality)) {
            return response()->json(array("success" => 0, "msg"=> "No se encontró el ID"));
        }

        $pMOSpeciality = $this->pMOSpecialityRepository->update($request->all(), $id);

        return response()->json(array("success" => 1, "pMOSpecialty"=> $pMOSpeciality));
    }

    /**
     * Remove the specified PMOSpeciality from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOSpeciality = $this->pMOSpecialityRepository->findWithoutFail($id);

        if (empty($pMOSpeciality)) {
            Flash::error('P M O Speciality not found');

            return redirect(route('pMOSpecialities.index'));
        }

        $this->pMOSpecialityRepository->delete($id);

        Flash::success('P M O Speciality deleted successfully.');

        return redirect(route('pMOSpecialities.index'));
    }
}
