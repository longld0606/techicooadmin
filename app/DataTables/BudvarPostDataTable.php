<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarPostDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $title = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $short = isset($this->request->get('search')['short']) ?  $this->request->get('search')['short'] : '';
        $description = isset($this->request->get('search')['description']) ?  $this->request->get('search')['description'] : '';
        $data = BudvarApi::get('/post/findAll', ['title' => $title, 'description' => $description, 'short' => $short]);
        //return $this->applyScopes($posts['data']);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.post.action')
            ->addColumn('lang', '{{empty($lang) ? "vi" : $lang}} ')
            ->addColumn('type', '{{empty($type) ? "none" : $type}} ')
            ->addColumn('title', '<a target="_blank" href="https://biabudvar.cz/posts/{{$slug}}">{{empty($title) ? "" : $title}}</a>')
            ->addColumn('short', '{{empty($short) ? "" : $short}}')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->addColumn('thumb', '<img src="{{ empty($media) ? "" : $media["source"]}}" width="150px" style="border: 1px solid #dee2e6" />')
            ->rawColumns(['thumb', 'action', 'title'])
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
                'search["description"]' => '$("[name=description]").val()',
                'search["short"]' => '$("[name=short]").val()',
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
            // Column::make('type')->title('Loại')->width(100),
            Column::make('lang')->title('Ngôn ngữ')->width(100),
            Column::make('title')->title('Tiêu đề')->width(300),
            Column::make('short')->title('Mô tả'),
            Column::make('createdAt')->title('createdAt')->width(100),
            Column::make('thumb')->title('Ảnh')->width(100),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'post_' . date('YmdHis');
    }
}