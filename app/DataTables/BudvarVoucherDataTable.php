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
        //$lang = isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : '';
        //$type =  isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : 'product';

      

        $page = 1;
        $start = intval($this->request->get('start'));
        $length = intval($this->request->get('length'));
        if ($length == -1) $length = 10;
        if ($start == 0) $page = 1;
        else $page = ($start / $length) + 1;

        $data = BudvarApi::get('/voucher/findAll', ['code' => $title, 'page' => $page, 'record_per_page' => $length]);
  
        //dd($data);
        return datatables()
            ->collection($data->data)        
            ->skipPaging()      
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->filter(function () {})

            ->addColumn('action', 'admin.budvar.voucher.action')
            //->addColumn('promotion', '{{empty($promotion) ? "" : $promotion}} ')
            ->addColumn('code', '{{empty($code) ? "" : $code}} ')
            ->addColumn('usageLimit', '{{empty($usageLimit) ? "" : $usageLimit}} ')
            ->addColumn('userLimit', '{{empty($userLimit) ? "" : $userLimit}}')
            //->addColumn('minimumPurchaseAmount', '{{empty($minimumPurchaseAmount) ? "" : $minimumPurchaseAmount}}')
            //->addColumn('usageCount', '{{empty($usageCount) ? "" : $usageCount}}')
            ->addColumn('startDate', '{{empty($startDate) ? "" :  \App\Common\Utility::displayDateTime($startDate) }} - {{empty($endDate) ? "" :  \App\Common\Utility::displayDateTime($endDate) }}')
            ->addColumn('createdAt', '{{empty($createdAt) ? "" :  \App\Common\Utility::displayDateTime($createdAt) }}')
            ->addColumn('event_name', function ($obj) {
                if (empty($obj["event"])) return "";
                $event =  $obj["event"];
                if (empty($event['title'])) return "";
                return $event['title'];
            })
            ->addColumn('useDate', '{{empty($timeOfUse) ? "" :  \App\Common\Utility::displayDateTime($timeOfUse) }}')
            ->addColumn('promotion', function ($obj) {
                if (empty($obj["promotion"])) return "";
                $promotion =  $obj["promotion"];
                if (empty($promotion['name'])) return "";
                return $promotion['name'];
            })
            ->addColumn('customer', function ($v) {
                if(!isset($v['owner'])) return "";
                $obj = $v['owner'];
                if (isset($obj["authenticated"]) && $obj["authenticated"] == true) $auth= "<span class='btn btn-sm btn-success text-nowrap'>Đã xác thực</span>";
                else $auth= "<span class='btn btn-sm btn-secondary text-nowrap'>Chưa xác thực</span>";

                return "<span>".$obj["fullname"]."</span><br/>".
                //"<span>".$obj["phoneNumber"]."</span><br/>".
                "<span>".$obj["email"]."</span><br/>".
                //"<span>".($obj["taxCode"] ?? "")."</span><br/>".
                "<span>".$auth."</span>";
            })
            ->addColumn('use', function ($v) {
                //$ck = isset( $v['usageCount'] ) && $v['usageCount'] > 0 && $v['usageCount']   <= $v['usageLimit'];
                if(isset( $v['isUsed'] ) && $v['isUsed']) return "<span class='btn btn-sm btn-success text-nowrap'>Đã sử dụng</span>";
                else return "<span class='btn btn-sm btn-secondary text-nowrap'>Chưa sử dụng</span>";
                //if($ck) return 'Đã sử dụng';
                //else return 'Chưa sử dụng';
            })
            ->addColumn('address', function ($v) {
                if(!isset($v['location'] )) { return ""; }
                else { 
                    return ( $v['location']['name'] ?? "") .("<br/>").($v['location']['address'] ?? ""); 
                }
                //if($ck) return 'Đã sử dụng';
                //else return 'Chưa sử dụng';
            })
           // ->addColumn('event', function ($v) {
           //     if(!isset($v['owner'])) return "";
           //     $obj = $v['owner'];
           //     if (isset($obj["authenticated"]) && $obj["authenticated"] == true) $auth= "<span class='btn btn-sm btn-success'>Đã xác thực</span>";
           //     else $auth= "<span class='btn btn-sm btn-secondary'>Chưa xác thực</span>";
           // })
            ->rawColumns(['customer_authenticated','customer', 'action','use','address'])
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
            //Column::make('_id')->title('Id')->width(100),
            //Column::make('promotion')->title('Khuyến mãi')->width(200),
            Column::make('customer')->title('Khách hàng')->width(200),
            Column::make('address')->title('Địa chỉ cửa hàng')->width(200),
            Column::make('event_name')->title('Sự kiện')->width(200),
            Column::make('code')->title('Mã')->width(200),
            //Column::make('usageLimit')->title('Tổng SL')->width(100),
            //Column::make('userLimit')->title('Giới hạn')->width(100),
            //Column::make('minimumPurchaseAmount')->title('Mua tối thiểu')->width(100),
            //Column::make('usageCount')->title('SL đã sử dụng')->width(100),
            //Column::make('startDate')->title('Thời gian')->width(250),
            Column::make('createdAt')->title('Ngày tạo')->width(150),
            Column::make('use')->title('Trạng thái sử dụng')->width(200),
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
