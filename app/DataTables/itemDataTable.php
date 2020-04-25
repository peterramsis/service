<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;
use App\item;
use Sentinel;

class itemDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('checkbox', 'admin.item.btn.checkbox')->addColumn("download",'admin.item.btn.download')->addColumn('edit', 'admin.item.btn.edit')->rawColumns([
            "checkbox",
            "edit",
            "download"
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if (Sentinel::hasAnyAccess(['admin.show'])) {
            return item::query()->orderBy('id', 'DESC');
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
                                window.location.href = '" . route('create_item') . "'
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
                "name" => "item_name",
                'data' => "item_name",
                'title' => "Item name"
            ],
            [
                "name" => "description",
                'data' => "description",
                'title' => "Description"
            ],
           
            [
                'name' => 'edit',
                'data' => "edit",
                'title' => "Edit",
                'exportable' => False,
                'printable'  => False,
                'orderable'  => False,
                'searchable' => False,
            ],
            [
                'name' => 'download',
                'data' => "download",
                'title' => "download",
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
        return 'item_' . date('YmdHis');
    }
}
