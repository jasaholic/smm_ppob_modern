<?php
require '../config.php';
require '../lib/database.php';
?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title><?php echo $data['short_title']; ?> | F.A.Q</title>
        <meta content="<?php echo $data['deskripsi_web']; ?>" name="description" />
        <meta content="faq, smm panel, ppob, pulsa, murah, web admin" name="keywords">
        <meta content="Merangintech" name="author" />
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
        <link rel="icon"  type="image/png" href="../gambar/favicon.png">
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
                            <a href="index.html"><img src="../gambar/logo.png" alt=""></a>
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
                                <li><a href="<?php echo $config['web']['url'] ?>">Beranda</a></li>
                                <li><a href="faq">Faq</a></li>
                                <li><a href="kontak">Kontak</a></li>
                               
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-2 hidden-xs">
                        <div class="navigator_btn btn_bg text-right">
                            <a class="common_btn" href="../auth/login">Login</a>
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
                            <h2>Frequently Ask Question</h2>
                            <p>We are here to help you when you need your<br>financial support, then we are help you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Page Banner -->       

        <!-- Common Section -->
        <section class="commonSection faqPage">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 faqPdRight">
                        <div class="singleFaq">
                            <h3>01. Make your start the world possible?</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                        <div class="singleFaq">
                            <h3>02. How much does it cost?</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                        <div class="singleFaq">
                            <h3>03. Is the universe deterministic?</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 faqPdLeft">
                        <div class="singleFaq">
                            <h3>04. Do numbers exhibit benford's?</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                        <div class="singleFaq">
                            <h3>05. Questions about games gambling</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                        <div class="singleFaq">
                            <h3>06. Which probability are supported?</h3>
                            <p>
                                Make a site look like the demo, so to make your
                                start into the world of possible we have include
                                content from and our showcase site import the
                                sample files we ship the core.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 text-center">
                        <h2 class="sec_title">
                            If you have others question!<br>Please, fillup this form.
                        </h2>
                        <form class="questinForm row" action="#" method="post">
                            <div class="col-lg-6 col-md-6">
                                <input type="email" name="email" placeholder="supportloan@gmail.com">
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <input type="number" name="phone" placeholder="+88 00 *** *** ***">
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <textarea required="" name="message" placeholder="Text here...."></textarea>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <button class="common_btn" type="submit">Submit Now</button>
                            </div>
                        </form>
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