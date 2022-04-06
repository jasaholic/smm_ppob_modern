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
                                                    <label class="form-label" for="first-name-column">Layanan</label>
                                                    <select class="form-control" id="kategori" name="kategori">
														<option value="0">Pilih Salah Satu</option>
														<?php
														$cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media' ORDER BY nama ASC");
														while ($data_kategori = mysqli_fetch_assoc($cek_kategori)) {
														?>
														<option value="<?php echo $data_kategori['kode']; ?>"><?php echo $data_kategori['nama']; ?></option>
														<?php
														}
														?>
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
			$("#kategori").change(function() {
			    var kategori = $("#kategori").val();
			    $.ajax({
			        url: '<?php echo $config['web']['url']; ?>ajax/service-list-sosmed.php',
			        data: 'kategori=' + kategori,
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