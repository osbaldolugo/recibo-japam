<?php

namespace App\Http\Controllers;

use App\DataTables\PeopleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePeopleRequest;
use App\Http\Requests\UpdatePeopleRequest;
use App\Repositories\PeopleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PeopleController extends AppBaseController
{
    /** @var  PeopleRepository */
    private $peopleRepository;

    public function __construct(PeopleRepository $peopleRepo)
    {
        $this->peopleRepository = $peopleRepo;
    }

    /**
     * Display a listing of the People.
     *
     * @param PeopleDataTable $peopleDataTable
     * @return Response
     */
    public function index(PeopleDataTable $peopleDataTable)
    {
        return $peopleDataTable->render('people.index');
    }

    /**
     * Show the form for creating a new People.
     *
     * @return Response
     */
    public function create()
    {
        return view('people.create');
    }

    /**
     * Store a newly created People in storage.
     *
     * @param CreatePeopleRequest $request
     *
     * @return Response
     */
    public function store(CreatePeopleRequest $request)
    {
        $input = $request->all();

        $people = $this->peopleRepository->create($input);

        Flash::success('People saved successfully.');

        return redirect(route('people.index'));
    }

    /**
     * Display the specified People.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $people = $this->peopleRepository->findWithoutFail($id);

        if (empty($people)) {
            Flash::error('People not found');

            return redirect(route('people.index'));
        }

        return view('people.show')->with('people', $people);
    }

    /**
     * Show the form for editing the specified People.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $people = $this->peopleRepository->findWithoutFail($id);

        if (empty($people)) {
            Flash::error('People not found');

            return redirect(route('people.index'));
        }

        return view('people.edit')->with('people', $people);
    }

    /**
     * Update the specified People in storage.
     *
     * @param  int              $id
     * @param UpdatePeopleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePeopleRequest $request)
    {
        $people = $this->peopleRepository->findWithoutFail($id);

        if (empty($people)) {
            Flash::error('People not found');

            return redirect(route('people.index'));
        }

        $people = $this->peopleRepository->update($request->all(), $id);

        Flash::success('People updated successfully.');

        return redirect(route('people.index'));
    }

    /**
     * Remove the specified People from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $people = $this->peopleRepository->findWithoutFail($id);

        if (empty($people)) {
            Flash::error('People not found');

            return redirect(route('people.index'));
        }

        $this->peopleRepository->delete($id);

        Flash::success('People deleted successfully.');

        return redirect(route('people.index'));
    }
}
