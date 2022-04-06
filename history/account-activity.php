<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';
?>

<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Aktivitas Akun</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>
                                            <th>Tipe</th>
                                            <th>IP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM aktifitas WHERE aksi LIKE '%$cari_aksi%' AND username = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM aktifitas WHERE username = '$sess_username' ORDER BY id DESC"; // edit
}
if (isset($_GET['tampil'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_riwayat." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
$no = $starting_position+1;
// end paging config
while ($data_riwayat = $new_query->fetch_assoc()) {
if ($data_riwayat['aksi'] == "Masuk") {
    $label = "primary";
} else if ($data_riwayat['aksi'] == "Keluar") {
    $label = "danger";
}
?>
                                        <tr>
                                        	<td><?php echo $no++; ?></td>
                                        	<td><?php echo tanggal_indo($data_riwayat['date']); ?>/<?php echo $data_riwayat['time']; ?></td>
                                        	<td><?php echo $data_riwayat['aksi']; ?></td>
                                        	<td><?php echo $data_riwayat['ip']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






<?php
require '../lib/footer.php';
?>