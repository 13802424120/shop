@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加属性</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>属性名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="attribute_name" data-validate="required:请输入商品名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>所属类型：</label>
                </div>
                <div class="field">
                    <select name="type_id" class="input w50"  data-validate="required:请选择所属类型">
                        <option value="{{ $type_data->id }}">{{$type_data->type_name }}</option>
                    </select>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>属性类型：</label>
                </div>
                <div class="field" style="padding-top:8px;">
                    唯一 <input id="ishome" type="radio" name="attribute_type" value="1" checked="checked"/>
                    可选 <input id="isvouch" type="radio" name="attribute_type" value="2"/>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>属性可选值：</label>
                </div>
                <div class="field">
                    <textarea name="option_values" class="input"
                              style="height:450px; border:1px solid #ddd;"></textarea>
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