@extends('layouts.admin')
@section('content')
@can('permission_create')
    
@endcan
<div class="container">
<div class="row">
<div class="col">
<div class="card">
    

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th width="10">
                        
                        </th>
                        <th>
                        {{ trans('global.sl') }}
                        </th>
                       
                        <th>
                            {{ trans('global.unitManages.fields.unitname') }}
                        </th>
                        

                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php $num = 1;  ?>
                    @foreach($uams as $uams)
                        <tr data-entry-id="{{ $uams->id }}">
                            <td>
                            
                            </td>
                            <td>
                            {{ $num }}
                            </td>
                           
                            <td>
                            {{ $uams->unit_name }}
                            </td>

                            

                            <td>
                                
                                @can('permission_edit')
                                <a href="{{ route('admin.unitmanage.edit', $uams->id) }}" class="btn btn-xs btn-info">Edit</a>
                               
                                
                               
                                
                                   
                                @endcan
                                @can('permission_delete')
                                    <form action="{{ route('admin.unitmanage.destroy',  $uams->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" name='delete' value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                        <?php $num++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>    
    </div>

    <div class="col">
      
      <div class="card">
      <div class="card-header">
          {{ trans('global.create') }} {{ trans('global.unitManages.fields.unit') }}
      </div>
  
      <div class="card-body">
  
      <form action="@if($update==false) {{ route('admin.unitmanage.store') }} @elseif($update==true) {{ route('admin.unitmanage.update', $id) }} @endif" method="POST" enctype="multipart/form-data">
      @csrf
      @if($update==true) @method('PUT')
      @endif
      <div class="form-group">
                  <label for="name">Unit Name*</label>
                  <input type="text" id="name" name="unit_name" class="form-control{{ $errors->has('unit_name') ? ' is-invalid' : '' }}" value="{{ $name }}">
                  @if($errors->has('unit_name'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('unit_name') }}
                      </em>
                  @endif
                 
              </div>
  
              <div class="form-group">
                  <label for="detail">Unit Detail</label>
                  <input type="text" id="detail" name="unit_detail" class="form-control{{ $errors->has('detail') ? ' is-invalid' : '' }}" value="{{ $detail }}">
                  @if($errors->has('detail'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('detail') }}
                      </em>
                  @endif
                  
              </div>
      
             <div class="row">

             @if($update == true)

             <div class="col">
                  <button class="btn btn-danger" name="update" type="submit" value="update">Update</button>
              </div>
             @elseif($update == false)
             <div class="col">
                  <input class="btn btn-danger" type="submit" name="adduser" value="Add User" >
              </div>
                      
            @endif
             
             </div>
  
         </form>     
  
      </div>
  
      </div>
  </div>


  </div>




    
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.permissions.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('permission_delete')
  dtButtons.push(deleteButton)
@endcan

  $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
})

</script>
@endsection


@endsection
