@extends('layouts.admin')
@section('content')
<form method="post" action="{{ url('goods/delete') }}">
    {{ csrf_field() }}
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 商品列表</strong></div>
    </div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='goods/add'"><span
                            class="icon-plus-square-o"></span> 添加商品
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
            <th>商品名称</th>
            <th>商品品牌</th>
            <th>主分类</th>
            <th>扩展分类</th>
            <th>价格</th>
            <th>是否上架</th>
            <th width="150">添加时间</th>
            <th>操作</th>
        </tr>
        @foreach ($goods_data as $v)
            <tr>
                <td><input type="checkbox" name="id[]" value="{{ $v->id }}"/>
                    {{ $v->id }}
                </td>
                <td>{{ $v->name }}</td>
                <td>{{ $v->brand_name }}</td>
                <td>{{ $v->sort_name }}</td>
                <td></td>
                <td>{{ $v->price}}</td>
                <td>@if ($v->is_putaway == 0) 否 @else 是 @endif</td>
                <td>{{ $v->created_at }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main"
                           href="{{ url('goods/stock') . '?id=' . $v->id}}"><span
                                    class="icon-edit"></span>库存量</a>
                        <a type="button" class="button border-main"
                           href="{{ url('goods/edit') . '?id=' . $v->id}}"><span
                                    class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del({{ $v->id }})"><span
                                    class="icon-trash-o"></span> 删除</a>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8">
                {{ $goods_data->links() }}
            </td>
        </tr>
    </table>
    </div>
</form>
<script type="text/javascript">

    function del(id) {
        if (confirm("您确定要删除吗?")) {
            self.location = '/goods/delete?id='+id;
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