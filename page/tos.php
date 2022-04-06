<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>
<div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                
            </div>
            <div class="content-body">
                <!-- Examples -->
                
                <!-- Examples -->

                <!-- Content types -->
                <section id="card-content-types">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h4 class="card-title">Ketentuan Layanan</h4>
                                    <?php         
                    $cek_konten = $conn->query("SELECT * FROM ketentuan_layanan WHERE tipe = 'Layanan'");
                    while ($data_konten = $cek_konten->fetch_assoc()) {
                    ?>
                                    <p class="card-text">
                                        <?php echo $data_konten['konten']; ?><br />
                                    </p>
                                    <?php } ?>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>

                </section>
                <!--/ Content types -->

                
                <!--/ Card layout -->

            </div>
        </div>
    </div>
    <!-- END: Content-->
<?php
require '../lib/footer.php';
?>