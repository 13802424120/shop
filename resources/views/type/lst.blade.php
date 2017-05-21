@extends('layouts.admin')
@section('content')
<form method="post" action="{{ url('type/delete') }}">
    {{ csrf_field() }}
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 类型列表</strong></div>
    </div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='type/add'"><span
                            class="icon-plus-square-o"></span> 添加类型
                </button>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="120">ID</th>
            <th>类型名称</th>
            <th>操作</th>
        </tr>
        @foreach ($type_data as $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>{{ $v->type_name }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main"
                           href="{{ url('attribute') . '?code=' . $v->id}}"><span
                                    class="icon-edit"></span>属性列表</a>
                        <a type="button" class="button border-main"
                           href="{{ url('type/edit') . '?id=' . $v->id}}"><span
                                    class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $v->id }})"><span
                                    class="icon-trash-o"></span> 删除</a>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8">
                {{ $type_data->links() }}
            </td>
        </tr>
    </table>
    </div>
</form>
<script type="text/javascript">
    function del(id) {
        if (confirm("您确定要删除吗?")) {
            self.location = 'type/delete?id='+id;
        }
    }
</script>
@endsection