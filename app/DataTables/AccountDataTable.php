<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccountDataTable extends DataTable
{
    //protected string $exportClass = \App\DataTables\Exports\UsersExport::class; 
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    protected array $actions = ['excel', 'csv', 'pdf', 'print'];

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.account.action')
            ->addColumn('created_at',  '{{\App\Common\Utility::displayDatetime($created_at)}}')
            ->addColumn('updated_at',  '{{\App\Common\Utility::displayDatetime($updated_at)}}')
            ->addColumn('status', '{{\App\Common\Enum_STATUS::getMessage($status) }}')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
        $query = User::select();
        if (request('search.status') && !empty(request('search.status'))) {
            $query->where('status', request('search.status'));
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
                'search["status"]' => '$("[name=status]").val()',
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
            Column::computed('action')
                ->title('#')
                ->width(50)
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('id')->width(100),
            Column::make('name')->title('Họ Tên'),
            Column::make('email')->width(200),
            Column::make('phone')->title('SĐT')->width(200),
            Column::make('status')->title('Trạng thái')->width(100),
            Column::make('created_at')->width(100),
            Column::make('updated_at')->width(100),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
