<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 10/01/2018
 * Time: 04:08 PM
 */

namespace App\DataTables;


use App\Models\Suburb;
use Yajra\Datatables\Services\DataTable;

class SuburbDataTable extends DataTable
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */

    protected $sector = null;

    public function completedTickets($sector)
    {
        $this->sector = $sector;
        return $this;
    }

    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->editColumn('tickets', function ($data) {
                return '<div class="label label-primary f-s-13"><i class="fa fa-ticket"></i> ' . count($data->ticket) . ' Tickets</div>';
            })
            ->addColumn('action', 'suburbs.datatables_actions')
            ->rawColumns(['tickets'])
            ->escapeColumns(['tickets' => 'tickets'])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $request_sector = $this->request()->get('id_sector');
        $appTickets = Suburb::query()->select(['suburbs.id','suburb', \DB::raw('COUNT(ticketit.id) as tickets'), 'sector.name'])->leftJoin('ticketit', 'ticketit.suburb_id', '=', 'suburbs.id')
            ->leftJoin('sector', 'sector.id', '=', 'suburbs.sector_id')
            ->groupBy('suburbs.id');
        if ($this->sector)
            $appTickets->where('sector_id', $this->sector);
        if (!empty($request_sector))
            $appTickets->where('sector_id', $request_sector);
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
                        'extend'  => 'collection',
                        'className' => 'btn btn-xs btn-inverse',
                        'text'    => '<i class="fa fa-download"></i> Exportar',
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
            '#' => ['name' => 'id', 'data' => 'id'],
            'Colonia' => ['name' => 'suburb', 'data' => 'suburb'],
            'Sector' => ['name' => 'sector.name', 'data' => 'name'],
            'Tickets' => ['name' => 'ticketit.id', 'data' => 'tickets']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'suburbs';
    }
}