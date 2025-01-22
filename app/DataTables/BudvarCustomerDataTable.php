<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarCustomerDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $title = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';

        $params = [];
        if (!empty($title))
            $params['title'] = $title;


        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;
        $params['page'] = $page;
        $params['record_per_page'] = $length;

        $data = BudvarApi::get('/customer/findAll', $params);
        return  datatables() 
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})

            ->addColumn('action', 'admin.budvar.customer.action')
            ->addColumn('fullname', '{{empty($fullname) ? "" : $fullname}} ')
            ->addColumn('email', '{{empty($email) ? "" : $email}} ')
            ->addColumn('phoneNumber', '({{empty($areaCode) ? "" : $areaCode}}) {{empty($phoneNumber) ? "" : $phoneNumber}} ')
            ->addColumn('taxCode', '{{empty($taxCode) ? "" : $taxCode}} ')
            ->addColumn('valCode', '{{empty($valCode) ? "" : $valCode}} ')
            //->addColumn('facebook', '{{empty($facebook) ? "" : $facebook}} ')
            //->addColumn('address', '{{empty($company) && empty($company->name) ? "" : $company->name}} ')
            //->addColumn('authenticated', '{{empty($authenticated) || $authenticated != true ? "Chưa xác thực" : "Đã xác thực"}} ')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->addColumn('address', function ($obj) {
                if (empty($obj["company"])) return "";
                $addr =  json_decode($obj["company"][0], true);
                //var_dump($addr);
                if (empty($addr['name'])) return "";
                return $addr['name'];
                //return $obj["company"];
                //return gettype($obj["company"]);
            })
            ->addColumn('authenticated', function ($obj) {
                if (isset($obj["authenticated"]) && $obj["authenticated"] == true) return "<span class='btn btn-sm btn-success text-nowrap'>Đã xác thực</span>";
                return "<span class='btn btn-sm btn-secondary text-nowrap'>Chưa xác thực</span>";
            })
            ->rawColumns(['authenticated', 'action'])
            ->setRowId('_id'); //<span class="badge badge-primary">Primary</span>


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
            //Column::make('_id')->title('Id')->width(100),
            Column::make('fullname')->title('Họ Tên'),
            Column::make('email')->title('Email')->width(200),
            Column::make('phoneNumber')->title('SĐT')->width(200),
            Column::make('taxCode')->title('IČO')->width(200),
            Column::make('valCode')->title('DIČ')->width(200),
            //Column::make('facebook')->title('FB')->width(200),
            //Column::make('address')->title('Địa chỉ'),
            Column::make('authenticated')->title('Trạng thái')->width(150),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Customer_' . date('YmdHis');
    }
}
