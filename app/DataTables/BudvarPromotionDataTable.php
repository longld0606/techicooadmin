<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarPromotionDataTable extends DataTable
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
        $type =  isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : 'product';

        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;

        $data = BudvarApi::get('/promotion/findAll', ['title' => $title, 'lang' => $lang, 'type' => $type, 'page' => $page, 'record_per_page' => $length]);
        return datatables() 
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})

            ->addColumn('action', 'admin.budvar.promotion.action')
            ->addColumn('name', '{{empty($name) ? "" : $name}} ')
            ->addColumn('code', '{{empty($code) ? "none" : $code}} ')
            ->addColumn('discountPercent', '{{empty($discountPercent) ? "" : $discountPercent}}')
            ->addColumn('discountPrice', '{{empty($discountPrice) ? "" : $discountPrice}}') 
            ->addColumn('startDate', '{{empty($startDate) ? "" :  \App\Common\Utility::displayDateTime($startDate) }} - {{empty($dueDate) ? "" :  \App\Common\Utility::displayDateTime($dueDate) }}') 
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
            //->paging(false)
            ->minifiedAjax('', null, [
                'search["value"]' => '$("[name=search]").val()',
                'search["type"]' => '$("[name=type]").val()',
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
            Column::make('name')->title('Tên')->width(100),
            Column::make('code')->title('Mã')->width(100),
            Column::make('discountPercent')->title('Tiêu đề'),
            Column::make('discountPrice')->title('Tiêu đề'),
            Column::make('startDate')->title('Thời gian'),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BudvarPromotion_' . date('YmdHis');
    }
}
