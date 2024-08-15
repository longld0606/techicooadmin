<?php

namespace App\DataTables;

use App\Models\Logs;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LogsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('timestamp',  '<a href="/admin/logs/{{$id}}">{{\App\Common\Utility::displayDatetime($timestamp)}}</a>')
            ->rawColumns([ 'timestamp'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Logs $model): QueryBuilder
    {
        $query = Logs::select();
        if (request('search.user_id') && !empty(request('search.user_id'))) {
            $query->where('user_id', request('search.user_id'));
        }
        if (request('search.path') && !empty(request('search.path'))) {
            $query->where('path', request('search.path'));
        }
        if (request('search.code') && !empty(request('search.code'))) {
            $query->where('response_code', request('search.code'));
        }
        if (request('search.message') && !empty(request('search.message'))) {
            $query->where('response_message', request('search.message'));
        }
        if (request('search.ip') && !empty(request('search.ip'))) {
            $query->where('ip', request('search.ip'));
        }
        if (request('search.method') && !empty(request('search.method'))) {
            $query->where('method', request('search.method'));
        }
        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
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
                Button::make('pdf'),
                Button::make('print'), 
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            //Column::computed('action')->width(60)->title('#'),
            Column::make('id'),
            Column::make('user_name')->title('User'),
            Column::make('timestamp')->title('Thời gian'),
            Column::make('ip')->title('Ip'),
            Column::make('path')->title('Path'),
            Column::make('method')->title('Method'),
            Column::make('response_code')->title('Code'),
            Column::make('response_message')->title('Message'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Log_' . date('YmdHis');
    }
}
