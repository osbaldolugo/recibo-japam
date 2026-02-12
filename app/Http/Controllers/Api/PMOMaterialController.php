<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PMOMaterialDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePMOMaterialRequest;
use App\Http\Requests\UpdatePMOMaterialRequest;
use App\Models\PMOMaterial;
use App\Repositories\PMOMaterialRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PMOMaterialController extends AppBaseController
{
    /** @var  PMOMaterialRepository */
    private $pMOMaterialRepository;

    public function __construct(PMOMaterialRepository $pMOMaterialRepo)
    {
        $this->pMOMaterialRepository = $pMOMaterialRepo;
    }

    /**
     * Display a listing of the PMOMaterial.
     *
     * @param PMOMaterialDataTable $pMOMaterialDataTable
     * @return Response
     */
    public function index(PMOMaterialDataTable $pMOMaterialDataTable)
    {
        $material = PMOMaterial::query()->paginate(15);

        return response()->json(array($material),200);
    }

    /**
     * Show the form for creating a new PMOMaterial.
     *
     * @return Response
     */
    public function create()
    {
        return view('p_m_o_materials.create');
    }

    /**
     * Store a newly created PMOMaterial in storage.
     *
     * @param CreatePMOMaterialRequest $request
     *
     * @return Response
     */
    public function store(CreatePMOMaterialRequest $request)
    {
        $input = $request->all();

        $pMOMaterial = $this->pMOMaterialRepository->create($input);

        return response()->json(array("success"=>1,"pMOMaterial"=>$pMOMaterial));
    }

    /**
     * Display the specified PMOMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);

        if (empty($pMOMaterial)) {
            Flash::error('P M O Material not found');

            return redirect(route('pMOMaterials.index'));
        }

        return view('p_m_o_materials.show')->with('pMOMaterial', $pMOMaterial);
    }

    /**
     * Show the form for editing the specified PMOMaterial.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);

        if (empty($pMOMaterial)) {
            return response()->json(array("success"=>0,"msg","No se encontró el ID"));
        }

        return response()->json(array("success"=>1,"pMOMaterial"=>$pMOMaterial));
    }

    /**
     * Update the specified PMOMaterial in storage.
     *
     * @param  int              $id
     * @param UpdatePMOMaterialRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePMOMaterialRequest $request)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);

        if (empty($pMOMaterial)) {
            return response()->json(array("success"=>0,"msg","No se encontró el ID"));
        }

        $pMOMaterial = $this->pMOMaterialRepository->update($request->all(), $id);

        return response()->json(array("success"=>1,"pMOMaterial"=>$pMOMaterial));
    }

    /**
     * Remove the specified PMOMaterial from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pMOMaterial = $this->pMOMaterialRepository->findWithoutFail($id);

        if (empty($pMOMaterial)) {
            Flash::error('P M O Material not found');

            return redirect(route('pMOMaterials.index'));
        }

        $this->pMOMaterialRepository->delete($id);

        Flash::success('P M O Material deleted successfully.');

        return redirect(route('pMOMaterials.index'));
    }
}
