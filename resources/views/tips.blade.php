<!DOCTYPE html>
<html lang="zh-CN">
<head>
<title>系统信息</title>
<link rel="stylesheet" href="css/pintuer.css">
<style type="text/css">
*{ margin:0; padding:0;}
body {}
.error-container{ background:#fff; border:1px solid #0ae; text-align:center; width:450px; margin:0 auto; margin-top:100px; font-family:Microsoft Yahei; padding-bottom:30px; border-top-left-radius:5px; border-top-right-radius:5px;  }
.error-container h1{ font-size:16px; padding:12px 0; background:#0ae; color:#fff;} 
.errorcon{ padding:35px 0; text-align:center; color:#0ae; font-size:18px;}
.errorcon i{ display:block; margin:12px auto; font-size:30px; }
.errorcon span{color:red;}
h4{ font-size:14px; color:#666;}
a{color:#0ae;}
</style>
</head>
<body class="no-skin">
<div class="error-container">
    <h1> 后台管理系统-信息提示 </h1>   
    <div class="errorcon">     
        <span style="display:none;"><i class="icon-smile-o"></i>操作成功</span>
        <i class="icon-frown-o"></i>{{ session('status') }}
   </div>
    {{--<h4 class="smaller">页面自动 <a id="href" href="#">跳转</a> 等待时间： <b id="wait">3</b></h4>--}}
   
</div>

<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
