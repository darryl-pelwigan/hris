
     <div class="container">

        <!-- <a href="enlistOld.php?studid=1403-1294" class="new-window-link" >test</a> -->

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 style="margin:0;padding:0;" class="text-success">Sign in</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="check_login">
                            <fieldset>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Username" type="text" name="username" value="<?php if(isset($_POST['username'])){ echo htmlentities($_POST['username']); }else{} ?>" autofocus autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <input required class="form-control" placeholder="Password" type="password" name="userpass" value="" autocomplete="off"/>
                                </div>
                                <!-- <div class="g-recaptcha" data-sitekey="6Lem2AwUAAAAAMGZWPpUAR2ljQNUZOlqOBw8YVVo"></div> -->
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>
                                <div class="pull-right">
                                <button type="submit" value="Login" name="login" class="btn btn-success" ><i class="fa fa-key fa-fw"></i> Login </button>&nbsp;
                                <button type="reset" class="btn btn-default" onClick='window.location="./";'><i class="fa fa-sign-out fa-fw"></i> Cancel </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <?php  $this->load->view('template/with_flash'); ?>
            </div>
        </div>
    </div>
   