<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->

<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="assets/plugins/moment/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/datepicker/dist/js/datepicker.min.js"></script>
<script src="assets/datepicker/dist/js/i18n/datepicker.en.js"></script>
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script src="assets/dist/js/jquery.validate.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>

<script src="assets/plugins/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>

<!-- OPTIONAL SCRIPTS -->
<?php if ($page == "information") { ?>
    <script src="assets/plugins/chart.js/Chart.min.js"></script>
<?php } ?>

<script>
    $("#btnLogout").click(function() {
        showDialogConfirmToLogout();
    })

    function logout() {
        $.ajax({
            url: "process/authen.php",
            type: 'POST',
            data: {
                'FUNC_NAME': 'logout'
            },
            success: function(result) {
                location.href = "login.php";
            }
        });
    }

    function showDialogConfirmToLogout() {
        $.confirm({
            title: 'Are sure!',
            content: 'Do you want to logout?',
            type: 'red',
            autoClose: 'cancel|8000',
            buttons: {
                cancel: {
                    btnClass: 'text-secondary',
                    function() {}
                },
                confirm: {
                    btnClass: 'btn-red',
                    action: function() {
                        logout();
                    }
                }
            }
        });
    }
</script>