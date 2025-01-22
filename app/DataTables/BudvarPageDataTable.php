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
        $title =  isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $lang =  isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : '';
        $type =  isset($this->request->get('search')['type']) ?  $this->request->get('search')['type'] : '';

        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;

        $data = BudvarApi::get('/page/findAll', ['title' => $title, 'lang' => $lang,  'type' => $type, 'page' => $page, 'record_per_page' => $length]);
        return datatables() 
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})

            ->addColumn('action', 'admin.budvar.page.action')
            ->addColumn('lang', '{{empty($lang) ? "Vi" : $lang}} ')
            ->addColumn('type', '{{empty($type) ? "none" : $type}}')
            ->addColumn('title', '<a target="_blank" href="{{empty($type) || $type=="PAGE" ? ("https://biabudvar.cz/".$slug) :  ($type=="EVENT" ? ("https://biabudvar.cz/event/".$slug) :("https://biabudvar.cz/page/".$slug)) }}">{{empty($title) ? "" : $title}}</a>')
            ->addColumn('startDate',  '{{\App\Common\Utility::displayDate($startDate)}} - {{\App\Common\Utility::displayDate($endDate)}}')
            //->addColumn('short', '{{empty($short) ? "" : $short}}')
            ->addColumn('voucher_limit', '{{$voucher_limit}}')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->rawColumns(['action', 'title'])
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
            Column::make('lang')->title('Ngôn ngữ')->width(100),
            Column::make('title')->title('Tiêu đề')->width(200),
            Column::make('startDate')->title('Thời gian')->width(200),
            Column::make('voucher_limit')->title('voucher limit')->width(200),
            // Column::make('short')->title('short')->width(200),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
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
