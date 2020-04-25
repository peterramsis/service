<?php

namespace App\DataTables;

use App\curriculum;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Sentinel;

class curriculaDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)->addColumn('checkbox', 'admin.curricula.btn.checkbox')->addColumn("attachment",function($query){
            return view('admin.curricula.btn.link',['attch'=>$query->attach,'id'=>$query->id]);
        })->addColumn('edit','admin.curricula.btn.edit')->rawColumns([
            "checkbox",
            "edit",
            "attachment"
            
        ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\curriculum $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if (Sentinel::hasAnyAccess(['admin.show'])) {
            return curriculum::query()->orderBy('id', 'DESC')->with("attach")->with("department");
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
                "lengthMenu" => [ 50, 75, 100],
                "buttons" => [
                    ["text" => "<i class='fas fa-plus'></i> Create", "className" => 'btn btn-primary', 'action' => "function(){
                            window.location.href = '" . route('create_curricula') . "'
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
                "name" => "name",
                'data' => "name",
                'title' => "name"
            ],
            [
                "name" => "author",
                'data' => "author",
                'title' => "Author"
            ],
            [
                "name" => "des",
                'data' => "des",
                'title' => "Description"
            ],
            [
                "name" => "department.dept_name",
                'data' => "department.dept_name",
                'title' => "department name"
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
                'name' => 'attachment',
                'data' => "attachment",
                'title' => "Attachment",
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
        return 'curricula_' . date('YmdHis');
    }
}
