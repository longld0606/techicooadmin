<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarContactDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $title = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $type = isset($this->request->get('search')['type']) ?  $this->request->get('search')['type'] : '';

        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;


        $data = BudvarApi::get('/contact/findAll', ['title' => $title, 'type' => $type, 'page' => $page, 'record_per_page' => $length]);


        return datatables() 
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})


            ->addColumn('action', 'admin.budvar.contact.action')
            ->addColumn('type', '{{empty($type) ? "none" : $type}} ')
            ->addColumn('firstname', '{{empty($firstname) ? "" : $firstname}} {{empty($lastname) ? "" : $lastname}}')
            ->addColumn('message', '{{empty($message) ? "" : $message}}')
            ->addColumn('phoneNumber', '{{empty($phoneNumber) ? "" : $phoneNumber}} ')
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
            Column::make('firstname')->title('Họ Tên')->width(200),
            Column::make('phoneNumber')->title('SĐT')->width(100),
            Column::make('message')->title('Nội dung'), 
            Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Contact_' . date('YmdHis');
    }
}
