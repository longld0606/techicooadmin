
// getFormObject => object { a:'1',b:'2' }
function getFormObject($form) {
    var array = $form.serializeArray();
    var obj = {};
    //console.log(array);
    $.map(array, function (n, i) {
        var name = n['name'];
        obj[name] = n['value'];
        // ckeditor
        if ($form.find('[name=' + name + ']').hasClass('ckeditor')) {
            var _id = $form.find('[name=' + name + ']').attr('id');
            if (_id != undefined && _id.length > 0) {
                obj[name] = CKEDITOR.instances[_id].getData();
            }
        }
        if ($form.find('select').attr('multiple') == 'multiple') {
            obj[name] = $form.find('[name=' + name + ']').val();
        }
    });
    // if ($form.find('input[type=file]').length > 0) {
    //     var $files = $form.find('input[type=file]'); 
    //      $.each($files, function (i, e) {
    //          var n = $(e).attr('name');
    //          var v = e.files; 
    //          obj[n] = v;
    //     });
    // } 
    return obj;
}

function getFormData($form) {
    var data = new FormData();
    var obj = getFormObject($form);
    $.each(obj, function (k, v) {
        if (typeof v == 'object' && Array.isArray(v)) {
            $.each(v, function (i, e) {
                data.append(k + '[]', e);
            })
        } else {
            data.append(k, v);
        }
    });
    if ($form.find('input[type=file]').length > 0) {
        // xử lý thêm phần 1 input nhiều file - muti
        var $files = $form.find('input[type=file]');
        $.each($files, function (i, e) {
            var n = $(e).attr('name');
            //var v = e.files[0]; 
            if (e.files.length > 1) {
                $.each(e.files, function (j, f) {
                    //  console.log('append 1: ',n+'[]', f);
                    data.append(n + '[]', f);
                });
            } else {
                //  console.log('append 2: ',n, e.files[0]);
                data.append(n, e.files[0]);
            }
        });
    }

    return data;
}

// getFormQuery
function getFormQuery($form) {
    var unindexed_array = $form.serialize();
    return unindexed_array;
}

function showLoading(msg) {
    loadingFlag = true;
    if (!msg) msg = "";
    if ($("body > div.ajaxInProgress").length <= 0) {
        var str = '<div class="ajaxInProgress"><div class="loading-ct" >' +
            '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><div class="load-msg"></div>' +
            ' </div> </div>';
        $("body").append(str);
    }
    // add div
    if ($("body > div.ajaxInProgress div.load-msg").length <= 0) {
        $("body > div.ajaxInProgress > div.loading-ct").append('<div class="load-msg"></div>');
    }
    //ađ text
    $("body > div.ajaxInProgress div.load-msg").html(msg);

    $("body > div.ajaxInProgress").show();
}

function hideLoading() {
    loadingFlag = false;
    if ($("body > div.ajaxInProgress").length > 0)
        $("body > div.ajaxInProgress").hide();
}

function ajaxGet(url, body, isShowLoading = true) {
    var data_str = "";
    if (body != null && body.length > 0) {
        data_str = Object.keys(body).map(function (key) {
            return key + '=' + obj[key];
        }).join('&');
        url = url + "?" + data_str;
    }
    return $.ajax({
        url: url,
        type: "GET",
        //data: data,
        //contentType: (option.contentType != undefined ? option.contentType : 'application/x-www-form-urlencoded; charset=UTF-8'),
        beforeSend: function () {
            if (isShowLoading) showLoading();
        },
        complete: function () {
            if (isShowLoading) hideLoading();
        }
    })//.always(function () { hideLoading(); });
}

function ajaxPostForm(url, formData, isShowLoading = true) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    if (formData != undefined && formData.get('_token') != undefined && formData.get('_token').length > 0) {
        _token = formData.get('_token');
    }
    // post file để type = post và có _method = put theo router
    return $.ajax({
        url: url,
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': _token },
        enctype: 'multipart/form-data',
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function () {
            if (isShowLoading) showLoading();
        },
        complete: function () {
            if (isShowLoading) hideLoading();
        }
    })
        .fail(function (e) {
            if (e.responseText != undefined) {
                var err = JSON.parse(e.responseText);
                alert("Lỗi: " + err.message);
            } else {
                alert("Lỗi: " + e.statusText);
            }
        })

}

function ajaxPost(url, body, isShowLoading = true) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    if (body != undefined && body._token != undefined && body._token.length > 0) {
        _token = body._token
    }
    var _type = "POST";
    if (body != undefined && body._method != undefined && body._method.length > 0) {
        _type = body._method == 'PATCH' ? "PUT" : "POST";
    }
    return $.ajax({
        url: url,
        type: _type,
        dataType: "json",
        headers: { 'X-CSRF-TOKEN': _token },
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(body),
        //data: data,
        //contentType: (option.contentType != undefined ? option.contentType : 'application/x-www-form-urlencoded; charset=UTF-8'),
        beforeSend: function () {
            if (isShowLoading) showLoading();
        },
        complete: function () {
            if (isShowLoading) hideLoading();
        }
    })//.always(function () { hideLoading(); });
        .fail(function (e) {
            if (e.responseText != undefined) {
                var err = JSON.parse(e.responseText);
                alert("Lỗi: " + err.message);
            } else {
                alert("Lỗi: " + e.statusText);
            }
        })
}

