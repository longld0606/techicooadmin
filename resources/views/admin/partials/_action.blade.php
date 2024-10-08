 <div class="btn-group">
     <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
         <span class="caret"></span>
         <span class="sr-only"></span>
     </button>
     <ul class="dropdown-menu" role="menu">
         @if (!(isset($view) && $view == false))
             <li><a class="dropdown-item" href="{{ route($ctrl . '.show', $id) }}"> <i
                         class="fa fa-fw fa-info-circle"></i>
                     Xem</a></li>
         @endif
         @if (isset($clone) && $clone == true)
             <li><a class="dropdown-item" href="{{ route($ctrl . '.clone', $id) }}"> <i class="fa fa-fw fa-clone"></i>
                     Nhân bản</a></li>
         @endif
         @if (!(isset($edit) && $edit == false))
             <li><a class="dropdown-item" href="{{ route($ctrl . '.edit', $id) }}"> <i class="fa fa-fw fa-edit"></i>
                     Chỉnh
                     sửa</a></li>
         @endif
         @if (!(isset($delete) && $delete == false))
             <li class="dropdown-divider"> </li>
             <li>
                 <a class="dropdown-item delete-item" title="Xóa" href="javascript:void(0);"
                     data-href="{{ route($ctrl . '.destroy', $id) }}" data-id={{ $id }}>
                     <i class="fa fa-fw fa-trash-o"></i> Xóa
                 </a>
             </li>
         @endif
     </ul>
 </div>
