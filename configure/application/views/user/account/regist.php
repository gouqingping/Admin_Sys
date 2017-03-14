<div class="container ">
    <div class="adm-signin">
        <ul role="tablist" class="nav nav-tabs nav-tabs-google">
            <li class="active input-font" role="presentation">
                <a data-toggle="tab" role="tab" aria-controls="profile">
                    后台管理
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <!-- 登陆-->
            <?php echo form_open('user/account/login'); ?>
                <label for="dinputEmail" class="sr-only">
                    Email address
                </label>
                <input id="email" name="email" value="<?php echo set_value('email');?>" type="email" placeholder="账号(邮箱)" class="form-control input-text" >
                <label for="dinputPassword" class="sr-only">
                    Password
                </label>
                <input id="password" name="password" type="password" placeholder="密码" class="form-control input-text">
                <?php echo isset($error)?$error:'';echo validation_errors();?>
                <button type="submit" class="btn btn-lg btn-primary btn-block">
                    登陆
                </button>
                <div class="clear">
                </div>
            </form>
        </div>
    </div>
</div>