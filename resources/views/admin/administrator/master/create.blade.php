<div class="card-header">
    {{ trans('global.create') }} {{ trans('global.user.title_singular') }}
</div>






<div class="card-body">
    <form action="{{ route('admin.usermanage.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group {{ $errors->has('fname') ? 'has-error' : '' }}">
            <label for="fname">{{ trans('global.user.fields.fname') }}*</label>
            <input type="text" id="fname" name="fname" class="form-control"
                    {{--value="{{ old('username', isset($user) ? $user->username : '') }}"--}}
            >
            @if($errors->has('fname'))
                <em class="invalid-feedback">
                    {{ $errors->first('fname') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('global.user.fields.name_helper') }}
            </p>
        </div>




        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="username">{{ trans('global.user.fields.name') }}*</label>
            <input type="text" id="username" name="username" class="form-control"
                    {{--value="{{ old('username', isset($user) ? $user->username : '') }}"--}}
            >
            @if($errors->has('username'))
                <em class="invalid-feedback">
                    {{ $errors->first('username') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('global.user.fields.name_helper') }}
            </p>
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email">{{ trans('global.user.fields.email') }}*</label>
            <input type="email" id="email" name="email" class="form-control"
                    {{--value="{{ old('email', isset($user) ? $user->email : '') }}"--}}
            >
            @if($errors->has('email'))
                <em class="invalid-feedback">
                    {{ $errors->first('email') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('global.user.fields.email_helper') }}
            </p>
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">{{ trans('global.user.fields.password') }}</label>
            <input type="password" id="password" name="password" class="form-control">
            @if($errors->has('password'))
                <em class="invalid-feedback">
                    {{ $errors->first('password') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('global.user.fields.password_helper') }}
            </p>
        </div>
        <div class="form-group {{ $errors->has('user_types') ? 'has-error' : '' }}">
            <label for="user_types">{{ trans('global.user.fields.user_type') }}*
                <span class="btn btn-info btn-xs select-all">Select all</span>
                <span class="btn btn-info btn-xs deselect-all">Deselect all</span></label>
            <select name="level" id="roles" class="form-control select2" multiple="multiple">
                @foreach($user_types as $id => $user_type)
                    <option value="{{ $id }}" {{ (in_array($id, old('user_type_name_show', [])) || isset($user) && $user->$user_type->contains($id)) ? 'selected' : '' }}>
                        {{ $user_type }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('user_types'))
                <em class="invalid-feedback">
                    {{ $errors->first('user_types') }}
                </em>
            @endif
            <p class="helper-block">
                {{ trans('global.user.fields.roles_helper') }}
            </p>
        </div>
        <div>
            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
        </div>
    </form>
</div>
