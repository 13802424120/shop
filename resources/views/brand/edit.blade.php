@extends('layouts.admin')
@section('content')
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加品牌</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>品牌名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="brand_name" value="{{ $update->brand_name }}" data-validate="required:请输入商品名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>图片：</label>
                </div>
                <div class="field">
                    <input type="text" id="url1" class="input tips" value="{{ $update->logo }}" style="width:25%; float:left;"
                           data-toggle="hover" data-place="right" data-image=""/>
                    <input type="button" class="button bg-blue margin-left" id="image1" value="+ 点击上传"
                           style="float:left;">
                    <input type="file" name="photo" id="image2" style="display:none;">
                    <div class="tipss">图片尺寸：500*500</div>
                </div>
            </div>
            <img src=""/>
            <script>
                $("#image1").click(function () {
                    $("#image2").click();
                    $("#image2").change(function () {
                        var cost = $("#image2").val();
                        $("#url1").val(cost);
                        //图片上传实时预览
                        var fileObj = document.getElementById("image2");
                        var src = window.URL.createObjectURL(fileObj.files[0]);
                        $("img").attr('src',src);
                    });
                });

            </script>
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