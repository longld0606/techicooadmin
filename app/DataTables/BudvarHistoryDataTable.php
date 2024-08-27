<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarHistoryDataTable extends DataTable
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
        
        $params = [];
        if (!empty($title))
            $params['title'] = $title;
        if (!empty($lang))
            $params['lang'] = $lang; 



        $data = BudvarApi::get('/history/findAll', $params);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.history.action')
            ->addColumn('lang', '{{empty($lang) ? "Vi" : $lang}} ')
            ->addColumn('year', '{{empty($year) ? "none" : $year}} ')
            ->addColumn('topic', '{{empty($topic) ? "" : $topic}}') 
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
                'search["lang"]' => '$("[name=lang]").val()',
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
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->width(50)->title('#'),
            Column::make('_id')->title('Id')->width(100), 
            Column::make('lang')->title('Ngôn ngữ')->width(150),
            Column::make('year')->title('Năm')->width(150),
            Column::make('topic')->title('Tiêu đề'),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'History_' . date('YmdHis');
    }
}
