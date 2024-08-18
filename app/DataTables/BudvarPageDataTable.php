<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarPageDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $data = BudvarApi::get('/page/findAll');
        //return $this->applyScopes($posts['data']);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.page.action')
            ->addColumn('type', '{{empty($type) ? "none" : $type}} ')
            ->addColumn('title', '{{empty($title) ? "" : $title}} ')
            ->addColumn('short', '{{empty($short) ? "" : $short}}')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->setRowId('_id');

        // return (new EloquentDataTable($query))
        //     ->addColumn('timestamp',  '<a href="/vcc/{{$id}}">{{\App\Common\Utility::displayDatetime($timestamp)}}</a>')
        //     ->rawColumns(['timestamp'])
        //     ->setRowId('id');
    }



    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
            ->paging(false)
            ->minifiedAjax('', null, [
                'search["value"]' => '$("[name=search]").val()',
                'search["path"]' => '$("[name=path]").val()',
                'search["user_id"]' => '$("[name=user_id]").val()',
                'search["code"]' => '$("[name=code]").val()',
                'search["message"]' => '$("[name=message]").val()',
                'search["ip"]' => '$("[name=ip]").val()',
                'search["method"]' => '$("[name=method]").val()',
            ])
            ->dom('<"row"<"col-sm-12"itr>><"row"<"col-sm-4"l><"col-sm-8"p>>')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                //Button::make('pdf'),
                Button::make('print'),
                // Button::make('reset'),
                // Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::computed('action')->exportable(false)->printable(false)->width(50)->title('#'),
            Column::make('_id')->width(100),

            Column::make('type')->title('Loại')->width(100),
            Column::make('title')->title('Title')->width(200),
            Column::make('short')->title('short')->width(100),

            Column::make('createdAt')->title('createdAt')->width(100),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'page_' . date('YmdHis');
    }
}