function ajaxPut(url, body, isShowLoading = true) {
    var _token = $('meta[name="csrf-token"]').attr('content');
    if (body != undefined && body._token != undefined && body._token.length > 0) {
        _token = body._token
    }
    return $.ajax({
        url: url,
        type: "PUT",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': _token
        },
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(body),
        //data: data,
        //contentType: (option.contentType != undefined ? option.contentType : 'application/x-www-form-urlencoded; charset=UTF-8'),
        beforeSend: function () {
            if (isShowLoading) showLoading();
        },
        complete: function () {
            if (isShowLoading) hideLoading();
        }
    })//.always(function () { hideLoading(); });
        .fail(function (e) {
            if (e.responseText != undefined) {
                var err = JSON.parse(e.responseText);
                alert("Lỗi: " + err.message);
            } else {
                alert("Lỗi: " + e.statusText);
            }
        })
}

function ajaxDelete(url, body) {
    return $.ajax({
        url: url,
        type: "DELETE",
        dataType: "json",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(body),
        //data: data,
        //contentType: (option.contentType != undefined ? option.contentType : 'application/x-www-form-urlencoded; charset=UTF-8'),
        beforeSend: function () {
            showLoading();
        },
        complete: function () {
            hideLoading();
        }
    })//.always(function () { hideLoading(); });
        .fail(function (e) {
            if (e.responseText != undefined) {
                var err = JSON.parse(e.responseText);
                alert("Lỗi: " + err.message);
            } else {
                alert("Lỗi: " + e.statusText);
            }
        })
}

// thông báo
function alertSuccess(text, callback) {
    swal({
        title: "Thông báo",
        text: text,
        button: "OK",
        dangerMode: false,
    }).then(function () {
        if (typeof callback == "function") callback();
    });
}

function alertError(text, callback) {
    swal({
        title: "Lỗi",
        text: text,
        button: "OK",
        dangerMode: true,
    }).then(function () {
        if (typeof callback == "function") callback();
    });
}

function alert(text, callback) {
    if (text.toLowerCase().indexOf('lỗi') > -1 || text.toLowerCase().indexOf('error') > -1) {
        alertError(text, callback);
    } else {
        alertSuccess(text, callback);
    }
}

function confirm(options, callback) {
    var title = "Xác nhận",
        text = "Bạn chắc chắn muốn xóa?",
        type = "error";
    options = options || {};
    if (options.title != undefined) {
        title = options.title;
    }
    console.log(title);
    if (options.text != undefined) {
        text = options.text;
    }
    if (options.type != undefined) {
        type = options.type;
    }

    swal({
        title: title,
        text: text,
        buttons: true,
        dangerMode: type == 'error' ? true : false,
    }).then(function (isConfirm) {
        if (!isConfirm) return;
        callback();
    });
}

function notify(text, callback) {
    // $.notify(text,{
    //     clickToHide: true,
    //     // whether to auto-hide the notification
    //     autoHide: false,
    //     // if autoHide, hide after milliseconds
    //     autoHideDelay: 5000000, 
    //     // default class (string or [string])
    //     className: 'success', 
    //   });
    $.notify(text, "success");
    if (typeof callback == "function") callback();
}

function notifyError(text, callback) {
    $.notify(text, "error");
    if (typeof callback == "function") callback();
}






function initInput(ckInput_id) {
    $('.select2').select2({ width: '100%' });
    $('.datepicker').datepicker({ autoclose: true, format: 'dd/mm/yyyy', });
    // CKEDITOR.config.toolbar = [
    //     ['Styles', 'Format', 'Font', 'FontSize'],
    //     ['Bold', 'Italic', 'Underline', 'StrikeThrough', '-', 'Undo', 'Redo', '-', 'Cut', 'Copy', 'Paste', 'Find', 'Replace', '-', 'Outdent', 'Indent', '-', 'Print'],
    //     ['NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
    //     ['Image', 'Table', '-', 'Link', 'Flash', 'Smiley', 'TextColor', 'BGColor', 'Source']
    // ];
    // CKEDITOR.config.entities = false;
    // CKEDITOR.config.basicEntities = false;
    // CKEDITOR.config.height = '25em';     ;
    CKEDITOR.config.extraPlugins = 'justify';

    // CKEDITOR.config.extraPlugins = "file-manager";
    // CKEDITOR.config.Flmngr ={
    //     apiKey: "FLMNFLMN",
    //     urlFileManager: '/file_mngr',
    //     urlFiles: '/files/'
    // }; 
    CKEDITOR.replaceClass = 'ckeditor';
    $('.wysihtml5').wysihtml5();
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
    });
    if (ckInput_id != undefined && $('#' + ckInput_id).length > 0) {
        CKEDITOR.replace(ckInput_id);

    }
}

