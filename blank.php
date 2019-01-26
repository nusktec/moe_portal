<?php require('lib/config.php');
page_identity(1, "Manage Students");

//import modules
include 'modules.php';
?>
    <!DOCTYPE html>
    <html lang="en">

    <!--Import your head here-->
<?php require('dash.header.js.php'); ?>

<body class="">
    <!--Menus here-->
<?php require('dash.menus.php'); ?>

<div class="main-panel">
    <!-- Navbar -->
    <?php require('dash.nav.php') ?>


    <!-- Main content here -->
    <div class="content" id="app">

    </div>

<?php require('dash.footer.php') ?>
    <script>
        var msg = {rma: 'No Action'};
        //instantiate vue.js
        var app = new Vue({
            el: '#app',
            data: {resp: msg}
        })
        //page loading
        NProgress.start();


        //remove admin's
        function removeAdmin(phone) {
            var conf = confirm("Are you sure to remove the selected admin ?");
            if(!conf){
                return;
            }
            NProgress.start();
            msg.rma = "<i class='fa fa-refresh druplay_rotate' ></i> Please wait !";
            $.ajax({
                type: "POST",
                url: "xapi",
                data: {cmd: 'remove-admin',ph: phone},
                success: function (data) {
                    alert(data);
                    var obj = JSON.parse(data);
                    if (obj.status) {
                        msg.rma = obj.message;
                        window.location.href = 'dashboard';
                        NProgress.done();
                        return;
                    }
                    msg.rma = obj.message;
                    NProgress.done();
                }
            });
            return false;
        }





        //stop evry when page finishes loading
        $(document).ready(function(){
            NProgress.done();
            new TableSearch('searchany', 'mytable', { noResultsText: 'Nothing found !' }).init();
        });
    </script>
