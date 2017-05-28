@extends('layouts.admin')
@section('content')
    <div class="panel admin-panel">
        <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加商品</strong></div>
        <div class="border-bottom" id="tabbar-div" style="padding: 0;">
            <p class="search" style="padding-left:15px;margin-bottom: 0;">
                <span class="button border-main tab-front"
                      style="padding:5px 10px;color:#fff;border-color:#0ae;background-color:#0ae"> 通用信息</span>
                <span class="button border-main tab-back" style="padding:5px 10px;"> 商品描述</span>
                <span class="button border-main tab-back" style="padding:5px 10px;"> 商品属性</span>
                <span class="button border-main tab-back" style="padding:5px 10px;"> 商品图片</span>
            </p>
        </div>
        <div class="body-content">
            <form method="post" class="form-x" action="" enctype="multipart/form-data">
            {{ csrf_field() }}
            <!-- 通用信息 -->
                <tables class="tab_table">
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
                            <label>商品品牌：</label>
                        </div>
                        <div class="field">
                            <select name="brand_id" class="input w50" data-validate="required:请选择品牌">
                                <option value="">请选择品牌</option>
                                @foreach ($brand_data as $v)
                                    <option value="{{ $v->id }}">{{$v->brand_name }}</option>
                                @endforeach
                            </select>
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
                    <if condition="$iscid eq 1">
                        <div class="form-group">
                            <div class="label">
                                <label>商品分类：</label>
                            </div>
                            <div class="field">
                                <select name="sort_id" class="input w50" data-validate="required:请选择分类">
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
                </tables>
                <!-- 商品描述 -->
                <tables class="tab_table" style="display: none">
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
                </tables>
                <!-- 商品属性 -->
                <tables class="tab_table" style="display: none">
                    <div class="form-group">
                        <div class="label">
                            <label>商品类型：</label>
                        </div>
                        <div class="field">
                            <select name="type_id" class="input w50" data-validate="required:请选择商品类型">
                                <option value="">请选择类型</option>
                                @foreach ($type_data as $v)
                                    <option value="{{ $v->id }}">{{$v->type_name }}</option>
                                @endforeach
                            </select>
                            <div class="tips"></div>
                        </div>
                    </div>
                    <div id="attr_list"></div>
                </tables>
                <!-- 商品图片 -->
                <tables class="tab_table" style="display: none">
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
                        <div class="label">
                            <label></label>
                        </div>
                        <img src="" style="display:none;width: 100px;"/>
                    </div>
                </tables>
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
    <script>
        /******** 上传图片实时显示 *******/
        $("#image1").click(function () {
            $("#image2").click();
            $("#image2").change(function () {
                var cost = $("#image2").val();
                $("#url1").val(cost);
                //图片上传实时预览
                var fileObj = document.getElementById("image2");
                var src = window.URL.createObjectURL(fileObj.files[0]);
                $("img").show();
                $("img").attr('src', src);
            });
        });
        /******** 切换的代码 *******/
        $("#tabbar-div p span").click(function () {
            // 点击的第几个按钮
            var i = $(this).index();
            // 先隐藏所有的table
            $(".tab_table").hide();
            // 显示第i个table
            $(".tab_table").eq(i).show();
            // 先取消原按钮的选中状态
            $(".tab-front").removeClass("tab-front").addClass("tab-back");
            //清除选中样式
            $(".tab-back").css({
                "color": "",
                "border-color": "",
                "background-color": ""
            });
            // 设置当前按钮选中
            $(this).removeClass("tab-back").addClass("tab-front");
            //添加选中样式
            $(this).css({
                "color": "#fff",
                "border-color": "#0ae",
                "background-color": "#0ae"
            });
        });
        /******** 选择类型获取属性的AJAX *******/
        $("select[name=type_id]").change(function () {
            // 获取当前选中的类型的id
            var typeId = $(this).val();
            if (typeId > 0) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('attribute/get').'?type_id='}}" + typeId,
                    dataType: "json",
                    success: function (data) {
                        // 服务器返回的属性显示在页面中
                        var html = '';
                        // 循环每个属性
                        $(data).each(function (k, v) {
                            html += '<div class="form-group"><div class="label">';
                            // 如果这个属性类型是可选的就有一个+
                            if (v.attribute_type == 2) {
                                html += '<a onclick="addNewAttr(this);" href="#">[+] </a>';
                            }
                            // 属性名称
                            html += '<label>' + v.attribute_name + '：</label></div>';
                            // 如果属性有可选值就做下拉框，否则做文本框
                            if (v.option_values == "") {
                                html += '<div class="field"><input type="text" class="input w50" name="attribute_value['+v.id+'][]" data-validate="required:请选择品牌" /><div class="tips"></div></div></div>';
                            } else {
                                html += '<div class="field"><select name="attribute_value['+v.id+'][]" class="input w50" data-validate="required:请选择' + v.attribute_name + '"><option value="">请选择' + v.attribute_name + '</option>';
                                // 把可选值根据,转化成数组
                                var _attr = v.option_values.split(',');
                                // 循环每个值制作option
                                for (var i = 0; i < _attr.length; i++) {
                                    html += '<option value="' + _attr[i] + '">';
                                    html += _attr[i];
                                    html += '</option>';
                                }
                                html += '</select><div class="tips"></div></div></div>';
                            }
                        });
                        // 把拼好的LI放到 页面中
                        $("#attr_list").html(html);
                    }

                })
            } else {
                // 如果选的是请选择就直接清空
                $("#attr_list").html("");
            }
        })

        // 点击属性的+号
        function addNewAttr(a) {
            // 先获取所在的html
            var html = $(a).parent().parent();
            if ($(a).text() == '[+] ') {
                var newLi = html.clone();
                // +变-
                newLi.find("a").text('[-] ');
                // 新的放在后面
                html.after(newLi);
            }
            else {
                html.remove();
            }
        }
    </script>
@endsection