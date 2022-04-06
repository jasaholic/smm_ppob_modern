<?php
session_start();
require("config.php");

if (isset($_COOKIE['cookie_token'])) {
    $data = $conn->query("SELECT * FROM users WHERE cookie_token='" . $_COOKIE['cookie_token'] . "'");
    if (mysqli_num_rows($data) > 0) {
        $hasil = mysqli_fetch_assoc($data);
        $_SESSION['user'] = $hasil;
    }
}


if (isset($_SESSION['user'])) {
    $sess_username = $_SESSION['user']['username'];
    $check_user = $conn->query("SELECT * FROM users WHERE username = '$sess_username'");
    $data_user = $check_user->fetch_assoc();
    $check_username = $check_user->num_rows;
    if ($check_username == 0) {
        header("Location: " . $config['web']['url'] . "logout.php");
    } else if ($data_user['status'] == "Tidak Aktif") {
        header("Location: " . $config['web']['url'] . "logout.php");
    }

    // Data Grafik Pesanan Sosial Media

    $check_order_today = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$date' and user = '$sess_username'");

    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_oneday_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$oneday_ago' and user = '$sess_username'");

    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_twodays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$twodays_ago' and user = '$sess_username'");

    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_threedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$threedays_ago' and user = '$sess_username'");

    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_fourdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fourdays_ago' and user = '$sess_username'");

    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_fivedays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$fivedays_ago' and user = '$sess_username'");

    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_sixdays_ago = $conn->query("SELECT * FROM pembelian_sosmed WHERE date ='$sixdays_ago' and user = '$sess_username'");

    // Data Selesai

    // Data Grafik Pesanan Top Up

    $check_order_pulsa_today = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$date' and user = '$sess_username'");

    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_pulsa_oneday_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$oneday_ago' and user = '$sess_username'");

    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_pulsa_twodays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$twodays_ago' and user = '$sess_username'");

    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_pulsa_threedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$threedays_ago' and user = '$sess_username'");

    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_pulsa_fourdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fourdays_ago' and user = '$sess_username'");

    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_pulsa_fivedays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$fivedays_ago' and user = '$sess_username'");

    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_pulsa_sixdays_ago = $conn->query("SELECT * FROM pembelian_pulsa WHERE date ='$sixdays_ago' and user = '$sess_username'");

    // Data Selesai

    // Data Grafik Pesanan Pascabayar
    $check_order_pascabayar_today = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$date' and user = '$sess_username'");

    $oneday_ago = date('Y-m-d', strtotime("-1 day"));
    $check_order_pascabayar_oneday_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$oneday_ago' and user = '$sess_username'");

    $twodays_ago = date('Y-m-d', strtotime("-2 day"));
    $check_order_pascabayar_twodays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$twodays_ago' and user = '$sess_username'");

    $threedays_ago = date('Y-m-d', strtotime("-3 day"));
    $check_order_pascabayar_threedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$threedays_ago' and user = '$sess_username'");

    $fourdays_ago = date('Y-m-d', strtotime("-4 day"));
    $check_order_pascabayar_fourdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fourdays_ago' and user = '$sess_username'");

    $fivedays_ago = date('Y-m-d', strtotime("-5 day"));
    $check_order_pascabayar_fivedays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$fivedays_ago' and user = '$sess_username'");

    $sixdays_ago = date('Y-m-d', strtotime("-6 day"));
    $check_order_pascabayar_sixdays_ago = $conn->query("SELECT * FROM pembelian_pascabayar WHERE date ='$sixdays_ago' and user = '$sess_username'");

    // Data Selesai

} else {
    $_SESSION['user'] = $data_user;
    header("Location: " . $config['web']['url'] . "dashboard");
}

