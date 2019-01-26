<footer class="footer">
    <div class="container-fluid">
        <nav class="float-left">
            <ul>
                <li>
                    <a href="http://education.gov.ng" target="_blank">&copy; <?php echo date('Y'); ?> Federal Ministry Of Eduction</a>
                </li>
                <li>
                    <a href="http://druplay.com" target="_blank"> Druplay Technology</a>
                </li>
            </ul>
        </nav>
        <div class="copyright float-right">

        </div>
    </div>
</footer>
</div>
</div>
<!--   Core JS Files   -->
<script src="assets/js/core/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
<script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!-- Chartist JS -->
<!--<script src="assets/js/plugins/chartist.min.js"></script>-->
<!--  Notifications Plugin    -->
<script src="assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="assets/js/material-dashboard.min.js" type="text/javascript"></script>
<!--druplay library-->
<script src="assets/js/druplay.lib.js" type="text/javascript"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<!--<script src="assets/demo/demo.js"></script>-->
<!--Vue Js-->
<script src="js/lib/vue.js"></script>
<script src="js/lib/topBar.js"></script>
<script src="js/lib/file.uploader.js"></script>
<script src="js/lib/js-search.js" type="text/javascript"></script>

<!-- jQuery Modal -->
<script src="js/jquery.modal.min.js"></script>
<!--flora js-->
<script src="js/lib/flora.lib.js"></script>

<script>
    NProgress.start();
    $(document).ready(function () {
        // Javascript method's body can be found in assets/js/demos.js
        md.initDashboardPageCharts();
        NProgress.done();
    });
</script>
</body>

</html>