<?php
require '../config.php';
require '../lib/database.php';
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Payloan - Banking & Business Loan HTML5 Responsive Template</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Include All CSS -->
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="css/payloan-icon.css"/>
        <link rel="stylesheet" type="text/css" href="css/icofont.css"/>
        <link rel="stylesheet" type="text/css" href="css/animate.css"/>
        <link rel="stylesheet" type="text/css" href="css/settings.css"/>
        <link rel="stylesheet" type="text/css" href="css/slick.css"/>
        <link rel="stylesheet" type="text/css" href="css/owl.theme.css"/>
        <link rel="stylesheet" type="text/css" href="css/owl.carousel.css"/>
        <link rel="stylesheet" type="text/css" href="css/preset.css"/>
        <link rel="stylesheet" type="text/css" href="css/theme.css"/>
        <link rel="stylesheet" type="text/css" href="css/responsive.css"/>

        <!-- Favicon Icon -->
        <link rel="icon"  type="image/png" href="images/favicon.png">
    </head>
    <body class="bg_right">
        <!-- Preloading -->
        <div class="preloader text-center">
            <div class="la-ball-circus la-2x">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <!-- Preloading -->

        <!-- Header section -->
        <header class="header_1" id="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3">
                        <div class="logo">
                            <a href="index.html"><img src="images/logo.png" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <nav class="mainmenu MenuInRight text-right">
                            <a href="javascript:void(0);" class="mobilemenu d-md-none d-lg-none d-xl-none">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                            <ul>
                                <li class="menu-item-has-children">
                                    <a href="#">home</a>
                                    <ul class="sub-menu">
                                        <li><a href="index.html">Home 01</a></li>
                                        <li><a href="index2.html">Home 02</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Services</a>
                                    <ul class="sub-menu">
                                        <li><a href="services.html">Service 01</a></li>
                                        <li><a href="services2.html">Service 02</a></li>
                                        <li><a href="service_details.html">Service Details</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Pages</a>
                                    <ul class="sub-menu">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="404.html">404 Page</a></li>
                                        <li><a href="faq.html">Faq Page</a></li>
                                        <li class="menu-item-has-children">
                                            <a href="#">Portfolio</a>
                                            <ul class="sub-menu">
                                                <li><a href="portfolio.html">Portfolio</a></li>
                                                <li><a href="portfolio_detail.html">Portfolio Details</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item-has-children">
                                            <a href="#">Testimonial</a>
                                            <ul class="sub-menu">
                                                <li><a href="testimonial.html">Testimonial 01</a></li>
                                                <li><a href="testimonial2.html">Testimonial 02</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="team.html">Team Member</a></li>
                                        <li><a href="application_form.html">Application Form</a></li>
                                        <li><a href="loan_calculation.html">Loan Calculation</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children">
                                    <a href="#">Blog</a>
                                    <ul class="sub-menu">
                                        <li><a href="blog.html">Blog Page</a></li>
                                        <li><a href="single_blog.html">Blog Details</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-2 hidden-xs">
                        <div class="navigator_btn btn_bg text-right">
                            <a class="common_btn" href="#">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header section -->

        <!-- Page Banner -->
        <section class="pagebanner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="bannerTitle text-left">
                            <h2>Application Form</h2>
                            <p>We are here to help you when you need your<br>financial support, then we are help you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Banner -->   

        <!-- Common Section -->
        <section class="commonSection applicationPage">
            <div class="container">
                <div class="row">
                    <?php


