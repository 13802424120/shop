@extends('layouts.admin')
@section('content')
<div class="bg"></div>
<div class="container">
    <div class="line bouncein">
        <div class="xs6 xm4 xs3-move xm4-move">
            <div style="height:150px;"></div>
            <div class="media media-y margin-big-bottom">
            </div>
            <form action="" method="post">
            {{ csrf_field() }}
            <div class="panel loginbox">
                <div class="text-center margin-big padding-big-top"><h1>后台管理中心</h1></div>
                <div class="panel-body" style="padding:30px; padding-bottom:10px; padding-top:10px;">
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="text" class="input input-big" name="username" placeholder="登录账号" data-validate="required:请填写账号" />
                            <span class="icon icon-user margin-small"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field field-icon-right">
                            <input type="password" class="input input-big" name="password" placeholder="登录密码" data-validate="required:请填写密码" />
                            <span class="icon icon-key margin-small"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="field">
                            <input type="text" class="input input-big" name="code" placeholder="填写右侧的验证码" data-validate="required:请填写右侧的验证码" />
                            <img src="{{ $captcha }}" alt="" width="100" height="32" class="passcode" style="height:43px;cursor:pointer;" onclick="this.src = '{{ $captcha }}' + Math.random();">

                        </div>
                    </div>
                </div>
                <div style="padding:30px;"><input type="submit" onclick="return loginCheck();" class="button button-block bg-main text-big input-big" value="登录"></div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function loginCheck() {
        return false;
    }

    $("input[type=submit]").click(function () {
        var _token = $("input[name=_token]").val();
        var username = $("input[name=username]").val();
        var password = $("input[name=password]").val();
        var code = $("input[name=code]").val();
        $.ajax({
            type: "POST",
            url: "{{ url('login/checkLogin')}}",
            data: {_token: _token, username: username, password: password, code: code},
            dataType: "json",
            success: function (data) {
                alert(data.message);
                if (data.code == 1) {
                    self.location = "{{ url('/') }}";
                }
            }
        });
    });
</script>
@endsection