include("lib/header.php");
if (isset($_SESSION['user'])) {
?>

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <section id="dashboard-ecommerce">
                    <div class="row match-height">
                        <!-- Medal Card -->
                        <div class="col-xl-6 col-md-6 col-12">
                            <div class="card card-congratulation-medal">
                                <div class="card-body">
                                    <h5>Hallo 🎉 <?php echo $data_user['nama']; ?>!</h5>
                                    <p class="card-text font-small-3">Selamat Datang Kembali</p>
                                    <h3 class="mb-75 mt-2 pt-50">
                                        <a href="#"><sup>Rp.</sup><?php echo number_format($data_user['saldo_top_up'], 0, ',', '.'); ?></a>
                                    </h3>
                                    <a href="<?php echo $config['web']['url'] ?>deposit-balance" class="btn btn-primary"><i class="ficon" data-feather="credit-card"></i> Topup</a>
                                    <img src="app-assets/images/illustration/badge.svg" class="congratulation-medal" alt="Medal Pic" />
                                </div>
                            </div>
                        </div>
                        <!--/ Medal Card -->

                        <!-- Statistics Card -->
                        <div class="col-md-6 col-sm-12">
                            <div class="card">
                                
                                
                                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-indicators">
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                        </div>
                                        <div class="carousel-inner">
                                            <div class="carousel-item active">
                                                <img src="https://blogger.googleusercontent.com/img/a/AVvXsEgW-4JTX6FBPyqWeWlrbeDLCOriNFLxy_Bqm_6nNkR69zImmF5VW9gmJtziwBsgh_az-rrL9MahNVyWZh2vQeX1NwHf5_PhShn-3n1ouml0OFBQw-9F5ccKAbbAHSKluAuT_RRrDCklmfffPZp_gxshkwTfNagtaDdPv3SrA8SW7P-Qz6KRauC-fJz6TA=s1600" class="d-block" height="200" width="auto"   alt="First slide" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="https://suneducationgroup.com/wp-content/uploads/2019/11/WEB-BANNER-YEAR-END-PROMO-SUN-ENGLISH-2019-Copy-1.jpg " class="d-block "height="200" width="auto" alt="Second slide" />
                                            </div>
                                            <div class="carousel-item">
                                                <img src="https://www.simplyhomy.com/wp-content/uploads/2011/02/banner-promo-franchise-JUL-.jpg" class="d-block "height="200" width="auto" alt="Third slide" />
                                            </div>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                            </div>
                        </div>
                        <!--/ Statistics Card -->
                    </div>

                    

                    <div class="row match-height">
                        <!-- Company Table Card -->
                        <div class="col-lg-12 col-12">
                            <div class="card card-company-table">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Layanan</th>
                                                    <th>Harga</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                    $no = 1;
                                    $cek_pesanan = $conn->query("SELECT * FROM semua_pembelian WHERE user = '$sess_username' ORDER BY id DESC LIMIT 10"); // edit
                                    while ($data_pesanan = $cek_pesanan->fetch_assoc()) {
                                        if ($data_pesanan['status'] == "Pending") {
                                            $label = "warning";
                                        } else if ($data_pesanan['status'] == "Processing") {
                                            $label = "primary";
                                        } else if ($data_pesanan['status'] == "Error") {
                                            $label = "danger";
                                        } else if ($data_pesanan['status'] == "Partial") {
                                            $label = "danger";
                                        } else if ($data_pesanan['status'] == "Success") {
                                            $label = "success";
                                        }
                                    ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            
                                                            <div>
                                                                <div class="fw-bolder"><?php echo $no; ?></div>
                                                                <div class="font-small-2 text-muted"><?php if ($data_pesanan['place_from'] == "API") { ?><i class="fa fa-random"></i><?php } else { ?><i class="flaticon-globe"></i><?php } ?></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="text-nowrap">
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bolder mb-25"><?php echo $data_pesanan['layanan']; ?></span>
                                                            <span class="font-small-2 text-muted"><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></span>
                                                        </div>
                                                    </td>
                                                    <td>Rp <?php echo number_format($data_pesanan['harga'], 0, ',', '.'); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="fw-bolder me-1"><span class="badge badge-light-<?php echo $label; ?> rounded-pill ms-auto me-1"><?php echo $data_pesanan['status']; ?></span></span>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php
                                        $no++;
                                    }
                                    ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Company Table Card -->

                        
                        <!--/ Transaction Card -->
                    </div>
                </section>
                <!-- Dashboard Ecommerce ends -->

            </div>
        </div>
    </div>
    <?php
}
require 'lib/footer.php';
    ?>