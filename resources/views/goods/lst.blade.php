<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="renderer" content="webkit">
    <title></title>
    <link rel="stylesheet" href="{{ asset('css/pintuer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/pintuer.js') }}"></script>
</head>
<body>
<form method="post" action="">
    <div class="panel admin-panel">
        <div class="panel-head"><strong class="icon-reorder"> 商品列表</strong></div>
    </div>
    <div class="padding border-bottom">
        <ul class="search">
            <li>
                <button type="button" class="button border-yellow" onclick="window.location.href='./add'"><span
                            class="icon-plus-square-o"></span> 添加商品
                </button>
                <button type="button" class="button border-green" id="checkall"><span class="icon-check"></span> 全选
                </button>
                <button type="submit" class="button border-red"><span class="icon-trash-o"></span> 批量删除</button>
            </li>
        </ul>
    </div>
    <table class="table table-hover text-center">
        <tr>
            <th width="120">ID</th>
            <th>商品名称</th>
            <th>分类</th>
            <th>价格</th>
            <th>是否上架</th>
            <th width="25%">商品描述</th>
            <th width="150">添加时间</th>
            <th>操作</th>
        </tr>
        @foreach ($goods_data as $v)
            <tr>
                <td><input type="checkbox" name="id[]" value="1"/>
                    {{ $v->id }}
                </td>
                <td>{{ $v->goods_name }}</td>
                <td>{{ $v->sort_name }}</td>
                <td>{{ $v->goods_price}}</td>
                <td>@if ($v->is_putaway == 0) 下架 @else 上架 @endif</td>
                <td>{{ $v->goods_describe }}</td>
                <td>{{ $v->created_at }}</td>
                <td>
                    <div class="button-group">
                        <a type="button" class="button border-main" href="#"><span class="icon-edit"></span>修改</a>
                        <a class="button border-red" href="javascript:void(0)" onclick="return del(17)"><span class="icon-trash-o"></span> 删除</a>
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
</body>
</html>