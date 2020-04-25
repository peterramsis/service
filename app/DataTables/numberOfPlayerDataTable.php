<?php

namespace App\DataTables;

use App\numberOfPlayer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Sentinel;

class numberOfPlayerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('checkbox', 'admin.number.btn.checkbox')->addColumn('edit', 'admin.number.btn.edit')->rawColumns([
            "checkbox",
            "edit"
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\numberOfPlayer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if (Sentinel::hasAnyAccess(['admin.show'])) {
            return numberOfPlayer::query()->orderBy('id_number', 'DESC');
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->columns($this->getColumns())
        ->minifiedAjax()

        //->parameters($this->getBuilderParameters())
        ->parameters(
            [
                'dom' => 'Blfrtip',
                "lengthMenu" => [10, 25, 50, 75, 100],
                "buttons" => [
                    ["text" => "<i class='fas fa-plus'></i> Create", "className" => 'btn btn-primary', 'action' => "function(){
                            window.location.href = '" . route('create_number') . "'
                        }"],
                    ["text" => "<i class='far fa-trash-alt'></i> Delete", "className" => 'btn btn-danger del_all'],
                    ["extend" => "print", "className" => 'btn btn-secondary', "text" => "<i class='fas fa-print'></i> Print"],
                    ["extend" => "excel", "className" => 'btn btn-success', "text" => '<i class="far fa-file-excel"></i> Excel'],
                    ["extend" => "pdf", "className" => 'btn btn-primary', "text" => '<i class="far fa-file-pdf"></i> Pdf'],

                ],



            ],
        );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                "name" => "checkbox",
                'data' => "checkbox",
                'title' => "<input type='checkbox' class='check_all_item' onclick='check_all()'/>",
                'exportable' => false,
                'printable'  => false,
                'orderable'  => false,
                'searchable' => false

            ],
            [
                "name" => "number_of_player",
                'data' => "number_of_player",
                'title' => "number_of_player"
            ],
            [
                'name' => 'edit',
                'data' => "edit",
                'title' => "Edit",
                'exportable' => False,
                'printable'  => False,
                'orderable'  => False,
                'searchable' => False,
            ]

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'numberOfPlayer_' . date('YmdHis');
    }
}
