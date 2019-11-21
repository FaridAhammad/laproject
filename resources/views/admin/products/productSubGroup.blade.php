

@extends('layouts.admin')
@section('content')
    <div class="" style="background-color: #FFFFFF;">
        <div class="col-md-7 card float-left">
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
                                {{ trans('global.productSubGroup.fields.name') }} {{ trans('global.name') }}
                            </th>
                            <th>
                                {{ trans('global.productSubGroup.fields.productname') }}
                            </th>

                            <th>
                                &nbsp;&nbsp;
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $i=1;  ?>

                        @foreach($uams as $key => $uam)

                            <tr data-entry-id="{{ $uam->sub_group_id ?? '' }}">
                                <td>

                                </td>
                                <td>
                                    {{$i}}
                                </td>
                                <td>
                                    {{ $uam->sub_group_name ?? '' }}
                                </td>


                                <td>
                                    {{ $uam->product_group->group_name ?? '' }}

                                </td>
                                <td>

                                    @can('user_edit')
                                        <a class="btn btn-xs btn-info" href="{{route('admin.productsubgroup.edit', $uam->sub_group_id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan
                                    @can('user_delete')
                                        <form  method="POST" action="{{route('admin.productsubgroup.destroy', $uam->sub_group_id)}}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan
                                </td>

                            </tr>
                            <?php $i++;?>

                        @endforeach
                        </tbody>
                    </table>
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
                        url: "{{ route('admin.users.massDestroy') }}",
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
                    @can('user_delete')
                    dtButtons.push(deleteButton)
                    @endcan

                    $('.datatable:not(.ajaxTable)').DataTable({ buttons: dtButtons })
                })

            </script>
        @endsection

        <div class="card col-md-4 float-right " style=" margin-right:auto; ">

            <div class="card-header">
                {{ trans('global.create') }} {{ trans('global.productSubGroup.title') }}
            </div>









            <div class="card-body">
                <form action="@if($update==false){{ route('admin.productsubgroup.store') }} @elseif($update==true){{ route('admin.productsubgroup.update', $sub_group_id) }} @endif" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($update==true) @method('PUT')
                    @endif
                    <div class="form-group {{ $errors->has('sub_group_name') ? 'has-error' : '' }}">
                        <label for="sub_group_name"> {{ trans('global.productSubGroup.fields.name') }} {{ trans('global.name') }}*</label>
                        <input type="text" id="sub_group_name" name="sub_group_name" class="form-control" value="{{$gname??''}}"
                                {{--value="{{ old('username', isset($user) ? $user->username : '') }}"--}}
                        >
                        @if($errors->has('sub_group_name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('sub_group_name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('global.productSubGroup.fields.name_helper') }}
                        </p>
                    </div>







                    <div class="form-group {{ $errors->has('group_name') ? 'has-error' : '' }}">
                        <label for="group_name" >{{ trans('global.productSubGroup.fields.groupname') }}*  </label>
                        <select name="group_name" id="group_name"  class="form-control" >
                            <option selected disabled>Select a product group </option>
                            @foreach($product_gp as $key=> $pp)
                                <option value="{{$pp->group_id}}" @if($update==true) {@if($group_i==$pp->group_id) selected @endif } @endif>
                                    {{ $pp->group_name }}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('group_name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('group_name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('global.productSubGroup.fields.name_helper') }}
                        </p>
                    </div>

                    <div>
                        @if($update == true)
                            {{--<input class="btn btn-danger" type="submit" value="{{ trans('global.update') }}">--}}
                            <button class="btn btn-primary" type="submit" name="update">{{ trans('global.update') }} </button>


                        @elseif($update==false)
                            {{--<input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">--}}
                            <button class="btn btn-success" type="submit" name="save"  >{{ trans('global.save') }} </button>



                        @endif


                    </div>
                </form>

            </div>

        </div>
    </div>
@endsection



