
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
                            S/L
                        </th>
                        <th>
                            {{ trans('global.user.fields.id') }}
                        </th>
                        <th>
                            {{ trans('global.user.fields.name') }}
                        </th>

                        <th>
                            {{ trans('global.user.fields.user_type') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($uams as $key => $uam)

                        <tr data-entry-id="{{ $uam->id }}">
                            <td>

                            </td>
                            <td>
                                {{$sa=1}}
                            </td>
                            <td>
                                {{ $uam->user_id ?? '' }}
                            </td>
                            <td>
                                {{ $uam->username ?? '' }}
                            </td>

                            <td>
                                <span class="badge badge-info">{{ $uam->user_type_name }}</span>
                                
                            </td>
                            <td>
                                
                                    
                            
                                
                                    <a class="btn btn-xs btn-info" href="{{route('admin.usermanage.edit', $uam->user_id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                
                                
                                    <form  method="POST" action="{{route('admin.usermanage.destroy', $uam->user_id)}}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                            
                            </td>

                        </tr>

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
            {{ trans('global.create') }} {{ trans('global.user.title_singular') }}
        </div>









        <div class="card-body">
            <form action="@if($update==false){{ route('admin.usermanage.store') }} @elseif($update==true){{ route('admin.usermanage.update', $id) }} @endif" method="POST" enctype="multipart/form-data">
                @csrf
                @if($update==true) 
                @method('PUT')
            @endif
                <div class="form-group">
                    <label for="full_name">{{ trans('global.user.fields.fname') }}*</label>
                    <input type="text" id="full_name" name="full_name" class="form-control {{ $errors->has('full_name') ? ' is-invalid' : '' }}" value="{{$fname}}">
                    @if($errors->has('full_name'))
                        <em class="invalid-feedback">
                            {{ $errors->first('full_name') }}
                        </em>
                    @endif
                   
                </div>




                <div class="form-group">
                    <label for="username">{{ trans('global.user.fields.name') }}*</label>
                    <input type="text" id="username" name="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"  value="{{$user_name}}">
                    @if($errors->has('username'))
                        <em class="invalid-feedback">
                            {{ $errors->first('username') }}
                        </em>
                    @endif
                    
                </div>

                <div class="form-group">
                    <label for="email">{{ trans('global.user.fields.email') }}*</label>
                    <input type="email" id="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{$email}}">
                    @if($errors->has('email'))
                        <em class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </em>
                    @endif
                   
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('global.user.fields.password') }}</label>
                    <input type="text" id="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" value="{{$password}}">
                    @if($errors->has('password'))
                        <em class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </em>
                    @endif

                    
                </div>
               
                <div class="form-group">
                    <label for="user_types" >{{ trans('global.user.fields.user_type') }}*  </label>
                    <select name="user_types" id="user_types"  class="form-control {{ $errors->has('user_types') ? 'is-invalid' : '' }}" >
                            <option> ---Select One----</option>
                        @foreach($user_types as $u_id => $user_type)
                            <option value="{{ $u_id }}" @if($update==true) {@if($user_ty==$u_id) selected @endif } @endif>
                                {{ $user_type }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('user_types'))
                        <em class="invalid-feedback">
                            {{ $errors->first('user_types') }}
                        </em>
                    @endif
                   
                </div>

                <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" id="designation" name="designation" class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" value="{{ $designation }}">
                @if($errors->has('designation'))
                        <em class="invalid-feedback">
                            {{ $errors->first('designation') }}
                        </em>
                    @endif
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile No</label>
                <input type="text" id="mobile" name="mobile" class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" autocomplete="off" value="{{ $mobile }}">
                    @if($errors->has('mobile'))
                        <em class="invalid-feedback">
                            {{ $errors->first('mobile') }}
                        </em>
                    @endif
                </div>
                <div class="from-group">
                    <input type="hidden" name="warehouse_id" value="51">
                </div>

                <div>
                    @if($update == true)
                   
                    <button class="btn btn-primary" id="insert"  type="submit" name="update">{{ trans('global.update') }} </button>


                    @elseif($update==false)
                        
                        <button class="btn btn-success" type="submit" name="save"  >{{ trans('global.save') }} </button>



                    @endif


                </div>
            </form>

        </div>

    </div>
</div>
@endsection

