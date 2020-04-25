<?php

namespace App\DataTables;

use App\question;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use Sentinel;


class questionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
            return datatables($query)->addColumn('checkbox', 'admin.question.btn.checkbox')->addColumn('edit', 'admin.question.btn.edit')->rawColumns([
                "checkbox",
                "edit"
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\question $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(question $model)
    {
        if (Sentinel::hasAnyAccess(['admin.*'])) {
            return question::query()->orderBy('id', 'DESC');
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
                    ["text" => trans("qu.create"), "className" => 'btn btn-primary', 'action' => "function(){
                            window.location.href = '" . route('addQuestion') . "'
                        }"],
                    ["text" => "<i class='far fa-trash-alt'></i>".trans("qu.delete"), "className" => 'btn btn-danger del_all'],

                    ["extend" => "excel", "className" => 'btn btn-success', "text" => '<i class="far fa-file-excel"></i>'.trans("qu.excel")],
                    ["extend" => "pdf", "className" => 'btn btn-primary', "text" => '<i class="far fa-file-pdf"></i>'.trans("qu.pdf")],

                ]
            ]
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
                "name" => "question_ar",
                'data' => "question_ar",
                'title' => trans("qu.question arabic")
            ],
            [
                "name" => "question_en",
                'data' => "question_en",
                'title' => trans("qu.question english")
            ],
            [
                'name' => 'edit',
                'data' => "edit",
                'title' => trans("qu.edit"),
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
        return 'question_' . date('YmdHis');
    }
}
