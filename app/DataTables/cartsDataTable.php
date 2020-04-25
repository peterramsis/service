<?php

namespace App\DataTables;

use App\cart;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Sentinel;


class cartsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('checkbox', 'admin.cart.btn.checkbox')->addColumn('edit','admin.cart.btn.edit')->editColumn("user",function($query){
            return $query->user->first_name." ".$query->user->last_name;
        })->addColumn('export','admin.cart.btn.export')->addColumn('show', function($query){
            return view('admin.cart.btn.show',['game'=>$query->game,'id'=>$query->id,"curriculum"=>$query->curriculum]);
        })->rawColumns([
            "checkbox",
            "show",
            "edit",
            "export"

        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\cart $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if (Sentinel::hasAnyAccess(['admin.show'])) {
            return cart::query()->with("user")->with("game")->with("curriculum")->with("user")->orderBy('id', 'DESC');
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
                "name" => "date_order",
                'data' => "date_order",
                'title' => "order date"
            ],
            [
                "name" => "name_camp",
                'data' => "name_camp",
                'title' => "Camp name"
            ],

            [
                "name" => "date_camp",
                'data' => "date_camp",
                'title' => "camp date"
            ],

            [
                "name" => "administration",
                'data' => "administration",
                'title' => "Administration"
            ],

            [
                "name" => "other_inforamtion",
                'data' => "other_inforamtion",
                'title' => "other inforamtion"
            ],
            [
                "name" => "state",
                'data' => "state",
                'title' => "Status"
            ],
            [
                "name" => "user.first_name",
                'data' => "user",
                'title' => "order"
            ],
            [
                'name' => 'show',
                'data' => "show",
                'title' => "show",
                'exportable' => False,
                'printable'  => False,
                'orderable'  => False,
                'searchable' => False,


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
                'name' => 'export',
                'data' => "export",
                'title' => "Export",
                'exportable' => False,
                'printable'  => False,
                'orderable'  => False,
                'searchable' => False,
            ],

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'carts_' . date('YmdHis');
    }
}
