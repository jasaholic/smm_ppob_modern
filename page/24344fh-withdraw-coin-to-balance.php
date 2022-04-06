<?php
session_start();
require("../config.php");
require '../lib/session_user.php';

        if (isset($_POST['tarik'])) {
	        require '../lib/session_login.php';
	        $post_tipe = $conn->real_escape_string(filter($_POST['tipe']));
	        $post_metode = $conn->real_escape_string(filter($_POST['radio6']));
		    $post_jumlah = $conn->real_escape_string(filter($_POST['jumlah']));
		    $post_pin = $conn->real_escape_string(filter($_POST['pin']));

		    $cek_koin = $conn->query("SELECT * FROM setting_koin WHERE id = '$post_tipe'");
		    $data_koin = $cek_koin->fetch_assoc();
		    $cek_koin_rows = mysqli_num_rows($cek_koin);

            if ($post_metode == "saldo_sosmed"){
			    $post_metodee = "Saldo Sosial Media";
            } else if($post_metode == "saldo_top_up"){
			    $post_metodee = "Saldo Top Up";
            }

            $tipe_saldo = 'saldo_top_up';

            $error = array();
            if (empty($post_tipe)) {
		        $error ['tipe'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_metode)) {
		        $error ['radio6'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_jumlah)) {
		        $error ['jumlah'] = '*Tidak Boleh Kosong.';
            }
            if (empty($post_pin)) {
		        $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($post_pin <> $data_user['pin']) {
		        $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

            if ($data_user['koin'] < $post_jumlah ) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Koin Kamu Tidak Cukup Untuk Penarikan.<script>swal("Ups Gagal!", "Koin Kamu Tidak Cukup.", "error");</script>');
		    } else if ($post_jumlah < $data_koin['minimal']) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Minimal Penarikan Koin Adalah '.$data_koin['minimal'].'.<script>swal("Ups Gagal!", "Minimal Penarikan Koin Adalah '.$data_koin['minimal'].'.", "error");</script>');
	        } else {

	                    $get_saldo = $post_jumlah * $data_koin['rate'];
		                $update = $conn->query("UPDATE users set $tipe_saldo = $tipe_saldo + $get_saldo WHERE username = '$sess_username'");
		                $update = $conn->query("UPDATE users set koin = koin - $post_jumlah, pemakaian_saldo = pemakaian_saldo + $get_saldo  WHERE username = '$sess_username'");
		            if ($update == TRUE) {
                            $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Koin', 'Penambahan Saldo', '$get_saldo', 'Mendapatkan Saldo Melalui Penarikan Koin Ke $post_metodee', '$date', '$time')");
	                        $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Koin', 'Pengurangan Koin', '$post_jumlah', 'Mengurangi Koin Melalui Penarikan Koin Ke $post_metodee', '$date', '$time')");
	                    if ($insert == TRUE) {
   		                    $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Kamu Berhasil Tarik Koin Ke '.$post_metodee.'.<script>swal("Berhasil!", "Kamu Berhasil Melakukan Penarikan Koin.", "success");</script>');
		                } else {
			                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
	                    }
	                }
	            }
            }
        }

	    require("../lib/header.php");

