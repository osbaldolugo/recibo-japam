<?php

namespace App\Http\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\QueryException;
use Log;
use Flash;
use Response;

class CategoryController extends AppBaseController
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the Category.
     *
     * @param CategoryDataTable $categoryDataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(CategoryDataTable $categoryDataTable)
    {
        return $categoryDataTable->render('categories.index');
    }

    /**
     * Show the form for creating a new Category.
     *
     * @return Response
     */
    public function create()
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('categories.index'));
    }

    /**
     * Store a newly created Category in storage.
     *
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $input = $request->all();
            $this->categoryRepository->create($input);
            return response()->json(['content' => 'Se ha agregado una Nueva Área al catálogo', 'title' => 'Nueva Área'], 200);
        } catch (QueryException $e) {
            Log::error('Code: ' . $e->getCode() . ' Message: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Display the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        Flash::error('La vista que intenta mostrar no existe');
        return redirect(route('categories.index'));
    }

    /**
     * Show the form for editing the specified Category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Área que desea actualizar']], 422);
        }
        return response()->json(array("category" => $category), 200);
    }

    /**
     * Update the specified Category in storage.
     *
     * @param  int $id
     * @param UpdateCategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateCategoryRequest $request)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Área que desea actualizar']], 422);
        }
        try {
            $input = $request->all();
            $executor = $request->input('executor');
            if (!isset($executor))
                $input['executor'] = 0;
            $this->categoryRepository->update($input, $id);
            return response()->json(['content' => 'Se ha actualizado el Área', 'title' => 'Actualización'], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Remove the specified Category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            return response()->json(['errors' => ['message' => 'No se encontro la información del Área que desea eliminar']], 422);
        }
        try {
            $name = $category->name;
            $this->categoryRepository->delete($id);
            return response()->json(['content' => 'Se ha eliminado el Área con éxito', 'title' => $name],200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }

    /**
     * Update area permissions
     *
     * @param int $category_id
     * @param boolean $executor
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateExecutor($category_id, $executor) {
        try {
            Category::where('id', $category_id)->update(['executor' => $executor]);
            $category = Category::find($category_id);
            return response()->json(['content' => 'Se ha actualizado el registro', 'title' => $category->name], 200);
        } catch (QueryException $e) {
            Log::error('Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage());
            return response()->json(['errors' => ['message' => 'Code:' . $e->getCode() . ' Messagge: ' . $e->getMessage()]], 422);
        }
    }
}
