<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePriorityRequest;
use App\Models\Priority;
use DB;
use Illuminate\Http\JsonResponse;
use Log;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $priorities = \Cache::remember('ticketit::priorities', 60, function () {
            return Priority::all();
        });

        return view('kordy.admin.priority.index', compact('priorities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('kordy.admin.priority.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreatePriorityRequest $request
     * @return JsonResponse
     */
    public function store(CreatePriorityRequest $request)
    {
        try {
            Priority::create(['name' => $request->name, 'color' => $request->color, 'response_time' => $request->response_time]);
            return response()->json(['content' => 'Se ha agregado una nueva prioridad al catálogo', 'title' => 'Nueva Prioridad'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        dd('HOLA');
        return trans('lang.priority-all-tickets-here');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        dd('HOLA');
        $priority = Priority::findOrFail($id);

        return view('kordy.admin.priority.edit', compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $priority = Priority::findOrFail($id);
        $priority->update(['name' => $request->name, 'color' => $request->color]);

        Session::flash('status', trans('lang.priority-name-has-been-modified', ['name' => $request->name]));

        \Cache::forget('ticketit::priorities');

        return redirect()->route('PrioritiesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $priority = Priority::findOrFail($id);
            $name = $priority->name;
            $priority->delete();
            return response()->json(['content' => 'Se ha eliminado la prioridad con éxito', 'title' => $name],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()], 500);
        }
    }
}
