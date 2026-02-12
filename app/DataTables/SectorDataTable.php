<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 01:22 PM
 */

namespace App\DataTables;


use App\Models\Sector;
use App\Models\Suburb;
use DB;
use Yajra\Datatables\Services\DataTable;

class SectorDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('suburb', function ($data) {
                return '<a class="show-more btn btn-primary tooltips" title="Mostrar Colonias" data-suburb="' . $data->id . '"><i class="fa fa-eye"></i> ' . $data->suburb . '</a>';
            })
            ->addColumn('action', 'sector.datatables_actions')
            ->rawColumns(['suburb'])
            ->escapeColumns(['suburb' => 'suburb'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

        $suburb = Suburb::select("id")->get()->toArray();
        $appTickets = Sector::select(['sector.id', "sector.name", "sector.code", DB::raw('COUNT(suburbs.id) as suburb')])->leftJoin("suburbs", function ($join) use ($suburb) {
            $join->on('sector.id', '=', 'suburbs.sector_id')->whereIn('sector_id', $suburb);
        })->groupBy('id', 'name', 'code');


        return $this->applyScopes($appTickets);
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
                'language' => ['url' => '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json'],
                'dom' => 'Bfrtip',
                'scrollX' => false,
                'buttons' => [
                    ['extend' => 'reload', 'className' => 'btn btn-xs btn-inverse', 'text' => '<i class="fa fa-repeat"></i> Recargar'],
                    [
                        'extend' => 'collection',
                        'className' => 'btn btn-xs btn-inverse',
                        'text' => '<i class="fa fa-download"></i> Exportar',
                        'buttons' => [
                            'csv',
                            'excel',
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
            'Código' => ['name' => 'code', 'data' => 'code'],
            'Nombre' => ['name' => 'name', 'data' => 'name'],
            'Colonias' => ['name' => 'suburb', 'data' => 'suburb', 'searchable' => false, 'exportable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sector';
    }
}