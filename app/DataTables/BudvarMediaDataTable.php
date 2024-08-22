<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use App\Models\Budvar\Media;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarMediaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $name = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $type = isset($this->request->get('search')['type']) ?  $this->request->get('search')['type'] : '';
        $data = BudvarApi::get('/media/findAll', ['name' => $name, 'type' => $type]);

        //return $this->applyScopes($medias['data']);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.media.action')
            ->addColumn('source', '<img src="{{ empty($source) ? "" : $source}}" width="150px" style="border: 1px solid #dee2e6" />')
            ->addColumn('type', '{{empty($type) ? "none" : $type}} ')
            ->addColumn('name', '{{empty($name) ? "" : $name}} ') 
            ->addColumn('link',  '{{empty($source) ? "" : $source}} ') 
            ->addColumn('originalname', '{{empty($originalname) ? "" : $originalname}} ') 
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')

            ->rawColumns(['source', 'action'])
            ->setRowId('_id');
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
                'search["type"]' => '$("[name=type]").val()',
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
            Column::make('_id')->title('Id')->width(100),  
            Column::make('type')->title('Loại')->width(100),  
            //Column::make('name')->title('Tên')->width(200),
            Column::make('originalname')->title('Tên cũ')->width(200),
            // Column::make('link')->title('Link')->width(200),
            Column::make('source')->title('Ảnh')->width(150),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'media_' . date('YmdHis');
    }
}
