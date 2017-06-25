@extends('layouts.admin')
@section('content')
<form method="post" action="{{ url('type/del') }}">
    {{ csrf_field() }}
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 类型列表</strong></div>
    </div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='add'"><span
                            class="icon-plus-square-o"></span> 添加类型
                </button>
                <button type="button" class="button border-green" id="checkall"><span class="icon-check"></span> 全选
                </button>
                <button type="submit" class="button border-red" onclick="return DelSelect()"><span class="icon-trash-o"></span> 批量删除</button>
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
                <td><input type="checkbox" name="id[]" value="{{ $v->id }}"/>
                    {{ $v->id }}
                </td>
                <td>{{ $v->type_name }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main"
                           href="{{ url('attribute/lst') . '?code=' . $v->id}}"><span
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
            <td colspan="3">
                {{ $type_data->links() }}
            </td>
        </tr>
    </table>
</form>
<script type="text/javascript">

    function del(id) {
        if (confirm("您确定要删除吗?")) {
            self.location = 'del?id='+id;
        }
    }

    $("#checkall").click(function () {
        $("input[name='id[]']").each(function () {
            if (this.checked) {
                this.checked = false;
            }
            else {
                this.checked = true;
            }
        });
    })

    function DelSelect() {
        var Checkbox = false;
        $("input[name='id[]']").each(function () {
            if (this.checked == true) {
                Checkbox = true;
            }
        });
        if (Checkbox) {
            var t = confirm("您确认要删除选中的内容吗？");
            if (t == false) return false;
        }
        else {
            alert("请选择您要删除的内容!");
            return false;
        }
    }
</script>
@endsection