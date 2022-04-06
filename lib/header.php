<?php
require 'session_login.php';
require 'database.php';
require 'csrf_token.php';
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="<?php echo $data['deskripsi_web']; ?>">
    <meta name="keywords" content="Sosial media, smm panel, jasa website, jasaholic, merangintech, autofollower, instagram, ">
    <meta name="author" content="Merangintech">
    <title><?php echo $data['title']; ?></title>
    <link rel="apple-touch-icon" href="<?php echo $config['web']['url'] ?>gambar/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $config['web']['url'] ?>gambar/favicon-128.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/vendors/css/extensions/toastr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/plugins/extensions/ext-component-toastr.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/plugins/forms/form-wizard.css">

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>assets/css/style.css">
     <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['url'] ?>app-assets/css/pages/app-invoice.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->
<?php
if (isset($_SESSION['user'])) {
?>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link" href="<?php echo $config['web']['url'] ?>deposit-balance" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Topup"><i class="ficon" data-feather="credit-card"></i></a></li>
                </ul>
                
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                
                
                
                <li class="nav-item dropdown dropdown-notification me-25"><a class="nav-link" href="#" data-bs-toggle="dropdown"><i class="ficon" data-feather="bell"></i></a>
                    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                        <li class="dropdown-menu-header">
                            <div class="dropdown-header d-flex">
                                <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                <div class="badge rounded-pill badge-light-primary">5 Update Terakhir</div>
                            </div>
                        </li>
                        <li class="scrollable-container media-list"><a class="d-flex" href="#">
                            <?php
                                $cek_berita = $conn->query("SELECT * FROM berita ORDER BY id DESC LIMIT 5");
                                while ($data_berita = $cek_berita->fetch_assoc()) {
                                    $beritastr = "-" . strlen($data_berita['konten']);
                                    $beritasensor = substr($data_berita['konten'], $slider_beritastr, +100);
                                    if ($data_berita['tipe'] == "INFO") {
                                        $label = "info";
                                    } else if ($data_berita['tipe'] == "PERINGATAN") {
                                        $label = "warning";
                                    } else if ($data_berita['tipe'] == "PENTING") {
                                        $label = "danger";
                                    }

                                    if ($data_berita['icon'] == "PESANAN") {
                                        $label_icon = "shopping-cart";
                                    } else if ($data_berita['icon'] == "LAYANAN") {
                                        $label_icon = "server";
                                    } else if ($data_berita['icon'] == "DEPOSIT") {
                                        $label_icon = "credit-card";
                                    } else if ($data_berita['icon'] == "PENGGUNA") {
                                        $label_icon = "user";
                                    } else if ($data_berita['icon'] == "PROMO") {
                                        $label_icon = "gift";
                                    }
                                ?>
                                <a class="d-flex" href="<?php echo $config['web']['url'] ?>page/news-details?id=<?php echo $data_berita['id']; ?>">
                                <div class="list-item d-flex align-items-start">
                                    <div class="me-1">
                                        <div class="avatar bg-light-success">
                                            <div class="avatar-content"><i class="avatar-icon" data-feather="<?php echo $label_icon; ?>"></i></div>
                                        </div>
                                    </div>
                                    <div class="list-item-body flex-grow-1">
                                        <p class="media-heading"><span class="fw-bolder"><?php echo $data_berita['title']; ?></span></p><small class="notification-text"> <?php echo nl2br($beritasensor . "....."); ?></small>
                                    </div>
                                </div>
                            </a>
                            <?php
                                }
                                ?>
                        </li>
                        <li class="dropdown-menu-footer"><a class="btn btn-primary w-100" href="<?php echo $config['web']['url'] ?>page/news">Read all notifications</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?php echo $data_user['nama']; ?></span><span class="user-status"><?php echo $data_user['level']; ?></span></div><span class="avatar"><img class="round" src="<?php echo $config['web']['url'] ?>app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item" href="<?php echo $config['web']['url'] ?>page/profile"><i class="me-50" data-feather="user"></i> Profile</a>
                        <a class="dropdown-item" href="<?php echo $config['web']['url'] ?>history/account-activity"><i class="me-50" data-feather="activity"></i> Aktivitas</a>
                        <a class="dropdown-item" href="<?php echo $config['web']['url'] ?>history/balance-coins"><i class="me-50" data-feather="check-square"></i> Keuangan</a>
                        <a class="dropdown-item" href="<?php echo $config['web']['url'] ?>history/order"><i class="me-50" data-feather="shopping-cart"></i> Pemesanan</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo $config['web']['url'] ?>history/deposit"><i class="me-50" data-feather="credit-card"></i> Riwayat Deposit</a>
                        
                        <a class="dropdown-item" href="<?php echo $config['web']['url'] ?>logout"><i class="me-50" data-feather="power"></i> Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a href="#">
                <h6 class="section-label mt-75 mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/icons/xls.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size me-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div><small class="search-data-size me-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div><small class="search-data-size me-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/icons/doc.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                    </div>
                </div><small class="search-data-size me-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a href="#">
                <h6 class="section-label mt-75 mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
                <div class="d-flex align-items-center">
                    <div class="avatar me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
                <div class="d-flex align-items-center">
                    <div class="avatar me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
                <div class="d-flex align-items-center">
                    <div class="avatar me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view-account.html">
                <div class="d-flex align-items-center">
                    <div class="avatar me-75"><img src="<?php echo $config['web']['url'] ?>app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="me-75" data-feather="alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="<?php echo $config['web']['url'] ?>"><span class="brand-logo">
                    <img src="<?php echo $config['web']['url'] ?>gambar/logo-sidebar.png">
                            </span>
                        <h2 class="brand-text"><?php echo $data['short_title']; ?></h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="active"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Beranda">Beranda</span></a>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>order"><i data-feather="shopping-bag"></i><span class="menu-title text-truncate" data-i18n="Beranda">Order</span></a>
                </li>
                <?php
                    if ($data_user['level'] == "Developers") {
                    ?>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>/admin"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="Adminpanel">Adminpanel</span></a>
                </li>
                <?php } ?>
                <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Menu Utama</span><i data-feather="more-horizontal"></i>
                    <?php
                    if ($data_user['level'] != "Member") {
                    ?>
                </li>
                <li class="nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>deposit-balance"><i data-feather="dollar-sign"></i><span class="menu-title text-truncate" data-i18n="top-up">Topup</span></a>
                </li>

                <li class=" nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>page/user-ranking"><i data-feather="award"></i><span class="menu-title text-truncate" data-i18n="Top">Top</span></a>
                </li>
                
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="shopping-cart"></i><span class="menu-title text-truncate" data-i18n="Harga">Harga</span></a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>price-list/social-media"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Roles">SOSMED</span></a>
                        </li>
                        <li><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>price-list/top-up"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Permission">TOPUP</span></a>
                        </li>
                    </ul>
                </li>
                
                <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">Menu Agen</span></a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>staff/transfer-balance"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Transfer Saldo">Transfer Saldo</span></a>
                        </li>
                        <li><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>staff/code-invitation-new"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Kode Undangan">Kode Undangan</span></a>
                        </li>
                        
                    </ul>
                </li>
                
                <li class=" navigation-header"><span data-i18n="User Interface">Halaman</span><i data-feather="more-horizontal"></i>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>page/api-documentation"><i data-feather="code"></i><span class="menu-title text-truncate" data-i18n="Api">API</span></a>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>page/contact"><i data-feather="book"></i><span class="menu-title text-truncate" data-i18n="kontak">Kontak Kami</span></a>
                </li>
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>page/tos"><i data-feather="book-open"></i><span class="menu-title text-truncate" data-i18n="kontak">Term & Cond</span></a>
                </li>
                
                
                <li class=" navigation-header"><span data-i18n="Misc">User Session</span><i data-feather="more-horizontal"></i>
                </li>
                
                
                <li class=" nav-item"><a class="d-flex align-items-center" href="<?php echo $config['web']['url'] ?>logout"><i data-feather="log-out"></i><span class="menu-title text-truncate" data-i18n="Keluar">Keluar</span></a>
                </li>
                
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
    <?php 
}
}
?>
    <!-- END: Main Menu-->