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
                                <h4 class="card-title">Penggunaan Koin</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Jumlah</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
// start paging config
if (isset($_GET['tipe'])) {
    $cari_tipe = $conn->real_escape_string(filter($_GET['tipe']));

    $cek_data = "SELECT * FROM riwayat_saldo_koin WHERE aksi LIKE '%$cari_tipe%' AND username = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_data = "SELECT * FROM riwayat_saldo_koin WHERE username = '$sess_username' ORDER BY id DESC"; // edit
}
if (isset($_GET['tipe'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_data." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
$no = $starting_position+1;
// end paging config
while ($view_data = $new_query->fetch_assoc()) {
    if ($view_data['tipe'] == "Saldo") {
        $label = "success";
        $icon = "la la-credit-card";
    } else if ($view_data['tipe'] == "Koin") {
        $label = "primary";
        $icon = "flaticon-coins";
    }
    if ($view_data['aksi'] == "Penambahan Saldo") {
        $label = "primary";
    } else if ($view_data['aksi'] == "Pengurangan Saldo") {
        $label = "danger";
    }
    if ($view_data['aksi'] == "Penambahan Koin") {
        $label = "primary";
    } else if ($view_data['aksi'] == "Pengurangan Koin") {
        $label = "danger";
    }
?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                    <td><?php echo tanggal_indo($view_data['date']); ?>/<?php echo $view_data['time']; ?></td>
                                    <td><sup>Rp</sup>.<?php echo number_format($view_data['nominal'],0,',','.'); ?></td>
                                    <td><?php echo $view_data['pesan']; ?></td>
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