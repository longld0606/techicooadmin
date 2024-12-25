<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $title = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $lang = isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : '';
        $category = isset($this->request->get('search')['category']) ?  $this->request->get('search')['category'] : '';

        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;

        $data = BudvarApi::get('/product/findAll', ['name' => $title, 'lang' => $lang, 'category' => $category, 'page' => $page, 'record_per_page' => $length]);
        return datatables() 
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})

            ->addColumn('action', 'admin.budvar.product.action')
            // ->addColumn('name', '{{empty($name) ? "" : $name}} ')
            ->addColumn('lang', '{{empty($lang) ? "Vi" : $lang}} ')
            ->addColumn('name', '<a target="_blank" href="https://biabudvar.cz/products/{{$slug}}">{{empty($name) ? "" : $name}}</a>')

            ->addColumn('category', '{{empty($category) ? "" : $category["title"]}} ')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->addColumn('thumb', '<img src="{{ empty($media) ? "" : $media["source"]}}" width="150px" style="border: 1px solid #dee2e6" />')
            ->rawColumns(['thumb', 'action', 'name'])
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
            //->paging(false)
            ->minifiedAjax('', null, [
                'search["value"]' => '$("[name=search]").val()',
                'search["lang"]' => '$("[name=lang]").val()',
                'search["category"]' => '$("[name=category]").val()',
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
            Column::make('name')->title('Tiêu đề')->width(300),
            Column::make('lang')->title('Ngôn ngữ')->width(100),
            Column::make('category')->title('Loại')->width(300),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
            Column::make('thumb')->title('Ảnh')->width(100),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'product_' . date('YmdHis');
    }
}
