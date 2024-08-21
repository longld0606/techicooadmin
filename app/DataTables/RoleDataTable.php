<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'admin.role.action')
            ->addColumn('created_at',  '{{\App\Common\Utility::displayDatetime($created_at)}}')
            ->addColumn('updated_at',  '{{\App\Common\Utility::displayDatetime($updated_at)}}')
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        $query = Role::select();
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
            ])
            ->dom('<"row"<"col-sm-12"itr>><"row"<"col-sm-4"l><"col-sm-8"p>>')
            ->orderBy(1)
            ->selectStyleSingle()
            // ->buttons([
            //     // Button::make('excel'),
            //     // Button::make('csv'),
            //      Button::make('pdf'),
            //     // Button::make('print'),
            //     // Button::make('reset'),
            //     // Button::make('reload')
            // ]);
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)->title('#'),
            Column::make('id'),
            Column::make('name')->title('Name'),
            Column::make('guard_name')->title('GuardName'),
            Column::make('created_at')->title('CreatedAt'),
            Column::make('updated_at')->title('UpdatedAt'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Role_' . date('YmdHis');
    }
}
