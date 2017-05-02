<!-- login and register -->
<div class="modal fade modal-login" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="login-dialog">
                <div class="modal-header">
                    <span>用户登录</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body clearfix">
                    <form action="" class="js-form-login">
                        <div class="form-group user-account">
                            <input type="text" class="form-control js-login-username" name="username" data-show="用户名" placeholder="用户名">
                            <span class="error-tips sp_username"></span>
                        </div>
                        <div class="form-group user-password">
                            <input type="password" class="form-control js-login-password" name="password" data-show="密码" placeholder="密码">
                            <span class="error-tips sp_password"></span>
                        </div>
                        <div class="form-group user-captcha">
                            <input type="text" class="form-control js-login-key" name="key" data-show="验证码" placeholder="验证码">
                            <a href="javascript:;"><img src="/e/ShowKey/?v=login" alt="" name="loginKeyImg" id="loginKeyImg" onclick="loginKeyImg.src='/e/ShowKey/?v=login&t='+Math.random()" title="看不清楚,点击刷新" ></a>
                            <span class="error-tips sp_key"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control js-login-btn" value="登录">
                            <span class="error-tips sp_login"></span>
                        </div>
                        <div class="clearfix">
                            <label class="checkbox-inline auto-login pull-left">
                                <input type="checkbox">自动登录
                            </label>
                            <div class="pull-right">
                                <a href="" class="btn-to-forget" >忘记密码？</a >
                                <a href="" class="btn-to-register" >/去注册</a >
                            </div>
                        </div>
                    </form >
                    <div class="third-login">
                        <ul class="title clearfix">
                            <li class="line"></li>
                            <li class="text">其它账户登录</li>
                            <li class="line"></li>
                        </ul>
                        <div class="link">
                            <a href="{{$siteUrl}}/e/memberconnect/index.php?apptype=qq" class="qq" ><i class="icon-sprites"></i></a >
                            <a href="{{$siteUrl}}/e/memberconnect/index.php?apptype=sina" class="weibo" ><i class="icon-sprites"></i></a >
                            <a href="{{$siteUrl}}/e/memberconnect/index.php?apptype=wxpclogin" class="weixin" ><i class="icon-sprites"></i></a >
                        </div>
                    </div>
                </div>
            </div>
            <div class="register-dialog hide">
                <div class="modal-header">
                    <span>用户注册</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body clearfix">
                    <form action="" class="js-form-register">
                        <div class="form-group user-account">
                            <input type="text" class="form-control js-register-username" name="register_username" data-show="用户名" placeholder="用户名">
                            <span class="error-tips sp_register_username"></span>
                        </div>
                        <div class="form-group user-email">
                            <input type="text" class="form-control js-register-email" name="register_email" data-show="邮箱"  placeholder="邮箱">
                            <span class="error-tips sp_register_email"></span>
                        </div>
                        <div class="form-group user-password">
                            <input type="password" class="form-control js-register-password" name="register_password" data-show="密码" placeholder="密码">
                            <span class="error-tips sp_register_password"></span>
                        </div>
                        <div class="form-group user-confirm-pw">
                            <input type="password" class="form-control js-register-repassword" name="register_repassword" data-show="确认密码" placeholder="确认密码">
                            <span class="error-tips sp_register_repassword"></span>
                        </div>
                        <div class="form-group user-captcha">
                            <input type="text" class="form-control js-register-key" name="register_key" data-show="验证码" placeholder="验证码">
                            <a href="javascript:;"><img src="/e/ShowKey/?v=reg" alt="" name="regKeyImg" id="regKeyImg" onclick="regKeyImg.src='/e/ShowKey/?v=reg&t='+Math.random()" title="看不清楚,点击刷新"></a>
                            <span class="error-tips sp_register_key"></span>
                        </div>
                        <div class="form-group btn-register">
                            <input type="submit" class="form-control js-register-btn" value="注册">
                            <span class="error-tips sp_register"></span>
                        </div>
                    </form >
                    <a href="" class="pull-right btn-to-login" >已有账户？立即登录</a >
                </div>
            </div>
            <div class="forget-dialog hide">
                <div class="modal-header">
                    <span>忘记密码</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body clearfix">
                    <form action="" class="js-form-getpwd">
                        <div class="form-group user-account">
                            <input type="text" class="form-control js-getpwd-username" name="getpwd_username" data-show="用户名" placeholder="用户名">
                            <span class="error-tips sp_getpwd_username"></span>
                        </div>
                        <div class="form-group user-email">
                            <input type="text" class="form-control js-getpwd-email" name="getpwd_email" data-show="邮箱" placeholder="邮箱">
                            <span class="error-tips sp_getpwd_email"></span>
                        </div>
                        <div class="form-group user-captcha">
                            <input type="text" class="form-control js-getpwd-key" name="getpwd_key" data-show="验证码" placeholder="验证码">
                            <a href="javascript:;"><img src="/e/ShowKey/?v=getpassword" name="getpasswordKeyImg" id="getpasswordKeyImg" onclick="getpasswordKeyImg.src='/e/ShowKey/?v=getpassword&t='+Math.random()" title="看不清楚,点击刷新"></a>
                            <span class="error-tips sp_getpwd_key"></span>
                        </div>
                        <div class="form-group btn-forget">
                            <input type="submit" class="form-control" value="取回密码">
                            <span class="error-tips sp_getpwd"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->