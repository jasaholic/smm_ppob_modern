<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>

	 <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Page</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Halaman</a>
                                    </li>
                                    <li class="breadcrumb-item active">Kontak
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <!-- Card Advance -->


                <div class="row match-height">
                    <!-- Employee Task Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-employee-task">
                            <div class="card-header">
                                <h4 class="card-title">Kontak</h4>
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer"></i>
                            </div>
                           
                            <div class="card-body">
                            	 <?php
        $cek_kontak = $conn->query("SELECT * FROM kontak_website ORDER BY id DESC");
        while ($data_kontak = $cek_kontak->fetch_assoc()) {
        ?><a href="https://wa.me/<?php echo $data_kontak['no_wa']; ?>">
                                <div class="employee-task d-flex justify-content-between align-items-center">
                                	
                                    <div class="d-flex flex-row">
                                        <div class="avatar me-75">
                                            <img src="<?php echo $data_kontak['link_foto']; ?>" class="rounded" width="42" height="42" alt="Avatar" />
                                        </div>
                                        <div class="my-auto">
                                            <h6 class="mb-0"><?php echo $data_kontak['nama']; ?></h6>
                                            <small>+<?php echo $data_kontak['no_wa']; ?></small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="text-muted me-75"><?php echo $data_kontak['level']; ?></small>
                                        <div class="employee-task-chart-primary-1"></div>
                                    </div>
                                
                                </div></a>
                                 <?php
        }
        ?>
                            </div>
                             
                        </div>
                    </div>
                    <!--/ Employee Task Card -->
                    <?php
        $cek_kontak = $conn->query("SELECT * FROM kontak_admin ORDER BY id DESC");
        while ($data_kontak = $cek_kontak->fetch_assoc()) {
        ?>
                    <!-- Developer Meetup Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-developer-meetup">
                            <div class="meetup-img-wrapper rounded-top text-center">
                                <img src="../../../app-assets/images/illustration/email.svg" alt="Meeting Pic" height="170" />
                            </div>
                            <div class="card-body">
                                <div class="meetup-header d-flex align-items-center">
                                    
                                    <div class="my-auto">
                                        <h4 class="card-title mb-25">Developer Meetup</h4>
                                        <p class="card-text mb-0"> <?php echo $data_kontak['deskripsi']; ?></p>
                                    </div>
                                </div>
                                <div class="d-flex flex-row meetings">
                                    <div class="avatar bg-light-primary rounded me-1">
                                        <div class="avatar-content">
                                            <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                                        </div>
                                    </div>
                                    <div class="content-body">
                                        <h6 class="mb-0">Senin - Minggu</h6>
                                        <small><?php echo $data_kontak['jam_kerja']; ?></small>
                                    </div>
                                </div>
                                <div class="d-flex flex-row meetings">
                                    <div class="avatar bg-light-primary rounded me-1">
                                        <div class="avatar-content">
                                            <i data-feather="map-pin" class="avatar-icon font-medium-3"></i>
                                        </div>
                                    </div>
                                    <div class="content-body">
                                        <h6 class="mb-0">Lokasi</h6>
                                        <small><?php echo $data_kontak['lokasi']; ?></small>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!--/ Developer Meetup Card -->
                    
                    <!-- Profile Card -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="card card-profile">
                            <img src="../../../app-assets/images/banner/banner-12.jpg" class="img-fluid card-img-top" alt="Profile Cover Photo" />
                            <div class="card-body">
                                <div class="profile-image-wrapper">
                                    <div class="profile-image">
                                        <div class="avatar">
                                            <img src="../gambar/user/12.png" alt="Profile Picture" />
                                        </div>
                                    </div>
                                </div>
                                <h3> <?php echo $data_kontak['nama']; ?></h3>
                                <h6 class="text-muted"><?php echo $data_kontak['email']; ?></h6>
                                <span class="badge badge-light-primary profile-badge"><?php echo $data_kontak['jabatan']; ?></span>
                                <hr class="mb-2" />
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-muted fw-bolder">Instagram</h6>
                                        <a class="btn btn-primary btn-xs rounded-pill" href="<?php echo $data_kontak['link_ig']; ?>">
                                        <i data-feather="instagram"></i></a>
                                    </div>
                                    <div>
                                        <h6 class="text-muted fw-bolder">Facebook</h6>
                                        <a class="btn btn-info btn-xs rounded-pill" href="<?php echo $data_kontak['link_fb']; ?>">
                                        <i data-feather="facebook"></i></a>
                                    </div>
                                    <div>
                                        <h6 class="text-muted fw-bolder">Whatsapp</h6>
                                        <a class="btn btn-warning btn-xs rounded-pill" href="https://api.whatsapp.com/send?phone=<?php echo $data_kontak['no_hp']; ?>">
                                        <i data-feather="message-circle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Profile Card -->
                    <?php
        }
        ?>
                    <!-- Apply Job Card -->
                   
                    <!--/ Payment Card -->
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

<?php
require '../lib/footer.php';
?>