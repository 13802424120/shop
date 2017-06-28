@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 角色列表</strong></div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='add'"><span
                            class="icon-plus-square-o"></span> 添加角色
                </button>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>角色名称</th>
            <th>权限名称</th>
            <th>操作</th>
        </tr>
        @foreach ($data as $v)
            <tr>
                <td>{{ $v->role_name }}</td>
                <td>{{ $v->permission_name }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main" href="{{ url('role/edit') }}?id={{ $v->id }}"><span
                                    class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $v->id }})"><span
                                    class="icon-trash-o"></span>删除</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            self.location = 'del?id='+id;
        }
    }
</script>
@endsection