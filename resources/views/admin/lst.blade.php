@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 管理员列表</strong></div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='add'"><span
                            class="icon-plus-square-o"></span> 添加管理员
                </button>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th>用户名</th>
            <th>所属角色</th>
            <th>操作</th>
        </tr>
        @foreach ($data as $v)
            <tr>
                <td>{{ $v->username }}</td>
                <td>{{ $v->id == 1 ? '超级管理员' : $v->role_name }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main" href="{{ url('admin/edit') . '?id=' . $v->id }}">
                            <span class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $v->id }})">
                            <span class="icon-trash-o"></span>删除</a>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript">
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            if (id == 1) {
                alert('超级管理员不可删除！');
                return false;
            }
            self.location = 'del?id='+id;
        }
    }
</script>
@endsection