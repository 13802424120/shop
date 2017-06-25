@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改权限</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>上级权限：</label>
                </div>
                <div class="field">
                    <select name="parent_id" class="input w50">
                        <option value="0">请选择上级权限</option>
                        @foreach ($data as $v)
                            <option value="{{ $v['id'] }}" @if ($res->parent_id == $v['id']) selected="selected" @endif>{{ str_repeat('-', 8*$v['level']) . $v['permission_name'] }}</option>
                        @endforeach
                    </select>
                    <div class="tipss">不选择上级权限默认为顶级权限</div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>权限名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="permission_name" value="{{ $res->permission_name }}" data-validate="required:请输入权限名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>模块名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="module_name" value="{{ $res->module_name }}"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>控制器名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="controller_name" value="{{ $res->controller_name }}"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>方法名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="method_name" value="{{ $res->method_name }}"/>
                    <div class="tips"></div>
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