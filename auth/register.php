<?php
session_start();
require '../config.php';
$tipe = "Daftar";

function dapetin($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data, true);
}
        if (isset($_POST['daftar'])) {
            $nama_depan = $conn->real_escape_string(filter($_POST['nama_depan']));
            $nama_belakang = $conn->real_escape_string(filter($_POST['nama_belakang']));
            $email = $conn->real_escape_string(filter($_POST['email']));
            $username = $conn->real_escape_string(filter($_POST['username']));
            $no_hp = $conn->real_escape_string(filter($_POST['no_hp']));
            $password = $conn->real_escape_string(filter($_POST['password']));
            $password2 = $conn->real_escape_string(filter($_POST['password2']));
            $pin = $conn->real_escape_string(filter($_POST['pin']));
            $kode_referral = $conn->real_escape_string(filter($_POST['kode_referral']));
            $kode_undangan = $conn->real_escape_string(filter($_POST['kode_undangan']));


            $cek_email = $conn->query("SELECT * FROM users WHERE email = '$email'");
            $cek_email_ulang = mysqli_num_rows($cek_email);
            $data_email = mysqli_fetch_assoc($cek_email);
            
            $cek_ref = $conn->query("SELECT * FROM setting_referral");
            $cek_ref_ulang = mysqli_num_rows($cek_ref);
            $data_ref = mysqli_fetch_assoc($cek_ref);

            $cek_pengguna = $conn->query("SELECT * FROM users WHERE username = '$username'");
            $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
            $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

            $cek_no_hp = $conn->query("SELECT * FROM users WHERE no_hp = '$no_hp'");
            $cek_no_hp_ulang = mysqli_num_rows($cek_no_hp);
            $data_no_hp = mysqli_fetch_assoc($cek_no_hp);

            $cek_kode = $conn->query("SELECT * FROM users WHERE kode_referral = '$kode_referral'");
            $cek_kode_ulang = mysqli_num_rows($cek_kode);
            $data_kode = mysqli_fetch_assoc($cek_kode);
            
            $cek_kodeundangan = $conn->query("SELECT * FROM kode_undangan WHERE kode = '$kode_undangan'");
            $cek_kodeundangan_ulang = mysqli_num_rows($cek_kodeundangan);
            $data_kodeundangan = mysqli_fetch_assoc($cek_kodeundangan);

            $uplink = $data_kode['username'];
            $level = $data_kodeundangan['level'];
            $kode_ref = acak(3).acak_nomor(4);

            $error = array();
            if (empty($nama_depan)) {
    		    $error ['nama_depan'] = '*Tidak Boleh Kosong';
            }
            if (empty($nama_belakang)) {
    		    $error ['nama_belakang'] = '*Tidak Boleh Kosong';
            }
            if (empty($email)) {
    		    $error ['email'] = '*Tidak Boleh Kosong';
            } else if ($cek_email->num_rows > 0) {
    		    $error ['email'] = '*Email Sudah Terdaftar';
            }
            
            if (empty($username)) {
    		    $error ['username'] = '*Tidak Boleh Kosong';
            } 
            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)){
                $error ['username'] = '*Tidak Boleh Gunakan Spasi';
            } else if (strlen($username) < 5) {
    		    $error ['username'] = '*Nama Pengguna Minimal 5 Karakter';
            } else if ($cek_pengguna->num_rows > 0) {
    		    $error ['username'] = '*Nama Pengguna Sudah Terdaftar';
            } 
            
            if (empty($no_hp)) {
    		    $error ['no_hp'] = '*Tidak Boleh Kosong';
            } else if (!preg_match("/628/",$no_hp)) {
    		    $error ['no_hp'] = '*Format Nomor HP Harus 62';
            } else if ($cek_no_hp->num_rows > 0) {
    		    $error ['no_hp'] = '*Nomor HP Sudah Terdaftar';
            }
            if (empty($password)) {
    		    $error ['password'] = '*Tidak Boleh Kosong';
            } else if (strlen($password) < 6) {
    		    $error ['password'] = '*Minimal 6 Karakter';
            }
            if (empty($password2)) {
    		    $error ['password2'] = '*Tidak Boleh Kosong';
            } else if ($password <> $password2) {
    		    $error ['password2'] = '*Konfirmasi Kata Sandi Tidak Sesuai';
            }
            if (empty($pin)) {
    		    $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if (strlen($pin) <> 6 ){
    		    $error ['pin'] = '*PIN Harus 6 Digit.';
            }

	        {
	           if (mysqli_num_rows($cek_kode) == 1) {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Kode Referral Tidak Ditemukan.<script>swal("Gagal!", "Kode Referral Tidak Ditemukan.", "error");</script>');
	        } else if ($_POST['accept'] !== "true") {
	            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Silahkan Setujui Ketentuan Layanan Kami Sebelum Mendaftar.<script>swal("Gagal!", "Silahkan Setujui Ketentuan Layanan Kami Sebelum Mendaftar.", "error");</script>');
	        } else {

                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                $api_key =  acak(20);

                    if ($conn->query("INSERT INTO users VALUES ('', '$nama_depan', '$nama_belakang', '$nama_depan $nama_belakang', '$email', '$username', '$hash_password', '".$data_kodeundangan['saldo_sosmed']."', '".$data_kodeundangan['saldo_top_up']."', '0', '$level', 'Aktif', 'Belum Verifikasi', '$pin', '$api_key', 'Pendaftaran Gratis', '$uplink', '$date', '$time', '0', '$no_hp', '', '$kode_ref', '', '0', '')") == true) {
                    $conn->query("UPDATE kode_undangan SET status = 'Sudah Dipakai' WHERE kode = '$kode_undangan'");
                        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Akun Kamu Berhasil Di Daftarkan.<script>swal("Berhasil!", "Akun Kamu Berhasil Di Daftarkan.", "success");</script>');
                    } else {
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Periksa kembali kesalahan input.<script>swal("Ups Gagal!", "Periksa kembali kesalahan input.", "error");</script>');
                    }
                }
            }
        }

        require '../lib/header_home.php';

