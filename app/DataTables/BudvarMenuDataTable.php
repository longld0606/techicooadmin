<?php

namespace App\DataTables;

use App\Common\BudvarApi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BudvarMenuDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable()
    {
        $name = isset($this->request->get('search')['value']) ?  $this->request->get('search')['value'] : '';
        $lang =  isset($this->request->get('search')['lang']) ?  $this->request->get('search')['lang'] : '';
        $location =  isset($this->request->get('search')['location']) ?  $this->request->get('search')['location'] : '';
        $parent_id =  isset($this->request->get('search')['parent_id']) ?  $this->request->get('search')['parent_id'] : '';
        $params = [];
        if (!empty($name))
            $params['name'] = $name;
        if (!empty($lang))
            $params['lang'] = $lang;
        if (!empty($parent_id))
            $params['parentID'] = $parent_id;
        if (!empty($location))
            $params['location'] = $location; 

        $data = BudvarApi::get('/menu/findAllCms', $params);
        return datatables()
            ->collection($data->data)
            ->filter(function () {})
            ->skipPaging()

            ->addColumn('action', 'admin.budvar.menu.action')
            ->addColumn('lang', '{{empty($lang) ? "Vi" : $lang}} ')
            ->addColumn('name', '{{empty($name) ? "none" : $name}} ')
            ->addColumn('link', '{{empty($link) ? "" : $link}}')
            // ->addColumn('status', '{{empty($status) ? "" : $status}}')
            ->addColumn('location', '{{empty($location) ? "" : $location}}')
            //->addColumn('parentID', '{{empty($parentID) ? "" : $parentID}}')
            ->addColumn('parentID', function ($item) {
                if (!isset($item)) return '';
                if (!isset($item['parentID'])) return '';
                return $item['parentID']['name'];
            })
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
                'search["parent_id"]' => '$("[name=parent_id]").val()',
                'search["lang"]' => '$("[name=lang]").val()',
                'search["location"]' => '$("[name=location]").val()',
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
            Column::make('lang')->title('Ngôn ngữ')->width(100),
            Column::make('name')->title('Tên')->width(300),
            Column::make('location')->title('Vị trí')->width(100),
            Column::make('parentID')->title('Cấp trên')->width(300),
            // Column::make('status')->title('Trạng thái')->width(100),
            Column::make('link')->title('Link'),
            //Column::make('createdAt')->title('Ngày tạo')->width(150),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'BudvarMenu_' . date('YmdHis');
    }
}
