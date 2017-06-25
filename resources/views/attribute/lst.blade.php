@extends('layouts.admin')
@section('content')
    <form method="post" action="{{ url('attribute/del') . '?code=' . $type_data->id }}">
        {{ csrf_field() }}
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 属性列表</strong></div>
        </div>
        <div class="padding border-bottom">
            <ul class="search">
                <li>
                    <button type="button" class="button border-yellow"
                            onclick="window.location.href='add?code={{$type_data->id}}'"><span
                                class="icon-plus-square-o"></span> 添加属性
                    </button>
                    <button type="button" class="button border-green" id="checkall"><span class="icon-check"></span> 全选
                    </button>
                    <button type="submit" class="button border-red" onclick="return DelSelect()"><span
                                class="icon-trash-o"></span> 批量删除
                    </button>
                </li>
            </ul>
        </div>
        <table class="table table-hover text-center">
            <tr>
                <th width="120">ID</th>
                <th>属性名称</th>
                <th>属性类型</th>
                <th>属性可选值</th>
                <th>所属类型</th>
                <th>操作</th>
            </tr>
            @foreach ($attr_data as $v)
                <tr>
                    <td><input type="checkbox" name="id[]" value="{{ $v->id }}"/>
                        {{ $v->id }}
                    </td>
                    <td>{{ $v->attr_name }}</td>
                    <td>@if ($v->attr_type == 1) 唯一 @else 可选 @endif</td>
                    <td>{{ $v->option_values }}</td>
                    <td>{{ $type_data->type_name }}</td>
                    <td>
                        <div class="button-group">
                            <a type="button" class="button border-main"
                               href="{{ url('attribute/edit') . '?id=' . $v->id.'&code='.$type_data->id}}"><span
                                        class="icon-edit"></span>修改</a>
                            <a class="button border-red" href="javascript:void(0)"
                               onclick="return del({{ $v->id}}, {{$type_data->id }})"><span
                                        class="icon-trash-o"></span> 删除</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="8">
                </td>
            </tr>
        </table>
        </div>
    </form>
    <script type="text/javascript">
        function del(id, code) {
            if (confirm("您确定要删除吗?")) {
                self.location = 'del?id=' + id + '&code=' + code;
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