?>

        <!-- Start Page Register -->
        <div class="login-2" style="background-image: url('');">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 d-none d-sm-block">
                <img src="https://okepedia.my.id/assets/media/logos/logooke.png" alt="Image" class="img-fluid" style="max-width: 100% !important;">
            </div>
                    <div class="col-lg-6">
                        <div class="form-section" >
		                    <div style="margin-bottom:15px">
					            <div class="">
					                <a href="https://okepedia.my.id/public/auth/register">
					                    <img src="https://okepedia.my.id/assets/media/logos/logooke.png" width="220px" class="img" alt="solusimedia">
					                </a>
					            </div>
					        </div>
                            <?php
                            if (isset($_SESSION['hasil'])) {
                            ?>
                            <div class="alert alert-<?php echo $_SESSION['hasil']['alert'] ?> alert-dismissible" role="alert">
                                <?php echo $_SESSION['hasil']['pesan'] ?>
                            </div>
                            <?php
                            unset($_SESSION['hasil']);
                            }
                            ?>
                            <!--<div class="row">
                                <div class="col-xl-12 m-b-30">
		                            <div class="btn-group flex-wrap mb-4" role="group">
		                                <a href="/auth/login" class="btn btn-primary ">Masuk</a>
		                            </div>
		                            <div class="btn-group flex-wrap mb-4" role="group">
		                                <a href="/auth/register" class="btn btn-primary active">Daftar</a>
		                            </div>
		                       	</div>
		                    </div>-->
                            <div class="alert alert-danger alert-dismissible">
                            <p>Setelah daftar harus<a href="<?php echo $config['web']['url'] ?>auth/verification-account"> <strong style="color:#354da1">Verifikasi Disini</strong></a></p>
                            </div>
                            <div class="login-inner-form">
                                <form class="form-horizontal" role="form" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="row">
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="text" class="input-text" placeholder="Nama Depan" name="nama_depan" value="<?php echo $nama_depan; ?>" required>
                                            <i class="flaticon-user"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['nama_depan']) ? $error['nama_depan'] : '';?></small>
                                        </div>
                                        <div class="form-group form-box col-md-6 col-12">
                                            <input type="text" class="input-text" placeholder="Nama Belakang" name="nama_belakang" value="<?php echo $nama_belakang; ?>" required>
                                            <i class="flaticon-user"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['nama_belakang']) ? $error['nama_belakang'] : '';?></small>
                                        </div>
                                    </div>
                                        <div class="form-group form-box">
                                            <input type="email" class="input-text" placeholder="Email Aktif" name="email" value="<?php echo $email; ?>" required>
                                            <i class="flaticon-mail"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['email']) ? $error['email'] : '';?></small>
                                        </div>
                                        <div class="form-group form-box">
                                            <input type="number" class="input-text" placeholder="Nomor HP (gunakan 62)" name="no_hp" value="<?php echo $no_hp; ?>" required>
                                            <i class="fa fa-phone"></i>
                                            <small class="text-danger font-13 pull-right"><?php echo ($error['no_hp']) ? $error['no_hp'] : '';?></small>
                                        </div>
                                    <div class="form-group form-box">
                                        <input type="text" class="input-text" name="username" id="username" placeholder="Username (tanpa spasi)" name="username" value="<?php echo $username; ?>" required>
                                        <i class="flaticon-user"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['username']) ? $error['username'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="password" class="input-text" placeholder="Kata Sandi" name="password" value="<?php echo $password; ?>" required>
                                        <i class="flaticon-password"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['password']) ? $error['password'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="password" class="input-text" placeholder="Konfirmasi Kata Sandi" name="password2" value="<?php echo $password2; ?>" required>
                                        <i class="flaticon-password"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['password2']) ? $error['password2'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="number" class="input-text" placeholder="PIN Transaksi Harus 6 Digit" name="pin" value="<?php echo $pin; ?>" required>
                                        <i class="fa fa-key"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['pin']) ? $error['pin'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="text" class="input-text" placeholder="Kode Referral Jika Ada" name="kode_referral" value="<?php echo $kode_referral; ?>">
                                        <i class="fa fa-gift"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['kode_referral']) ? $error['kode_referral'] : '';?></small>
                                    </div>
                                    <div class="form-group form-box">
                                        <input type="number" class="input-text" placeholder="Kode Undangan Jika Ada" name="kode_undangan" value="<?php echo $kode_undangan; ?>">
                                        <i class="fa fa-code"></i>
                                        <small class="text-danger font-13 pull-right"><?php echo ($error['kode_undangan']) ? $error['kode_undangan'] : '';?></small>
                                    </div>
                                    <div class="checkbox clearfix">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" value="true" name="accept" id="rememberMe" required>
                                            <label class="form-check-label" for="rememberMe">
                                                Saya Setuju Dengan <a href="<?php echo $config['web']['url'] ?>page/tos" style="color:#5867dd">Ketentuan Layanan</a> Solusi Media
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-block" name="daftar">Daftar</button>
                                    </div>
                                    <br/>
                                    <br />
                                    <p>Sudah Punya Akun ?<a class="text-primary" href="<?php echo $config['web']['url'] ?>auth/login"> <strong>Masuk</strong></a></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Register -->

        <script src='https://www.google.com/recaptcha/api.js'></script>

<?php
require '../lib/footer_home.php';
?>