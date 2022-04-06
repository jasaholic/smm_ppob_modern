<?php
require '../config.php';
require '../lib/database.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $data['title']; ?></title>
        <meta content="<?php echo $data['deskripsi_web']; ?>" name="description" />
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
    <body>
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
                                <li><a href="">Beranda</a></li>
                                <li><a href="faq">Faq</a></li>
                                <li><a href="kontak">Kontak</a></li>
                               
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-2 hidden-xs">
                        <div class="navigator_btn btn_bg text-right">
                            <a class="common_btn" href="../auth/register">Register</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header section -->
        <!-- Payloan_header_bg section -->
        <section class="payloan_header_bg header_bg_1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="welcome_area">
                            <div class="welcome_text">
                                <h1>The right <span>decision</span><br>at the right time.</h1>
                                <p>We are here to help you when you need your financial support, then we are help you.</p>
                            </div>
                            <div class="welcome_button">
                                <a href="#" class="common_btn">Contact Us</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="header_img">
                            <img src="images/slider/2.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Payloan_header_bg section -->
        <!-- Common section -->
        <section class="commonSection homeService">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 mt176">
                        <div class="singleService_2">
                            <div class="flipper">
                                <div class="front">
                                    <i class="flaticon-mortgage-loan"></i>
                                    <h1>10.2%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Business Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                                <div class="back">
                                    <i class="flaticon-mortgage-loan"></i>
                                    <h1>10.2%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Business Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="singleService_2">
                            <div class="flipper">
                                <div class="front">
                                    <i class="flaticon-money"></i>
                                    <h1>9.35%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Personal Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                                <div class="back">
                                    <i class="flaticon-money"></i>
                                    <h1>9.35%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Personal Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                            </div>
                        </div>
                        <div class="singleService_2">
                            <div class="flipper">
                                <div class="front">
                                    <i class="flaticon-loan-1"></i>
                                    <h1>28.6%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Education Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                                <div class="back">
                                    <i class="flaticon-loan-1"></i>
                                    <h1>28.6%</h1>
                                    <div class="clearfix"></div>
                                    <h4>Education Loan</h4>
                                    <p>Stay turned into the world of finance & business.</p>
                                    <h5>20 months installment</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4 col-md-12">
                        <div class="serviceArea">
                            <h3>We provide awesome services, it’s here.</h3>
                            <p>We are here to help you when you need your financial support, then we are help you.</p>
                            <p>We are here to help you when you need your financial support, then we are help you.</p>
                            <a href="#" class="common_btn">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection homeContact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="contactArea">
                            <h3>Our manager will contact you to clear the details.</h3>
                            <p>We are here to help you when you need your financial support, then we are help you.</p>
                            <p>We are here to help you when you need your financial support, then we are help you.</p>
                            <a href="#" class="common_btn">Call Us Now</a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="contactThumb">
                            <img src="images/home/1.png" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection applicatioProces">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="sec_title">Fast and very easy<br> application process here</h2>
                        <p class="sec_desc">We are here to help you when you need your financial<br> support, then we are help you.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="singleProcess_2 mr_40">
                            <div class="flipper">
                                <div class="front">
                                    <div class="bg_number">
                                        <h1>01</h1>
                                    </div>
                                    <h4>Apply Bank Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                                <div class="back">
                                    <div class="bg_number">
                                        <h1>01</h1>
                                    </div>
                                    <h4>Apply Bank Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="singleProcess_2 mlr_40">
                            <div class="flipper">
                                <div class="front">
                                    <div class="bg_number">
                                        <h1>02</h1>
                                    </div>
                                    <h4>Approved Bank Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                                <div class="back">
                                    <div class="bg_number">
                                        <h1>02</h1>
                                    </div>
                                    <h4>Approved Bank Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="singleProcess_2 ml_40">
                            <div class="flipper">
                                <div class="front">
                                    <div class="bg_number">
                                        <h1>03</h1>
                                    </div>
                                    <h4>Review Your Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                                <div class="back">
                                    <div class="bg_number">
                                        <h1>03</h1>
                                    </div>
                                    <h4>Review Your Loan</h4>
                                    <p>We are provide best services and finaancial solution for you.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection applyAmoutSec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="sec_title">Get your amount<br> for fillup this form</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="applyamountFrom">
                            <form action="#" method="post">
                                <input type="number" step="any" name="amount" placeholder="Amount">
                                <input type="number" step="any" name="amount" placeholder="Long of months?">
                                <input type="number" step="any" name="amount" placeholder="Installment amount.">
                                <button class="common_btn" type="submit">Subscribe Now</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="sec_title">Expert team members</h2>
                        <p class="sec_desc">We are here to help you when you need your financial<br> support, then we are help you.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="singleTeam text-center">
                            <img src="images/team/1.png" alt="">
                            <h4>Roxanne Bryant</h4>
                            <p>Managing Director</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="singleTeam text-center">
                            <img src="images/team/2.png" alt="">
                            <h4>Dominic Jefferson</h4>
                            <p>Head of Marketing</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="singleTeam text-center">
                            <img src="images/team/3.png" alt="">
                            <h4>Mercedes Baldwin</h4>
                            <p>General Manager</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="singleTeam text-center">
                            <img src="images/team/4.png" alt="">
                            <h4>Gertrude Keller</h4>
                            <p>Commercial Manager</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection custome_sec_2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="sec_title">How to say our most<br> honorable customer</h2>
                        <p class="sec_desc">We are here to help you when you need your financial<br> support, then we are help you.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="customer_area">
                            <div class="singleCustomer">
                                <img src="images/about/5.png" alt=""/>
                                <div class="quote_img"><img src="images/quote.png" alt=""/></div>
                                <p>
                                    From time time we need generate
                                    sample names to populate a test
                                    database usually just requiring first
                                    and last names address.
                                </p>
                                <h5>Austin Matthews</h5>
                                <div class="cus_signature">
                                    <img src="images/signature.png" alt=""/>
                                </div>
                            </div>
                            <div class="singleCustomer">
                                <img src="images/about/5.png" alt=""/>
                                <div class="quote_img"><img src="images/quote.png" alt=""/></div>
                                <p>
                                    From time time we need generate
                                    sample names to populate a test
                                    database usually just requiring first
                                    and last names address.
                                </p>
                                <h5>Evelyn Goodman</h5>
                                <div class="cus_signature">
                                    <img src="images/signature.png" alt=""/>
                                </div>
                            </div>
                            <div class="singleCustomer">
                                <img src="images/about/5.png" alt=""/>
                                <div class="quote_img"><img src="images/quote.png" alt=""/></div>
                                <p>
                                    From time time we need generate
                                    sample names to populate a test
                                    database usually just requiring first
                                    and last names address.
                                </p>
                                <h5>Calvin Cannon</h5>
                                <div class="cus_signature">
                                    <img src="images/signature.png" alt=""/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="customer_thumb">
                            <img src="images/about/3.png" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

        <!-- Common section -->
        <section class="commonSection postTodaySec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2 class="sec_title">Warm Content of Todays</h2>
                        <p class="sec_desc">We are here to help you when you need your financial<br> support, then we are help you.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="latestPost">
                            <h4><a href="#">What should you need do to get personal loan ver easay.</a></h4>
                            <span>20 days ago</span>
                            <p>
                                Many modern alternatives often eumen incorpo
                                other content actually detracts from...
                            </p>
                            <a href="#" class="readMore">More details</a>
                        </div>
                        <div class="latestPost">
                            <h4><a href="#">What should you need do to get personal loan ver easay.</a></h4>
                            <span>20 days ago</span>
                            <p>
                                Many modern alternatives often eumen incorpo
                                other content actually detracts from...
                            </p>
                            <a href="#" class="readMore">More details</a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="featureImg text-center">
                            <img src="images/home/2.png" alt=""/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Common section -->

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
                    <div class="col-sm-6">
                        <p>Copyright <a href="#">Payloan</a>. All rights reserved</p>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="#" id="backTo"><i class="flaticon-chevron"></i></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Copyright section -->

        <!-- Include All JS -->
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/modernizr.custom.js"></script>
        <script src="js/jquery.themepunch.revolution.min.js"></script>
        <script src="js/jquery.themepunch.tools.min.js"></script>
        
        <script src="js/jquery-ui.js"></script>
        <script src="js/shuffle.js"></script>
        <script src="js/slick.js"></script>
        <script src="js/gmaps.js"></script>
        <script src="https://maps.google.com/maps/api/js?key=AIzaSyCysDHE3s4Qw3nTh9o58-2mJcqvR6HV8Kk"></script>
        <script src="js/owl.carousel.js"></script>
        <script src="js/theme.js"></script>
    </body>

</html>