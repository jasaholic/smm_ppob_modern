<?php
session_start();
require '../config.php';
require '../lib/session_user.php';

        if (isset($_POST['pesan'])) {
		    require '../lib/session_login.php';
		    $post_kategori = $conn->real_escape_string(trim(filter($_POST['kategori'])));
		    $post_layanan = $conn->real_escape_string(trim(filter($_POST['layanan'])));
		    $post_target = $conn->real_escape_string(trim(filter($_POST['target'])));
		    $post_jumlah = $conn->real_escape_string(trim(filter($_POST['jumlah'])));
		    $post_pin = $conn->real_escape_string(trim(filter($_POST['pin'])));
		    $post_comments = $_POST['comments'];
		    $post_link = $conn->real_escape_string(trim(filter($_POST['cuslink'])));

		    $cek_rate = $conn->query("SELECT * FROM setting_rate WHERE tipe = 'Sosial Media'");
		    $data_rate = mysqli_fetch_assoc($cek_rate);

		    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$post_layanan' AND status = 'Aktif'");
		    $data_layanan = mysqli_fetch_assoc($cek_layanan);

	    	    $cek_pesanan = $conn->query("SELECT * FROM pembelian_sosmed WHERE target = '$post_target' AND status = 'Pending'");
		    $data_pesanan = mysqli_fetch_assoc($cek_pesanan);

	            $cek_rate_koin = $conn->query("SELECT * FROM setting_koin_didapat WHERE status = 'Aktif'");
		    $data_rate_koin = mysqli_fetch_assoc($cek_rate_koin);

		    $kategori = $data_layanan['kategori'];
		    $layanan = $data_layanan['layanan'];
		    $cek_harga = $data_layanan['harga'] / 1000;
		    $cek_profit = $data_rate['rate'] / 1000;
		    $hitung = count(explode(PHP_EOL, $post_comments));
	            $replace = str_replace("\r\n",'\r\n', $post_comments);
	            if (!empty($post_comments)) {
			    $post_jumlah = $hitung;
		    } else {
		    	    $post_jumlah = $post_jumlah;
		    }
		    if (!empty($post_comments)) {
		    	    $harga = $cek_harga*$hitung;
			    $profit = $cek_profit*$hitung;
		    } else {
			    $harga = $cek_harga*$post_jumlah;
			    $profit = $cek_profit*$post_jumlah;
		    }
		    $order_id = acak_nomor(3).acak_nomor(4);
		    $provider = $data_layanan['provider'];
		    $koin = $harga * $data_rate_koin['rate'];

		    $cek_provider = $conn->query("SELECT * FROM provider WHERE code = '$provider'");
		    $data_provider = mysqli_fetch_assoc($cek_provider);
		    
		    $url = $data_provider['link'];

            // Get Start Count
            if ($data_layanan['kategori'] == "Instagram Likes" AND "Instagram Likes Indonesia" AND "Instagram Likes [Targeted Negara]" AND "Instagram Likes/Followers Per Minute" AND "- PROMO -") {
                $start_count = likes_count($post_target);
            } else if ($data_layanan['kategori'] == "Instagram Followers [ No Refill ]" AND "Instagram Followers Indonesia" AND "Instagram Followers [Negara]" AND "Instagram Followers [guaranteed]" AND "- PROMO -") {
                $start_count = followers_count($post_target);
            } else if ($data_layanan['kategori'] == "Instagram Views" AND "- PROMO -") {
                $start_count = views_count($post_target);
            } else {
                $start_count = 0;
            }

            $error = array();
            if (empty($post_kategori)) {
    		    $error ['kategori'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_layanan)) {
    		    $error ['layanan'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_target)) {
    		    $error ['target'] = '*Tidak Boleh Kosong.';
            }
            if (empty($post_jumlah)) {
    		    $error ['jumlah'] = '*Tidak Boleh Kosong.';
            }
            if (empty($post_pin)) {
    		    $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($post_pin <> $data_user['pin']) {
    		    $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

    		if (mysqli_num_rows($cek_layanan) == 0) {
    			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Layanan Tidak Tersedia.<script>swal("Ups Gagal!", "Layanan Tidak Tersedia.", "error");</script>');

		    } else if (mysqli_num_rows($cek_provider) == 0) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Server Kami Sedang Maintance.<script>swal("Ups Gagal!", "Server Kami Sedang Maintance.", "error");</script>');

		    } else if ($post_jumlah < $data_layanan['min']) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Minimal Jumlah Pemesanan Adalah '.number_format($data_layanan['min'],0,',','.').'<script>swal("Yahh Gagal!", "Jumlah Minimal Pemesanan Adalah '.number_format($data_layanan['min'],0,',','.').'", "error");</script>');
			
		    } else if ($post_jumlah > $data_layanan['max']) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Maksimal Jumlah Pemesanan Adalah '.number_format($data_layanan['max'],0,',','.').'<script>swal("Yahh Gagal!", "Jumlah Maksimal Pemesanan Adalah '.number_format($data_layanan['max'],0,',','.').'", "error");</script>');
			
		    } else if ($data_user['saldo_top_up'] < $harga) {
			    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Yahh, Saldo Sosial Media Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.<script>swal("Yahh Gagal!", "Saldo Sosial Media Kamu Tidak Mencukupi Untuk Melakukan Pemesanan Ini.", "error");</script>');

		    } else if (mysqli_num_rows($cek_pesanan) == 1) {
		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Masih Terdapat Pesanan Dengan Tujuan Yang Sama & Berstatus Pending.<script>swal("Ups Gagal!", "Masih Terdapat Pesanan Dengan Tujuan Yang Sama & Berstatus Pending.", "error");</script>');

		    } else {

			if ($provider == "MANUAL") {
				$api_postdata = "";
			} else if ($provider == "IRVANKEDE") {
			    if ($post_comments == false) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&quantity=$post_jumlah";
			    } else if ($post_comments == true) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&custom_comments=$post_comments";
			    }
			    $url = "https://api.irvankede-smm.co.id/order";
			    
			} else if ($provider == "MEDANPEDIA") {
			    if ($post_link == true) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&quantity=$post_jumlah&custom_link=$post_link";
			    } else if ($post_comments == true) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&quantity=$post_jumlah&custom_comments=$post_comments";
			    } else {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&quantity=$post_jumlah";
			    }
			    $url = "https://api.medanpedia.co.id/order";
			    
			} else if($provider == "WSTORE") {
			    if ($post_comments == false) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&quantity=$post_jumlah";
			    } else if ($post_comments == true) {
			    $postdata = "api_id=".$data_provider['api_id']."&api_key=".$data_provider['api_key']."&service=".$data_layanan['provider_id']."&target=$post_target&custom_comments=$post_comments";
			    }
			    
			} else {
				die("System Error!");
			}
			    $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $chresult = curl_exec($ch);
                $json_result = json_decode($chresult, true);

			    if ($provider == "IRVANKEDE" AND $json_result['status'] == false) {
				    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, '.$json_result['data']);
			    } else if ($provider == "MEDANPEDIA" AND $json_result['status'] == false) {
			        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, '.$json_result['data']);
			    } else if ($provider == "WSTORE" AND $json_result['status'] == false) {
			        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, '.$json_result['data']);
			    } else {

                                    if ($provider == "IRVANKEDE") {
					    $provider_oid = $json_result['data']['id'];
				    } else if($provider == "MEDANPEDIA") {
				        $provider_oid = $json_result['data']['id'];
				    } else if($provider == "WSTORE") {
				        $provider_oid = $json_result['data']['id'];
				    }

			            $top_layanan = $conn->query("SELECT * FROM top_layanan WHERE layanan = '$layanan'");
			            $data_layanan = mysqli_fetch_assoc($top_layanan);
			            $check_top = $conn->query("SELECT * FROM top_users WHERE username = '$sess_username'");
			            $data_top = mysqli_fetch_assoc($check_top);
			            if ($conn->query("INSERT INTO pembelian_sosmed VALUES ('','$order_id', '$provider_oid', '$sess_username', '$layanan', '$post_target', '$post_jumlah', '$post_jumlah', '$start_count', '$harga', '$profit', '$koin', 'Pending', '$date', '$time', '$provider', 'Website', '0')") == true) {
			            	$conn->query("INSERT INTO semua_pembelian VALUES ('','WEB-$order_id', '$order_id', '$sess_username', '$kategori', '$layanan', '$harga', '$post_target', 'Pending', '$date', '$time', 'WEB', '0')");
				            $conn->query("UPDATE users SET saldo_top_up = saldo_top_up-$harga, pemakaian_saldo = pemakaian_saldo+$harga WHERE username = '$sess_username'");
				            $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '$harga', 'Mengurangi Saldo Sosial Media Melalui Pemesanan Sosial Media Dengan Kode Pesanan : WEB-$order_id', '$date', '$time')");
			                if (mysqli_num_rows($check_top) == 0) {
				                $insert_topup = $conn->query("INSERT INTO top_users VALUES ('', 'Order', '$sess_username', '$harga', '1')");
			                } else {
				                $insert_topup = $conn->query("UPDATE top_users SET jumlah = ".$data_top['jumlah']."+$harga, total = ".$data_top['total']."+1 WHERE username = '$sess_username' AND method = 'Order'");
			                }
			                if (mysqli_num_rows($top_layanan) == 0) {
				                $insert_topup = $conn->query("INSERT INTO top_layanan VALUES ('', 'Layanan', '$layanan', '$harga', '1')");
			                } else {
				                $insert_topup = $conn->query("UPDATE top_layanan SET jumlah = ".$data_top['jumlah']."+$harga, total = ".$data_top['total']."+1 WHERE layanan = '$layanan' AND method = 'Layanan'");
			                }
    			            $jumlah = number_format($post_jumlah,0,',','.');
    			            $harga2 = number_format($harga,0,',','.');
    			            $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Pesanan Kamu Telah Kami Terima.<br />Target : '.$post_target.'<br />Jumlah : '.$jumlah.'<br />');
				        } else {
					        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
				        }
			        }
		        }
	        }
        }
	
	    require("../lib/header.php");

