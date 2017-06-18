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
                <th width="10%">价格</th>
                <th>操作</th>
            </tr>
            @php $attr_count = count($goods_attr_data); @endphp
            @if ($goods_stock)
                @foreach ($goods_stock as $k => $cost)
                <tr>
                    @foreach ($goods_attr_data as $key => $val)
                        <td>
                            <select name="goods_attribute_id[]" class="input w50" style="width: 100%;" data-validate="required:请选择{{$key}}">
                                <option value="">请选择{{$key}}</option>
                                @foreach ($val as $v)
                                    <option value="{{$v->id}}"
                                    @php $attr = explode(',', $cost['goods_attribute_id']) @endphp
                                        @if (in_array($v->id, $attr))
                                            selected="selected"
                                        @endif
                                    >{{ $v->attribute_value }}</option>
                                @endforeach
                            </select>
                        </td>
                    @endforeach
                    <td><input type="text" class="input w50" name="stock[]" value="{{ $cost['stock'] }}" style="width: 100%;text-align: center;" data-validate="required:请输入库存量"></td>
                    <td><input type="text" class="input w50" name="price[]" value="{{ $cost['price'] }}" style="width: 100%;text-align: center;" data-validate="required:请输入价格"></td>
                    <td><input onclick="addNewTr(this);" type="button" value="@php echo $k == 0 ? '+':'-' @endphp"/></td>
                </tr>
                @endforeach
            @else
                <tr>
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
                    <td><input type="text" class="input w50" name="stock[]" style="width: 100%;text-align: center;" data-validate="required:请输入库存量"></td>
                    <td><input type="text" class="input w50" name="price[]" style="width: 100%;text-align: center;" data-validate="required:请输入价格"></td>
                    <td><input onclick="addNewTr(this);" type="button" value="+"/></td>
                </tr>
            @endif
            <tr id="submit">
                <td colspan="{{ $attr_count+3 }}">
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
                newTr.find("option[selected='selected']").removeAttr("selected");
                newTr.find("input[name='stock[]']").val("");
                newTr.find("input[name='price[]']").val("");
                $("#submit").before(newTr);
            } else {
                tr.remove();
            }
        }
    </script>
@endsection