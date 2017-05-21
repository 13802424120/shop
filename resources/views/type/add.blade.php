@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加类型</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>类型名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="type_name" data-validate="required:请输入类型名称"/>
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