?>

<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                

                <!-- Basic Vertical form layout section start -->
                <section id="basic-vertical-layouts">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Pemesanan</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-vertical" method="post">
                                    	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>"> 
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="first-name-vertical">Kategori</label>
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
													<span class="form-text text-muted"><?php echo ($error['kategori']) ? $error['kategori'] : '';?></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="email-id-vertical">Layanan</label>
                                                   <select class="form-control" name="layanan" id="layanan">
														<option value="0">Pilih Kategori Dahulu</option>
													</select>
													<span class="form-text text-muted"><?php echo ($error['layanan']) ? $error['layanan'] : '';?></span>
                                                </div>
                                            </div>
                                            <div id="catatan"></div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="password-vertical">Target</label>
                                                    <input type="text"  class="form-control" name="target" placeholder="target" />
                                                    <span class="form-text text-muted"><?php echo ($error['target']) ? $error['target'] : '';?></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="password-vertical">Jumlah</label>
                                                    <input type="number"  class="form-control" name="jumlah" placeholder="jumlah" onkeyup="get_total(this.value).value;"/>
                                                    <span class="form-text text-muted"><?php echo ($error['target']) ? $error['target'] : '';?></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1">
                                                    <label class="form-label" for="password-icon">Total Harga</label>
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text"><i data-feather="dollar-sign"></i></span>
                                                        <input type="number" id="total" placeholder="0" readonly class="form-control"  />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="reset" class="btn btn-primary me-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Informasi Pemesanan</h4>
                                </div>
                                <div class="card-body">
                                	<p>langkah Membuat Pesanan:</p>
                                    <ul>
                                    <li>Pilih salah satu Kategori.</li>
                                    <li>Pilih salah satu Layanan yang ingin dipesan.</li>
                                    <li>Masukkan Target pesanan sesuai ketentuan yang diberikan layanan tersebut.</li>
                                    <li>Masukkan Jumlah Pesanan yang diinginkan.</li>
                                    <li>Klik Submit untuk membuat pesanan baru.</li>
                                </ul>
                                <p>Ketentuan membuat pesanan baru:</p>
                                <ul>
                                    <li>Silahkan membuat pesanan sesuai langkah-langkah diatas.</li>
                                    <li>Jika ingin membuat pesanan dengan Target yang sama dengan pesanan yang sudah pernah dipesan sebelumnya, mohon menunggu sampai pesanan sebelumnya selesai diproses.</li>
                                    <li>Jika terjadi kesalahan / mendapatkan pesan gagal yang kurang jelas, silahkan hubungi Admin untuk informasi lebih lanjut.</li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Vertical form layout section end -->

                

            </div>
        </div>
    </div>
    <!-- END: Content-->
<?php
	require ("../lib/footer.php");
?>