<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>
<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Layanan</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo $config['web']['url'] ?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Harga Layanan
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic Tables start -->
                <section id="multiple-column-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Harga Layanan</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form" method="POST">
                                        <div class="row">
                                            <div class=" col-12">
                                                <div class="mb-1">
                                                    <label >Kateogri</label>
                                                    <select class="form-control" id="tipe" name="tipe">
														<option value="">Pilih Salah Satu</option>
														<option value="Pulsa">Pulsa</option>
														<option value="E-Money">E-Money</option>
														<option value="Data">Data</option>
														<option value="Paket SMS Telpon">Paket SMS Telpon</option>
														<option value="Games">Games</option>
														<option value="Voucher">Voucher</option>
														<option value="WIFI ID">WIFI ID</option>
													</select>
                                                </div>
                                            </div>
                                            <div class=" col-12">
                                                <div class="mb-1">
                                                    <label >Layanan</label>
                                                    <select class="form-control" id="operator" name="operator">
														<option value="0">Pilih Tipe Dahulu</option>
													</select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div id="layanan"></div>
                                </div>
                               </div>
                           </div>
                       </div>
                   </section>

            </div>
        </div>
    </div>


<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
		    $("#tipe").change(function() {
			    var tipe = $("#tipe").val();
		        $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/type-top-up.php',
			        data: 'tipe=' + tipe,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#operator").html(msg);
			        }
		        });
	        });
			$("#operator").change(function() {
			    var tipe = $("#tipe").val();
			    var operator = $("#operator").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-top-up.php',
			        data  : 'tipe=' +tipe + '&operator=' + operator,
			        type: 'POST',
			        dataType: 'html',
			        success: function(msg) {
				        $("#layanan").html(msg);
			        }
		        });
	        });
		});
		</script>

<?php
include("../lib/footer.php");
?>