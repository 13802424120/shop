@extends('layouts.admin')
@section('content')
    <form method="post" action="">
        {{ csrf_field() }}
        <div class="panel admin-panel">
            <div class="panel-head"><strong class="icon-reorder"> 库存量列表</strong></div>
        </div>
        <table class="table table-hover text-center">
            <tr>
                {{--循环输出属性--}}
                @foreach ($goods_attr_data as $k => $v)
                    <th>{{ $k }}</th>
                @endforeach
                <th width="10%">库存量</th>
                <th>操作</th>
            </tr>
            <tr>
                <?php $attr_count = count($goods_attr_data); ?>
                @foreach ($goods_attr_data as $key => $val)
                    <td>
                        <select name="goods_attribute_id[]" class="input w50" style="width: 100%;" data-validate="required:请选择{{$key}}">
                            <option value="">请选择{{$key}}</option>
                            @foreach ($val as $v)
                                <option value="{{$v->id}}">{{ $v->attribute_value }}</option>
                            @endforeach
                        </select>
                    </td>
                @endforeach
                <td><input type="text" class="input w50" name="stock[]" style="width: 100%;text-align: center;" data-validate="required:请输入库存量">
                </td>
                <td><input onclick="addNewTr(this);" type="button" value="+"/></td>
            </tr>
            <tr id="submit">
                <td colspan="{{$attr_count+2}}">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </td>
            </tr>
        </table>
        </div>
    </form>
    <script type="text/javascript">
        function addNewTr(bth) {
            var tr = $(bth).parent().parent();
            if ($(bth).val() == "+") {
                var newTr = tr.clone();
                newTr.find(":button").val('-');
                newTr.find("input[name='stock[]']").val("");
                $("#submit").before(newTr);
            } else {
                tr.remove();
            }
        }
    </script>
@endsection