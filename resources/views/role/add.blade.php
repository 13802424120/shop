@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加角色</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>角色名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="role_name" data-validate="required:请输入角色名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>分配权限：</label>
                </div>
                <div class="field" style="padding-top:8px;">
                @foreach ($data as $v)
                    {{ str_repeat('-', 8 * $v['level']) }} <input type="checkbox" name="permission_id[]" level_id="{{ $v['level'] }}" value="{{ $v['id'] }}"> {{ $v['permission_name'] }}
                    <br/>
                @endforeach
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
<script type="text/javascript">
    $(":checkbox").click(function () {
        // 先获取点击的这个level_id
        var tmp_level_id = level_id = $(this).attr("level_id");
        // 判断是选中还是取消
        if ($(this).prop("checked")) {
            // 所有的子权限也选中
            $(this).nextAll(":checkbox").each(function (k, v) {
                if ($(v).attr("level_id") > level_id) {
                    $(v).prop("checked", "checked");
                } else {
                    return false;
                }
            });
            // 所有上级权限也选中
            $(this).prevAll(":checkbox").each(function (k, v) {
                if ($(v).attr("level_id") < tmp_level_id) {
                    $(v).prop("checked", "checked");
                    // 再找更上一级的
                    tmp_level_id--;
                }
            });
        } else {
            //所有的子权限也取消
            $(this).nextAll(":checkbox").each(function (k, v) {
                if ($(v).attr("level_id") > level_id) {
                    $(v).removeAttr("checked");
                } else {
                    return false;
                }
            });
        }
    })
</script>
@endsection
