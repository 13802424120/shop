@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改管理员</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            @if ($res->id != 1)
                <div class="form-group">
                    <div class="label">
                        <label>所属角色：</label>
                    </div>
                    <div class="field" style="padding-top:8px;">
                        @foreach ($role_data as $v)
                            {{ $v->role_name }} <input type="checkbox" name="role_id[]" value="{{ $v->id }}" @if (in_array($v->id, $admin_role_data)) checked="checked" @endif>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="form-group">
                <div class="label">
                    <label>用户名：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="username" value="{{ $res->username }}" data-validate="required:请输入用户名"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>密码：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="password"/>
                    <div class="tips"></div>
                    <div class="tipss">密码留空表示不修改</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection