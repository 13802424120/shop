@extends('layouts.admin')
@section('content')
<div class="panel admin-panel margin-top">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>修改分类</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>上级分类：</label>
                </div>
                <div class="field">
                    <select name="parent_id" class="input w50">
                        <option value="0">顶级分类</option>
                        @foreach ($sort_data as $v)
                            @if ($v['id'] == $res->id || in_array($v['id'], $child_data)) @continue @endif
                            @if ($v['id'] == $res->parent_id)
                                @php $select = 'selected = "selected"' @endphp
                            @else
                                @php $select = '' @endphp
                            @endif
                            <option value="{{ $v['id'] }}" {{ $select }}>{{ str_repeat('-', 8*$v['level']) . $v['sort_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>分类名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="sort_name" value="{{ $res->sort_name }}"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label></label>
                </div>
                <div class="field">
                    <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection