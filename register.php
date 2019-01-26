<?php include 'lib/config.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.js.php' ?>
</head>

<?php include 'home.nav.bar.php'; ?>

<style>
    .sel{
        font-family: 'Nunito', sans-serif;
        outline: 0;
        background: #fff;
        width: 100%;
        margin: 0 0 15px;
        padding: 15px 15px;
        box-sizing: border-box;
        font-size: 14px;
        border: 1px solid #dedef8;
        border-radius: 6px;
    }
</style>


<!--Login-->
<section id="app" class="row section-spacing bg-rose home-bg">
    <div class="container">
        <div class="sectionTitle p-bottom20">
            <h2>Register</h2>
        </div>
        <div class="row">
            <div class="col-sm-8 center-block register-form">
                <div class="form">
                    <form method="post" id="regForm" onsubmit="return submitData()"
                          class="login-form clearfix bg-gray border shadow radius">
                        <div class="col-sm-6">
                            <input name="sname" placeholder="School Name" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input name="sphone" placeholder="School Phone" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input name="semail" placeholder="School Email" type="email">
                        </div>
                        <div class="col-sm-6">
                            <input name="saddress" placeholder="School Address" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input name="aname" placeholder="Admin name (Pricipal, Secretary, ICT Head)" type="text">
                            <input name="aphone" placeholder="Admin Phone No." type="text">
                        </div>
                        <div class="col-sm-6">
                            <select class="sel" name="sstate">
                                <option value="" selected="selected">- Select State -</option>
                                <option value="Abuja FCT">Abuja FCT</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa Ibom">Akwa Ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross River">Cross River</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwara">Kwara</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nassarawa">Nassarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                            </select>
                            <input name="sshort" placeholder="School Abbreviation" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input name="pass1" placeholder="Password" type="password">
                        </div>
                        <div class="col-sm-6">
                            <input name="pass2" placeholder="Conform Password" type="password">
                        </div>
                        <div class="col-sm-6">
                            <input name="ac" placeholder="Access Code" type="text">
                            <small class="small"><a style="color: green; text-decoration: none;" target="_blank" href="https://education.gov.ng/adons/acdp">Click
                                    here if you don't have access code</a></small>
                        </div>
                        <div class="col-sm-6">
                            <small v-html="message.msgdata"></small>
                        </div>
                        <div class="col-sm-12 text-center">
                            <button id="subbtn" type="submit" class="btn btn-success btn-xlg col-sm-8 col-xs-12 center-block m-top30">Register
                            </button>
                            <p class="message p-top30 margin-bottom0">Already registered ? <a href="login">Account
                                    Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include 'home.footer.php' ?>

<script>
    //instantiate vue js
    var msg = {msgdata: ''};
    var app = new Vue({
        el: '#app',
        data: {message: msg}
    });

    function submitData() {
        //disable register button
        $("#subbtn").attr("disabled", "disabled");
        $("#subbtn").html('Please wait...');

        NProgress.start();
//      var email,pass; email = $('#email'); pass = $('#password');
        msg.msgdata = "Please wait...";
        //start sending info
        $.ajax({
            type: "POST",
            url: "xapi",
            data: $('#regForm').serialize() + '&cmd=reg',
            success: function (data) {
                $("#subbtn").prop("disabled", false);
                $("#subbtn").html('Register');
                try {
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        $('#regForm').trigger("reset");
                        msg.msgdata = obj.message;
//                        window.location.href = "login";
                        NProgress.done();
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