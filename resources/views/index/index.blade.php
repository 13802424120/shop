<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>后台管理中心</title>  
    <link rel="stylesheet" href="{{ asset('css/pintuer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="{{ asset('js/jquery.js') }}"></script>
</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
    <h1><img src="{{ asset('images/y.jpg') }}" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><a class="button button-little bg-green" href="" target="_blank"><span class="icon-home"></span> 前台首页</a> &nbsp;&nbsp;<a href="##" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="{{ url('login/logout') }}"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
  <div class="leftnav-title"><strong><span class="icon-list"></span>菜单列表</strong></div>
  <h2><span class="icon-shopping-cart"></span>商品管理</h2>
  <ul style="display:block">
    <li><a href="{{ url('brand/lst') }}" target="right"><span class="icon-caret-right"></span>品牌列表</a></li>
    <li><a href="{{ url('sort/lst') }}" target="right"><span class="icon-caret-right"></span>分类列表</a></li>
    <li><a href="{{ url('goods/lst') }}" target="right"><span class="icon-caret-right"></span>商品列表</a></li>
    <li><a href="{{ url('type/lst') }}" target="right"><span class="icon-caret-right"></span>类型列表</a></li>
  </ul>
  <h2><span class="icon-user"></span>权限管理</h2>
  <ul style="display:block">
    <li><a href="{{ url('permission/lst') }}" target="right"><span class="icon-caret-right"></span>权限列表</a></li>
    <li><a href="{{ url('role/lst') }}" target="right"><span class="icon-caret-right"></span>角色列表</a></li>
    <li><a href="{{ url('admin/lst') }}" target="right"><span class="icon-caret-right"></span>管理列表</a></li>
  </ul>  
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);	
	  $(this).toggleClass("on"); 
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
</script>
<ul class="bread">
  <li><a href="{{ url('/') }}" class="icon-home"> 首页</a></li>
  <li><a href="##" id="a_leader_txt">网站信息</a></li>
  <li><b>当前语言：</b><span style="color:red;">中文</span>
</ul>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="{{ url('brand/lst') }}" name="right" width="100%" height="100%"></iframe>
</div>
</body>
</html>