$.extend(true, $.fn.dataTable.defaults, {
    // 'language': 'vi-VN',
    // 'paging': true,
    // 'lengthChange': true,
    // 'searching': true,
    // 'ordering': true,
    // 'info': true,
    // 'autoWidth': false,
    // 'dom': ('<"row"<"col-sm-12"itr>><"row"<"col-sm-4"l><"col-sm-8"p>>'),
    'language': {
        'sProcessing': 'Đang xử lý...',
        'sLengthMenu': '_MENU_',
        'sZeroRecords': 'Không tìm thấy dữ liệu phù hợp',
        'sInfo': 'Hiển thị _START_ đến _END_ trong tổng số _TOTAL_ mục',
        // 'sInfoEmpty': 'Hiển thị 0 đến 0 trong tổng số 0 mục',
        'sInfoFiltered': '(được lọc từ _MAX_ mục)',
        'sInfoPostFix': '',
        'sSearch': 'Tìm:',
        'sUrl': '',
        'oPaginate': {
            'sFirst': 'Đầu',
            'sPrevious': 'Trước',
            'sNext': 'Tiếp',
            'sLast': 'Cuối'
        }
    },
    //'processing': true,
    // 'serverSide': true,
    // 'initComplete': function (settings, json) {
    //     hideLoading();
    // },
});

function activeMenuParent(menu) {
    menu.parents('.nav-treeview').css({ 'display': 'block' })
        .addClass('menu-open').prev('a').addClass('active').parent().addClass('active');
}
function activeMenu() {
    var _href = window.location.href;
    // for single sidebar menu
    $('ul.sidebar-menu li>a').filter(function (i, e) {
        return ($(e).attr('href') == _href || _href.indexOf($(e).attr('href')) == 0);
    }).addClass('active').parent().addClass('active');

    var menu = $('ul.sidebar-menu a.active');
    if (menu.length > 0) {
        activeMenuParent(menu);
    } else {
        console.log(_href);
    }
}

$(function () {
    initInput();
    activeMenu();

    $('.app-main').on('click', '.confirm-action', function (e) {
        var $this = $(this),
            url = $this.data('href'),
            id = $this.data('id');
        type = $this.data('type');

        confirm({ title: 'Xác nhận', text: $this.data('msg') ?? "Bạn chắc chắn muốn thực hiện thao tác này?", type: type ?? 'success' }, function () {
            ajaxPut(url, { id: id }).done(function (e) {
                if (e.status == 'success') {
                    notify('Thao tác thành công', function () {
                        if (typeof getData == 'function') getData();
                        if (typeof searchTable == 'function') searchTable();
                        if (typeof reload == 'function') reload();
                    });
                }
                else alert('Thao tác lỗi: ' + e.message);
            }).fail(function (e) {
                console.log(e);
                alert("error");
            })
        });

        //     return false;
        // }
        // App.sweetDeleteItemMessage(url, ids);
        // e.preventDefault();
    });
    $('.app-main').on('click', 'table  .delete-item', function (e) {
        var $this = $(this),
            url = $this.data('href'),
            id = $this.data('id');

        confirm({}, function () {
            ajaxDelete(url, { id: id }).done(function (e) {
                if (e.status == 'success') {
                    notify('Thao tác thành công', function () {
                        if (typeof getData == 'function') getData();
                        if (typeof searchTable == 'function') searchTable();
                        if (typeof reload == 'function') reload();
                    });
                }
                else alert('Thao tác lỗi: ' + e.message);
            }).fail(function () {
                alert("error");
            })
        });

        //     return false;
        // }
        // App.sweetDeleteItemMessage(url, ids);
        // e.preventDefault();
    });

    $(document).ready(function () {
        $(".form-item").on("submit", function () {
            showLoading();
        });

        $(".search-box .form-control").on('keyup', function (e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                if (typeof getData == 'function') getData();
                if (typeof search == 'function') search();
                if (typeof reload == 'function') reload();
            }
        });
    });


    $(".search-box .form-control").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            searchTable();
        }
    });

});

function searchTable() {
    $table = window.LaravelDataTables["data-table"];
    $table.ajax.reload();
}

function onExport(type) {
    console.log(type);
    var index = -1;
    $.each(window.LaravelDataTables['data-table'].buttons(), function (i, e) {
        if (e.node.className.indexOf(type) > -1) index = i;
    });
    if (index > -1) {
        window.LaravelDataTables["data-table"].buttons(index).trigger();
    } else {
        alertError('Vui lòng thử lại sau!')
    }
}