?>

        <!-- Start Sub Header -->
        <div class="kt-subheader kt-grid__item" id="kt_subheader">
	        <div class="kt-container">
	            <div class="kt-subheader__main">
		            <h3 class="kt-subheader__title">Tarik Koin</h3>
	                <div class="kt-subheader__breadcrumbs">
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Halaman Utama</a>
	                	<span class="kt-subheader__breadcrumbs-separator"></span>
	                    <a href="<?php echo $config['web']['url'] ?>" class="kt-subheader__breadcrumbs-link">Tarik Koin</a>
	                </div>
	            </div>
	        </div>
        </div>
        <!-- End Sub Header -->

        <!-- Start Content -->
        <div class="kt-container kt-grid__item kt-grid__item--fluid">

        <!-- Start Page Withdraw Coin To Balance -->
        <div class="row">
	        <div class="offset-lg-2 col-lg-8">
		        <div class="kt-portlet">
			        <div class="kt-portlet__head">
				        <div class="kt-portlet__head-label">
					        <h3 class="kt-portlet__head-title">
					            <i class="flaticon-coins text-primary"></i>
					            Tarik Koin Ke Saldo
					        </h3>
				        </div>
			        </div>
			        <div class="kt-portlet__body">
						<?php
						if (isset($_SESSION['hasil'])) {
						?>
						<div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<?php echo $_SESSION['hasil']['pesan'] ?>
						</div>
						<?php
						unset($_SESSION['hasil']);
						}
						?>
						<form class="form-horizontal" role="form" method="POST">
						    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Tipe Penarikan</label>
								<div class="col-lg-9 col-xl-6">
									<select class="form-control" name="tipe" id="tipe">
										<option value="">Pilih Salah Satu...</option>
										<?php
										$cek_metod = $conn->query("SELECT * FROM setting_koin WHERE status = 'Aktif'");
										while ($data_metod = $cek_metod->fetch_assoc()) {
										?>
										<option value="<?php echo $data_metod['id']; ?>"><?php echo $data_metod['tipe']; ?></option>
										<?php } ?>
									</select>
									<span class="form-text text-muted"><?php echo ($error['tipe']) ? $error['tipe'] : '';?></span>
								</div>
							</div>
							<!--<div class="form-group row">
						        <label class="col-xl-3 col-lg-3 col-form-label">Tarik Koin Ke Saldo</label>
						        <div class="col-lg-9 col-xl-6">
							         <div class="kt-radio-list">
								        <!--<label class="kt-radio kt-radio--bold kt-radio--brand">
									        <input type="radio" name="radio6" value="saldo_sosmed">Sosial Media
									        <span></span>
								        </label>-->
								        <!--<label class="kt-radio kt-radio--bold kt-radio--brand">
									        <input type="radio" name="radio6" value="saldo_top_up">Top Up
									        <span></span>
								        </label>
								        <span class="form-text text-muted"><?php echo ($error['radio6']) ? $error['radio6'] : '';?></span>
							        </div>
						        </div>
							</div>-->
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Total Koin Kamu</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="flaticon-coins text-primary"></i></span></div>
                                        <input type="number" class="form-control" name="koin" placeholder="Koin Kamu" value="<?php echo number_format($data_user['koin'],0,',','.'); ?>" id="koin" readonly>
                                    </div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Jumlah Tarik minimal 50.000 koin</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                        <input type="number" class="form-control" name="jumlah" placeholder="Masukkan Jumlah Tarik Koin" id="jumlah" onkeyup="get_total(this.value).value;">
                                    </div>
									<span class="form-text text-muted"><?php echo ($error['jumlah']) ? $error['jumlah'] : '';?></span>
								</div>
							</div>
							<input type="hidden" id="rate">
							<div class="form-group row">
								<label class="col-xl-3 col-lg-3 col-form-label">Saldo Yang Didapatkan</label>
								<div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text text-primary">Rp</span></div>
                                        <input type="number" class="form-control" value="0" id="total" readonly>
                                    </div>
								</div>
							</div>
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg-3 col-form-label">PIN</label>
                                <div class="col-lg-9 col-xl-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="la la-lock text-primary"></i></span></div>
                                        <input type="password" name="pin" class="form-control" placeholder="Masukkan PIN Kamu">
                                    </div>
                                    <span class="form-text text-muted"><?php echo ($error['pin']) ? $error['pin'] : '';?></span>
                                </div>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-3 col-xl-3">
                                        </div>
                                        <div class="col-lg-9 col-xl-9">
                                            <button type="submit" name="tarik" class="btn btn-primary btn-elevate btn-pill btn-elevate-air">Submit</button>
                                            <button type="reset" class="btn btn-danger btn-elevate btn-pill btn-elevate-air">Ulangi</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Withdraw Coin To Balance -->

        </div>
        <!-- End Content -->

        <!-- Start Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
		    <i class="fa fa-arrow-up"></i>
		</div>
		<!-- End Scrolltop -->

        <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function() {
            $("#tipe").change(function(){
                var method = $("#tipe").val();
                $.ajax({
                    url : '<?php echo $config['web']['url']; ?>ajax/rate-coins.php',
                    type  : 'POST',
                    dataType: 'html',
                    data  : 'method='+method,
                    success : function(msg){
                        $("#rate").val(msg);
                    }
                });
            });
        });
        function get_total(jumlah) {
            var rate = $("#rate").val();
            var result = eval(jumlah) * rate;
            $('#total').val(result);
        }
		</script>

<?php
require '../lib/footer.php';
?>