<?php
session_start();
require '../config.php';
$tipe = "Masuk";

if (isset($_COOKIE['cookie_token'])) {
    $data = $conn->query("SELECT * FROM users WHERE cookie_token='" . $_COOKIE['cookie_token'] . "'");
    if (mysqli_num_rows($data) > 0) {
        $hasil = mysqli_fetch_assoc($data);
        $_SESSION['user'] = $hasil;
    }
}

if (isset($_SESSION['user'])) {
    header("Location: " . $config['web']['url']);
} else {

    if (isset($_POST['masuk'])) {
        $username = $conn->real_escape_string(filter($_POST['username']));
        $password = $conn->real_escape_string(filter($_POST['password']));

        $cek_pengguna = $conn->query("SELECT * FROM users WHERE username = '$username'");
        $cek_pengguna_ulang = mysqli_num_rows($cek_pengguna);
        $data_pengguna = mysqli_fetch_assoc($cek_pengguna);

        $verif_password = password_verify($password, $data_pengguna['password']);

        $error = array();
        if (empty($username)) {
            $error['username'] = '*Tidak Boleh Kosong';
        } else if ($cek_pengguna_ulang == 0) {
            $error['username'] = '*Pengguna Tidak Terdaftar';
        }
        if (empty($password)) {
            $error['password'] = '*Tidak Boleh Kosong';
        } else if ($verif_password <> $data_pengguna['password']) {
            $error['password'] = '*Kata Sandi Anda Salah';
        } else {

            if ($data_pengguna['status'] == "Tidak Aktif") {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Sudah Tidak Aktif.<script>swal("Gagal!", "Akun Sudah Tidak Aktif.", "error");</script>');
            } else if ($data_pengguna['status_akun'] == "Belum Verifikasi") {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Kamu Belum Di Verifikasi.<script>swal("Gagal!", "Akun Kamu Belum Di Verifikasi.", "error");</script>');
            } else {

                if ($cek_pengguna_ulang == 1) {
                    if ($verif_password == true) {
                        $remember = isset($_POST['remember']) ? TRUE : false;
                        if ($remember == TRUE) {
                            $cookie_token = md5($username);
                            $conn->query("UPDATE users SET cookie_token='" . $cookie_token . "' WHERE username='" . $username . "'");
                            setcookie('cookie_token', $cookie_token, time() + 60 * 60 * 24 * 365, '/');
                        }
                        $conn->query("INSERT INTO aktifitas VALUES ('','$username', 'Masuk', '" . get_client_ip() . "','$date','$time')");
                        $_SESSION['user'] = $data_pengguna;
                        exit(header("Location: " . $config['web']['url']));
                    } else {
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                    }
                }
            }
        }
    }
}

require '../lib/session_login.php';
require '../lib/database.php';
require '../lib/csrf_token.php';

?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $data['deskripsi_web']; ?>">
    <meta name="keywords" content="kata kunci 1, kata kunci 2,">
    <meta name="author" content="PIXINVENT">
    <title><?php echo $data['title']; ?></title>
    <link rel="apple-touch-icon" href="../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        <!-- Login basic -->
                       <?php
                            if (isset($_SESSION['hasil'])) {
                            ?>
                                    <div class="toast-container">
                                        <div class="toast show basic-toast position-fixed top-0 end-0 m-2" role="alert" aria-live="assertive" aria-atomic="true" >
                                            <div class="toast-header">
                                                <img src="../gambar/logo-sidebar.png" class="me-1" alt="Toast image" height="18" />
                                                <strong class="me-auto">Error</strong>
                                                <small class="text-muted">Sekarang</small>
                                                <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body"><?php echo $_SESSION['hasil']['pesan'] ?></div>
                                        </div>
                                    </div>
                                    <?php
                            unset($_SESSION['hasil']);
                            }
                            ?>
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="#" class="brand-logo">
                                    <img src="../gambar/logo-sidebar.png" height="30px">
                                    <h2 class="brand-text text-primary ms-1">Login Page</h2>
                                </a>

                                <h4 class="card-title mb-1">Welcome to <?php echo $data['short_title']; ?>! 👋</h4>
                                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>


                                <form class="auth-login-form mt-2" method="POST">
                                    <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                    <div class="mb-1">
                                        <label for="login-email" class="form-label">Username</label>
                                        <input type="text" class="form-control"  name="username" value="<?php echo $username; ?>" required placeholder="Username" aria-describedby="login-email" tabindex="1" autofocus />
                                    </div>

                                    <div class="mb-1">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label" for="login-password">Password</label>
                                            <a href="lupa">
                                                <small>Forgot Password?</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input type="password" class="form-control form-control-merge" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                            <label class="form-check-label" for="remember-me"> Remember Me </label>
                                        </div>
                                    </div>
                                    <button type="submit" name="masuk" class="btn btn-primary w-100" tabindex="4">Sign in</button>
                                </form>

                                <p class="text-center mt-2">
                                    <span>New on our platform?</span>
                                    <a href="register">
                                        <span>Create an account</span>
                                    </a>
                                </p>

                                
                            </div>
                        </div>
                        <!-- /Login basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../app-assets/js/core/app-menu.js"></script>
    <script src="../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->
   
    <!-- BEGIN: Page JS-->
    <script src="../app-assets/js/scripts/pages/auth-login.js"></script>
    <!-- END: Page JS-->
    <script src="../app-assets/js/scripts/components/components-bs-toast.js"></script>
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