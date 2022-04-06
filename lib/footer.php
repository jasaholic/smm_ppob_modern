 <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2021<a class="ms-25" href="<?php echo $config['web']['url'] ?>" target="_blank"><?php echo $data['short_title']; ?></a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i></span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
   
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?php echo $config['web']['url'] ?>app-assets/js/core/app-menu.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->
    <script src="<?php echo $config['web']['url'] ?>app-assets/js/scripts/pages/page-api-key.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/js/scripts/forms/form-wizard.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/js/scripts/pages/app-invoice.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- BEGIN: Page JS-->
    
    <!-- END: Page JS-->
    <!-- BEGIN: Vendor JS-->
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
    $("#tipe").change(function() {
        var tipe = $("#tipe").val();
        $.ajax({
            url: '<?php echo $config['web']['url']; ?>ajax/provider-top-up-balance.php',
            data: 'tipe=' + tipe,
            type: 'POST',
            dataType: 'html',
            success: function(msg) {
                $("#provider").html(msg);
            },error(e){
                console.log(e)
            }
        });
    });
    $("#provider").change(function() {
        var provider = $("#provider").val();
        console.log(provider)
        $.ajax({
            url: '<?php echo $config['web']['url']; ?>ajax/pembayaran-top-up-balance.php',
            data: 'provider=' + provider,
            type: 'POST',
            dataType: 'html',
            success: function(msg) {
                console.log(msg)
                $("#pembayaran").html(msg);
            },error(e){
                console.log(e)
            }
        });
    });
        $("#pembayaran").change(function(){
                var method = $("#pembayaran").val();
                $.ajax({
                        url : '<?php echo $config['web']['url']; ?>ajax/rate-top-up-balance.php',
                        type  : 'POST',
                        dataType: 'html',
                        data  : 'method='+method,
                        success : function(result){
                                 $("#rate").val(result);
                        }
                });
        });  
});
        document.getElementById("transfer_pulsa").style.display = "none";
        $("#tipe").change(function() {
        var selectedCountry = $("#tipe option:selected").text();
        if (selectedCountry.indexOf('Transfer Bank') !== -1) {
            document.getElementById("transfer_pulsa").style.display = "none";
           } else {
            document.getElementById("transfer_pulsa").style.display = "block";
           }
    });
        function get_total(jumlah) {
        var rate = $("#rate").val();
        var result = eval(jumlah) * rate;
        $('#total').val(result);
}
$(document).on('keyup', '#jumlah', function() {
    console.log("hei")
    var jumlah = $(this).val()
     var rate = $("#rate").val();
     if(rate == ''){
         rate = 1;
     }
        var result = eval(jumlah) * rate;
        $('#total').val(result);
})
    </script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="<?php echo $config['web']['url'] ?>app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    
    <!-- END: Theme JS-->
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>