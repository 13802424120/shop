@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 分类列表</strong></div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='add'"><span
                            class="icon-plus-square-o"></span> 添加分类
                </button>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="15%">分类名称</th>
            <th width="10%">操作</th>
        </tr>
        @foreach ($sort_data as $v)
            <tr>
                <td style="text-align:left;padding-left: 20px;">{{ str_repeat('-', 8*$v['level']) . $v['sort_name'] }}</td>
                <td>
                    <div class="button-group">
                        <a class="button border-main" href="{{ url('sort/edit') }}?id={{ $v['id'] }}">
                            <span class="icon-edit"></span> 修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $v['id'] }})">
                            <span class="icon-trash-o"></span> 删除</a></div>
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