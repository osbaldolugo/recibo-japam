<?php

namespace App\Http\Controllers;

use App\DataTables\PeopleUnloggedDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePeopleUnloggedRequest;
use App\Http\Requests\UpdatePeopleUnloggedRequest;
use App\Repositories\PeopleUnloggedRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PeopleUnloggedController extends AppBaseController
{
    /** @var  PeopleUnloggedRepository */
    private $peopleUnloggedRepository;

    public function __construct(PeopleUnloggedRepository $peopleUnloggedRepo)
    {
        $this->peopleUnloggedRepository = $peopleUnloggedRepo;
    }

    /**
     * Display a listing of the PeopleUnlogged.
     *
     * @param PeopleUnloggedDataTable $peopleUnloggedDataTable
     * @return Response
     */
    public function index(PeopleUnloggedDataTable $peopleUnloggedDataTable)
    {
        return $peopleUnloggedDataTable->render('people_unloggeds.index');
    }

    /**
     * Show the form for creating a new PeopleUnlogged.
     *
     * @return Response
     */
    public function create()
    {
        return view('people_unloggeds.create');
    }

    /**
     * Store a newly created PeopleUnlogged in storage.
     *
     * @param CreatePeopleUnloggedRequest $request
     *
     * @return Response
     */
    public function store(CreatePeopleUnloggedRequest $request)
    {
        $input = $request->all();

        $peopleUnlogged = $this->peopleUnloggedRepository->create($input);

        Flash::success('People Unlogged saved successfully.');

        return redirect(route('peopleUnloggeds.index'));
    }

    /**
     * Display the specified PeopleUnlogged.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $peopleUnlogged = $this->peopleUnloggedRepository->findWithoutFail($id);

        if (empty($peopleUnlogged)) {
            Flash::error('People Unlogged not found');

            return redirect(route('peopleUnloggeds.index'));
        }

        return view('people_unloggeds.show')->with('peopleUnlogged', $peopleUnlogged);
    }

    /**
     * Show the form for editing the specified PeopleUnlogged.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $peopleUnlogged = $this->peopleUnloggedRepository->findWithoutFail($id);

        if (empty($peopleUnlogged)) {
            Flash::error('People Unlogged not found');

            return redirect(route('peopleUnloggeds.index'));
        }

        return view('people_unloggeds.edit')->with('peopleUnlogged', $peopleUnlogged);
    }

    /**
     * Update the specified PeopleUnlogged in storage.
     *
     * @param  int              $id
     * @param UpdatePeopleUnloggedRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeopleUnloggedRequest $request)
    {
        $peopleUnlogged = $this->peopleUnloggedRepository->findWithoutFail($id);

        if (empty($peopleUnlogged)) {
            Flash::error('People Unlogged not found');

            return redirect(route('peopleUnloggeds.index'));
        }

        $peopleUnlogged = $this->peopleUnloggedRepository->update($request->all(), $id);

        Flash::success('People Unlogged updated successfully.');

        return redirect(route('peopleUnloggeds.index'));
    }

    /**
     * Remove the specified PeopleUnlogged from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $peopleUnlogged = $this->peopleUnloggedRepository->findWithoutFail($id);

        if (empty($peopleUnlogged)) {
            Flash::error('People Unlogged not found');

            return redirect(route('peopleUnloggeds.index'));
        }

        $this->peopleUnloggedRepository->delete($id);

        Flash::success('People Unlogged deleted successfully.');

        return redirect(route('peopleUnloggeds.index'));
    }
}
