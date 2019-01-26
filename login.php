<?php include 'lib/config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.js.php' ?>
</head>

<?php include 'home.nav.bar.php'; ?>

<!--Login-->
<section id="app" class="row section-spacing bg-pattern home-bg">
    <div class="container">
        <div class="text-center p-bottom20">
            <h2><small>Federal Ministry Of Education</small><br>Unity School Portal<br><small style="font-size: 15px;">Account Login</small></h2>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-5 col-xs-12 center-block">
                <div class="form bg-gray clearfix login-form border shadow radius">
                    <form id="loginForm" class="login-form clearfix" onsubmit=" return submitData();">
                        <div class="col-sm-12">
                            <input id="account" name="account" type="text" placeholder="Access code."/>
                        </div>

                        <div class="col-sm-12">
                            <input id="password" name="password" type="password" placeholder="Password"/>
                            <input id="token" name="token" type="text" placeholder="Token"/>
                            <div class="checkbox text-left">
                                <input type="checkbox" name="rem" id="rem">
                                <label for="rem">Remember Me</label>
                            </div>
                            <button id="logbtn" class="btn btn-success btn-xlg btn-block margin-bottom20">login</button>
                        </div>

                        <div class="col-sm-12" style="text-align: center; padding: 20px">
                            <small v-html="message.msgdata"></small>
                            <br/>
                            <small class="message p-top10 margin-bottom0">Not registered? <a
                                        data-turbolinks-action="replace" href="register">Create an
                                    account</a></small>
                            <br/>
                            <small class="message p-top30 margin-bottom0">
                                <a data-toggle="modal" data-target="#resetPass" href="#">Forgot password?</a>
                            </small>
                            <br/>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--password reset pane-->
    <div class="modal fade" id="resetPass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Password Request</h4>
                </div>
                <div class="modal-body">
                    <h4 class="m-bottom30" v-html="message.rmsg">Please enter your access code. or phone no.</h4>
                    <form method="post" id="resetForm" class="login-form clearfix" onsubmit=" return resetPassword();">
                        <div class="col-sm-12">
                            <input id="data" name="data" type="text" placeholder="Account No. / Phone No."/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="$('#resetForm').submit();" type="button" class="btn btn-success">Send Request
                    </button>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Footer -->
<?php include 'home.footer.php' ?>

<script>
    var msg = {msgdata: '', rmsg: 'Provide a valid access code or Phone no.'};
    var app = new Vue({
        el: '#app',
        data: {message: msg}
    });

    function resetPassword() {
        msg.rmsg = "Please wait !";
        $.ajax({
            type: "POST",
            url: "form/send",
            data: $('#resetForm').serialize() + '&cmd=login',
            success: function (data) {
                try {
                    msg.rmsg = data;
                    NProgress.done();
                } catch (e) {
                    msg.rmsg = "Server error: try again";
                    NProgress.done();
                }
            }
        });
        return false;
    }

    function submitData() {
        //disable login button
        $("#logbtn").attr("disabled", "disabled");
        $("#logbtn").html('Please wait...');

        NProgress.start();
//      var email,pass; email = $('#email'); pass = $('#password');
        msg.msgdata = "Please wait...";
        //start sending info
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#loginForm').serialize() + '&cmd=login',
            success: function (data) {
                $("#logbtn").prop("disabled", false);
                $("#logbtn").html('Login');
                try {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        $('#loginForm').submit();
                        msg.msgdata = obj.message;
                        window.location.href = "dashboard";
                        return;
                    }
                    msg.msgdata = obj.message;
                    NProgress.done();
                } catch (e) {
                    msg.msgdata = "Server error: try again";
                    NProgress.done();
                }
            }
        });
        return false;
    }

    $(document).ready(function () {
        NProgress.done();
    });
</script>


</body>
</html>