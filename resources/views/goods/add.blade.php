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
<div class="panel admin-panel">
    <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加商品</strong></div>
    <div class="body-content">
        <form method="post" class="form-x" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <div class="label">
                    <label>商品名称：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="name" data-validate="required:请输入商品名称"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>价格：</label>
                </div>
                <div class="field">
                    <input type="text" class="input w50" name="price" data-validate="required:请输入价格"/>
                    <div class="tips"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="label">
                    <label>图片：</label>
                </div>
                <div class="field">
                    <input type="text" id="url1" class="input tips" style="width:25%; float:left;" value=""
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
            <if condition="$iscid eq 1">
                <div class="form-group">
                    <div class="label">
                        <label>商品分类：</label>
                    </div>
                    <div class="field">
                        <select name="sort" class="input w50"  data-validate="required:请选择分类">
                            <option value="">请选择分类</option>
                            @foreach ($sort_data as $v)
                                <option value="{{ $v['id'] }}">{{ str_repeat('-', 8*$v['level']) . $v['sort_name'] }}</option>
                            @endforeach
                        </select>
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>是否上架：</label>
                    </div>
                    <div class="field" style="padding-top:8px;">
                        上架 <input id="ishome" type="radio" name="is_putaway" value="1" checked="checked"/>
                        下架 <input id="isvouch" type="radio" name="is_putaway" value="0"/>
                    </div>
                </div>
            </if>
            <div class="form-group">
                <div class="label">
                    <label>商品描述：</label>
                </div>
                <div class="field">
                    <textarea name="describe" class="input"
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

</body>
</html>