if (isset($_POST['kategori'])) {
    $post_kategori = $conn->real_escape_string(filter($_POST['kategori']));
    $cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE kategori = '$post_kategori'");
    if (mysqli_num_rows($cek_layanan) != 0) {
    ?>
                    <div class="col-lg-12 text-center">
                        <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                            <thead>
                                <tr>
                                    <th>ID Layanan</th>
                                    <th>Kategori</th>
                                    <th>Nama Layanan</th>
                                    <th>Harga WEB/1000</th>
                                    <th>Harga API/1000</th>
                                    <th>Min</th>
                                    <th>Max</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            while ($data_layanan = mysqli_fetch_assoc($cek_layanan)) {
                            if($data_layanan['status'] == "Aktif") {
                                $label = "success";
                            } else if($data_layanan['status'] == "Tidak Aktif") {
                                $label = "danger";
                            }
                            ?>
                                <tr>
                                    <th scope="row"><span class="badge badge-primary"><?php echo $data_layanan['service_id']; ?></span></th>
                                    <td><?php echo $data_layanan['kategori']; ?></td>
                                    <td><?php echo $data_layanan['layanan']; ?></td>
                                    <td><span class="badge badge-success">Rp <?php echo number_format($data_layanan['harga'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-warning">Rp <?php echo number_format($data_layanan['harga_api'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-danger"><?php echo number_format($data_layanan['min'],0,',','.'); ?></span></td>
                                    <td><span class="badge badge-dark"><?php echo number_format($data_layanan['max'],0,',','.'); ?></span></td>
                                    <td><label class="btn btn-sm btn-<?php echo $label; ?>"><?php echo $data_layanan['status']; ?></label></td>
                                </tr>
                            <?php
                            } 
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                           } } 
                            ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common Section -->  

        <!-- footer section -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <aside class="widget about_widgets">
                            <img src="images/logo.png" alt=""/>
                            <p>88 694 895 684</p>
                            <p>88 487 983 576</p>
                            <p>loanplus@gmail.com</p>
                        </aside>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <aside class="widget recent_posts">
                            <div class="singleLPost">
                                <h4><a href="#">What should you need do to get personal loan ver easay.</a></h4>
                                <span>20 days ago</span>
                                <p>
                                    Many modern alternatives often eumen incorpo
                                    other content actually detracts from...
                                </p>
                            </div>
                            <div class="singleLPost">
                                <h4><a href="#">What should you need do to get personal loan ver easay.</a></h4>
                                <span>20 days ago</span>
                                <p>
                                    Many modern alternatives often eumen incorpo
                                    other content actually detracts from...
                                </p>
                            </div>
                        </aside>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <aside class="widget subscribe_widgets">
                            <h3>Subscribe our newsletter.</h3>
                            <form action="#" method="post">
                                <input type="email" placeholder="Email address" name="email"/>
                                <input type="text" placeholder="Phone no." name="phone"/>
                                <input type="submit" value="Subscribe now">
                            </form>
                        </aside>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer section -->

        <!-- Copyright section -->
        <section class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <p>Copyright <a href="#">Payloan</a>. All rights reserved</p>
                    </div>
                    <div class="col-lg-6 text-right">
                        <a href="#" id="backTo"><i class="flaticon-chevron"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Copyright section -->

        <!-- Include All JS -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.themepunch.revolution.min.js"></script>
        <script src="js/jquery.themepunch.tools.min.js"></script>
        <!-- Rev slider Add on Start -->
        <script src="js/extensions/revolution.extension.actions.min.js"></script>
        <script src="js/extensions/revolution.extension.carousel.min.js"></script>
        <script src="js/extensions/revolution.extension.kenburn.min.js"></script>
        <script src="js/extensions/revolution.extension.migration.min.js"></script>
        <script src="js/extensions/revolution.extension.parallax.min.js"></script>
        <script src="js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="js/extensions/revolution.extension.navigation.min.js"></script>
        <script src="js/extensions/revolution.extension.video.min.js"></script>
        <!-- Rev slider Add on End -->
        <script src="js/jquery-ui.js"></script>
        <script src="js/shuffle.js"></script>
        <script src="js/slick.js"></script>
        <script src="js/gmaps.js"></script>
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyCysDHE3s4Qw3nTh9o58-2mJcqvR6HV8Kk"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/theme.js"></script>
    </body>

</html>