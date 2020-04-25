<?php

namespace App\DataTables;

use App\cart;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Sentinel;

class yourOrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('checkbox', 'cart.btn.checkbox')->addColumn('show', function($query){
            return view('admin.cart.btn.show',['game'=>$query->game,'id'=>$query->id,"curriculum"=>$query->curriculum]);
        })->rawColumns([
            "show",
            "checkbox"
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\yourOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return cart::where("id_user",Sentinel::getUser()->id)->with("user")->with("game")->with("curriculum")->with("user")->orderBy('id', 'DESC');
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
                'name' => 'show',
                'data' => "show",
                'title' => "show",
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
        return 'yourOrder_' . date('YmdHis');
    }
}
