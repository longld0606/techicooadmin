@extends('admin.layouts.app')
@section('content')
    <section class="app-content ">
        <div class="card card-secondary card-outline  mb-4 mt-4 item-box">
            <div class="card-body">
                @include('admin.partials._alerts')
                <?php //var_dump($data);
                $keys = []; ?>
                <form class="form-item" method="POST" action="{{ '/' }}" enctype="multipart/form-data">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">Ngôn ngữ</th>
                                @foreach ($data as $k => $item)
                                    <?php array_push($keys, $k); ?>
                                    <th>{{ $k }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['vn'] as $key => $val)
                                <tr data-item="{{ $key }}">
                                    <td>
                                        <div class="d-flex justify-content-between"><strong
                                                class="kkk">{{ $key }}</strong>
                                            &nbsp; <i class="fa fa-plus addKey mt-1"></i></div>
                                    </td>
                                    @foreach ($keys as $i => $ks)
                                        <td>
                                            <div class="item-setting">
                                                <?php $item = $data[$ks][$key]; ?>
                                                @foreach ($item as $ki => $ite)
                                                    <?php $r = round(strlen($ite) / 55); ?>
                                                    <div class="key-setting" data-key="{{ $ki }}">
                                                        <div class="d-flex justify-content-between ">
                                                            <label class="bold">{{ $ki }} </label>
                                                            <div>
                                                                @if ($i == 0)
                                                                    <i class="fa fa-edit edit"></i>&nbsp;&nbsp;&nbsp;
                                                                    <i class="fa fa-trash remove"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <textarea class="form-control mb-3" rows="{{ $r == 0 ? 1 : $r }}">{{ $ite }}</textarea>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-fw fa-plus addItem"></i></th>
                                <th colspan="3"></th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="text-end">
                        <button type="button" class="btn btn-primary saveSetting"><i class="fa fa-save"></i>
                            &nbsp;{{ __('Lưu') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        // item = section_post,section_product,........
        // key = topic,title,description........
        function onAddItem() {
            console.log('add vào cuối bảng', 'thêm mặc định 1 key = title cho mỗi ngôn ngữ khác nhau');
            var input = '<input type="text" class="form-control" name="sItem" />';
            onModal('Thêm mới item setting', input, 'md', function() {
                var val = $('#modal input[name=sItem]').val();
                if (val == undefined || val.length == 0) {
                    notifyError('Vui lòng nhập item setting mới');
                    return;
                }
                val = val.trim();
                if (val.indexOf(' ') > -1) {
                    notifyError('Vui lòng nhập không có khoảng cách');
                    return;
                }
                var htmlKey = '<div class="d-flex justify-content-between"><strong class="kkk">' + val +
                    '</strong>&nbsp; <i class="fa fa-plus addKey mt-1"></i></div>';
                $('.table tbody').append('<tr data-item=' + val + '><td>' + htmlKey +
                    '</td><td><div class="item-setting"></div><td><div class="item-setting"></div><td><div class="item-setting"></div></tr>'
                );
                notify('Thêm item mới thành công!');
                $('#modal').modal('hide');
            });
        }

        function onAddKey($tr, item) {
            console.log('add key vào item nào của tr nào', $tr, item);
            var input = '<input type="text" class="form-control" name="sKey" />';
            onModal('Thêm mới key setting', input, 'md', function() {
                var val = $('#modal input[name=sKey]').val();
                if (val == undefined || val.length == 0) {
                    notifyError('Vui lòng nhập key setting mới');
                    return;
                }
                val = val.trim();
                if (val.indexOf(' ') > -1) {
                    notifyError('Vui lòng nhập không có khoảng cách');
                    return;
                }
                var htmlKey = '<div class="key-setting" data-key="' + val + '">' +
                    '<div class="d-flex justify-content-between ">' +
                    '<label class="bold">' + val + '</label>' +
                    '<div>' +
                    '<i class="fa fa-edit edit"></i>&nbsp;&nbsp;&nbsp;' +
                    '<i class="fa fa-trash remove"></i>' +
                    '</div>' +
                    '</div>' +
                    '<textarea class="form-control mb-3" rows="1"></textarea>' +
                    '</div>';
                $tr.find('.item-setting').append(htmlKey);
                notify('Thêm key mới thành công!');
                $('#modal').modal('hide');
            });
        }

        function onEdit($tr, item, key) {
            console.log('edit key nào của item nào', $tr, item, key);
            var input = '<input type="text" class="form-control" name="sKey" value=' + key + ' />';
            onModal('Chỉnh sửa key setting', input, 'md', function() {
                var val = $('#modal input[name=sKey]').val();
                if (val == undefined || val.length == 0) {
                    notifyError('Vui lòng nhập item setting mới');
                    return;
                }
                val = val.trim();
                if (val.indexOf(' ') > -1) {
                    notifyError('Vui lòng nhập không có khoảng cách');
                    return;
                }
                $tr.find('.item-setting .key-setting[data-key=' + key + '] label').html(val);
                notify('Chỉnh sửa item thành công!');
                $('#modal').modal('hide');
            });
        }

        function onRemove($tr, item, key) {
            console.log('remove key nào của item nào', $tr, item, key);
            confirm({
                title: 'Xác nhận',
                text: 'Bạn chắc chắn muốn xóa key này'
            }, function() {
                $tr.find('.key-setting[data-key=' + key + ']').remove();
            });
        }

        // post - save
        function onSave() {
            var data = {
                'setting': {}
            };
            var items = [];
            $('.table tbody tr').each(function(i, e) {
                var item = $(e).find('td:first .kkk').text().trim();
                items.push(item);
            });
            var langs = [];
            $('.table thead tr th').each(function(j, el) {
                if (j == 0) return;
                langs.push($(el).text().trim());
            });

            $.each(langs, function(j, lag) {
                var obj = {}
                $.each(items, function(ii, item) {
                    // j +1 do bắt đầu từ 0; + thêm 1 do bỏ 1 td ở langs
                    $td = $('.table tr[data-item=' + item + ']').find('td:nth-child(' + (j + 1 + 1) + ')');
                    var obj_item = {};
                    $td.find('.key-setting').each(function(i, elm) {
                        var key = $(elm).find('label').text().trim();
                        var val = $(elm).find('textarea').val().trim();
                        obj_item[key] = val;
                    });
                    obj[item] = obj_item;
                });
                data.setting[lag] = obj;
            });

            ajaxPost('/admin/budvar/setting/update', {setting: data}, true)
                .then(function(rs) {
                    notify('Cập nhật cấu hình thành công!');
                });

        }
        $(function() {
            $('.table').on('click', '.fa', function(e) {
                $e = $(e.target);
                if ($e.hasClass('addItem')) {
                    onAddItem();
                    return;
                }
                if ($e.hasClass('addKey')) {
                    onAddKey($e.closest('tr'), $e.closest('tr').find('.kkk').text());
                    return;
                }
                if ($e.hasClass('edit')) {
                    onEdit($e.closest('tr'), $e.closest('tr').find('.kkk').text(), $e.parent().parent()
                        .find('label').text());
                    return;
                }
                if ($e.hasClass('remove')) {
                    onRemove($e.closest('tr'), $e.closest('tr').find('.kkk').text(), $e.parent().parent()
                        .find('label').text());
                    return;
                }
            });
            $('.saveSetting').click(onSave);
        });
    </script>
@endpush
