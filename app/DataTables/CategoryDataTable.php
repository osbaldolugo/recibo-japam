<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\Datatables\Services\DataTable;

class CategoryDataTable extends DataTable
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('color', function ($data) {
                return  '<span class="p-5 text-white" style="background-color: ' . $data->color .'">&nbsp;' . $data->color . '</span>';
            })
            ->editColumn('executor', function ($data) {
                return '<div class="text-center">' . \Form::input('checkbox', 'executor', $data->id, ['class' => 'executor', 'checked' => $data->executor ? true : false]) . '</div>';
            })
            ->addColumn('action', 'categories.datatables_actions')
            ->rawColumns(['color', 'executor'])
            ->escapeColumns(['color' => 'color', 'executor' => 'executor'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $categories = Category::query();

        return $this->applyScopes($categories);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->addAction(['width' => '10%'])
            ->ajax('')
            ->parameters([
                'dom' => 'Bfrtip',
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                        'extend'  => 'collection', 'className' => 'btn btn-xs btn-inverse',
                        'text'    => '<i class="fa fa-download"></i> Exportar',
                        'buttons' => [
                            'csv',
                            'excel'
                        ],
                    ],
                ]
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'nombre' => ['name' => 'name', 'data' => 'name'],
            'color' => ['name' => 'color', 'data' => 'color'],
            'Permisos Extra' => ['name' => 'executor', 'data' => 'executor']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'categories';
    }
}
