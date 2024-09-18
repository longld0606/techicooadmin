<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarVoucherDataTable extends DataTable
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

        $data = BudvarApi::get('/voucher/findAll', ['title' => $title, 'lang' => $lang, 'type' => $type]);
        //dd($data);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.voucher.action')
            //->addColumn('promotion', '{{empty($promotion) ? "" : $promotion}} ')
            ->addColumn('code', '{{empty($code) ? "" : $code}} ')
            ->addColumn('usageLimit', '{{empty($usageLimit) ? "" : $usageLimit}} ')
            ->addColumn('userLimit', '{{empty($userLimit) ? "" : $userLimit}}')
            ->addColumn('minimumPurchaseAmount', '{{empty($minimumPurchaseAmount) ? "" : $minimumPurchaseAmount}}')
            ->addColumn('usageCount', '{{empty($usageCount) ? "" : $usageCount}}')
            ->addColumn('startDate', '{{empty($startDate) ? "" :  \App\Common\Utility::displayDateTime($startDate) }} - {{empty($endDate) ? "" :  \App\Common\Utility::displayDateTime($endDate) }}')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->addColumn('event', '')
            ->addColumn('useDate', '')
            ->addColumn('promotion', function ($obj) {
                if (empty($obj["promotion"])) return "";
                $promotion =  $obj["promotion"];
                if (empty($promotion['name'])) return "";
                return $promotion['name'];
            })
            ->addColumn('customer', function ($v) {
                $obj = $v['owner'];
                if(!isset($obj)) return "";
                if (isset($obj["authenticated"]) && $obj["authenticated"] == true) $auth= "<span class='btn btn-sm text-bg-success'>Đã xác thực</span>";
                else $auth= "<span class='btn btn-sm text-bg-secondary'>Chưa xác thực</span>";

                return "<span>".$obj["fullname"]."</span><br/>".
                "<span>".$obj["phoneNumber"]."</span><br/>".
                "<span>".$obj["email"]."</span><br/>".
                "<span>".$obj["taxCode"]."</span><br/>".
                "<span>".$auth."</span>";
            })
            ->rawColumns(['customer_authenticated','customer', 'action'])
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
            //Column::make('_id')->title('Id')->width(100),
            //Column::make('promotion')->title('Khuyến mãi')->width(200),
            Column::make('customer')->title('Khách hàng')->width(200),
            Column::make('event')->title('Sự kiện')->width(200),
            Column::make('code')->title('Mã')->width(200),
            Column::make('usageLimit')->title('Tổng SL')->width(100),
            Column::make('userLimit')->title('Giới hạn')->width(100),
            //Column::make('minimumPurchaseAmount')->title('Mua tối thiểu')->width(100),
            //Column::make('usageCount')->title('SL đã sử dụng')->width(100),
            Column::make('startDate')->title('Thời gian')->width(250),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
            Column::make('useDate')->title('Thời gian sử dụng')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BudvarVoucher_' . date('YmdHis');
    }
}
