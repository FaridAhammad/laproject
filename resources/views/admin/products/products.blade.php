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
                            {{ trans('global.product_management_child.fields.itemname') }}
                        </th>
                        

                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $num= 1; ?>
                    @foreach($item as $item)
                        <tr data-entry-id="{{ $item->item_id }}">
                            <td>
                            
                            </td>
                            <td>
                            {{ $num }}
                            </td>
                        
                            <td>
                            {{ $item->item_name }}
                            </td>

                            

                            <td>
                                
                                @can('permission_edit')
                                <a href="{{ route('admin.productmanage.edit', $item->item_id) }}" class="btn btn-xs btn-info">Edit</a>
                               
                                
                               
                                
                                   
                                @endcan
                                @can('permission_delete')
                                    <form action="{{ route('admin.productmanage.destroy', $item->item_id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
      {{ trans('global.product_management_child.fields.productinfo') }}
      </div>
  
      <div class="card-body">
  
      <form action="@if($update==false) {{ route('admin.productmanage.store') }} @elseif($update==true) {{ route('admin.productmanage.update', $id) }} @endif" method="POST" enctype="multipart/form-data">
      @csrf
      @if($update==true) @method('PUT')
      @endif
      
      <div class="form-group">
                  <label for="item_name">{{ trans('global.product_management_child.fields.itemname') }}*</label>
                  <input type="text" id="item_name" name="item_name" class="form-control{{ $errors->has('item_name') ? ' is-invalid' : '' }}" value="{{ $itemname }}">
                  @if($errors->has('item_name'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('item_name') }}
                      </em>
                  @endif
                 
              </div>

              <div class="form-group">
                  <label for="sub_group_name">{{ trans('global.product_management_child.fields.sub_group_name') }}*</label>
                
                  <select name="sub_group_name" id="sub_group_name" class="form-control{{ $errors->has('sub_group_name') ? ' is-invalid' : '' }}">
                  <option></option>
                  @foreach($sub_item as $id=>$sub_item)
                  <option value="{{ $id }}"  @if($update==true) { @if($sub_group_name == $id) selected @endif } @endif> {{ $sub_item }} </option>
                  @endforeach
                  
                  </select>
                  @if($errors->has('sub_group_name'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('sub_group_name') }}
                      </em>
                  @endif
                 
                 
              </div>   
  
              <div class="form-group">
                  <label for="details">{{  trans('global.product_management_child.fields.details') }}</label>
                  <input type="text" id="details" name="details" class="form-control" value="{{ $details }}">  
              </div>


              <div class="form-group">
                  <label for="product_nature">{{ trans('global.product_management_child.fields.product_nature') }}*</label>
                
                  <select name="product_nature" id="product_nature" class="form-control{{ $errors->has('product_nature') ? ' is-invalid' : '' }}">
                  <option></option>
                  
                  <option value="Purchasable" @if($update==true) { @if($product_nature == "Purchasable") selected @endif } @endif>Purchasable</option>
                  <option value="Salable" @if($update==true) { @if($product_nature == "Salable") selected @endif } @endif>Salable</option>
                  <option value="Both"  @if($update==true) { @if($product_nature == "Both") selected @endif } @endif>Both</option>
                  </select>

                  @if($errors->has('product_nature'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('product_nature') }}
                      </em>
                  @endif
                 
                 
              </div>   


              <div class="form-group">
                  <label for="unit_name">{{ trans('global.unitManages.fields.unitname') }}*</label>
                
                  <select name="unit_name" id="unit_name" class="form-control{{ $errors->has('unit_name') ? ' is-invalid' : '' }}">
                  <option></option>
                  @foreach($unit_item as $id=>$unit_item)
                  <option value="{{ $unit_item }}" @if($update == true) { @if($unit_name == $unit_item) selected  @endif}@endif>{{ $unit_item }}</option>
                  @endforeach
                  </select>
                  @if($errors->has('unit_name'))
                      <em class="invalid-feedback" role="alert">
                          {{ $errors->first('unit_name') }}
                      </em>
                  @endif
                 
              </div>   


              <div class="form-group">
                  <label for="cost">{{  trans('global.product_management_child.fields.cost_price') }}</label>
                  <input type="text" id="cost" name="cost" class="form-control" value="{{ $cost }}">  
              </div>
             

              <div class="form-group">
                  <label for="sale">{{  trans('global.product_management_child.fields.sale_price') }}</label>
                  <input type="text" id="sale" name="sale" class="form-control" value="{{ $sale }}">  
              </div>




      
             <div class="row">

             @if($update == true)


             <div class="col">
                  <button class="btn btn-danger" name="update" type="submit" value="{{ trans('global.update') }}">{{ trans('global.update') }}</button>
              </div>
             @elseif($update == false)
             
             <div class="col">
                  <input class="btn btn-success" type="submit" name="adduser" value="{{ trans('global.save') }}" >
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