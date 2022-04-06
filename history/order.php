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
                                <h4 class="card-title">Riwayat Pemesanan</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                                <th>Tanggal & Waktu</th>
                                                <th>Kategori</th>
                                                <th>Nama Layanan</th>
                                                <th>Target</th>
                                                <th>Harga</th>
                                                <th>Status</th>
                                                
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
// start paging config
if (isset($_GET['cari'])) {
    $cari_oid = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_pesanan = "SELECT * FROM semua_pembelian WHERE id_order LIKE '%$cari_oid%' AND status LIKE '%$cari_status%' AND user = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_pesanan = "SELECT * FROM semua_pembelian WHERE user = '$sess_username' ORDER BY id DESC"; // edit
}
if (isset($_GET['cari'])) {
$cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
$records_per_page = $cari_urut; // edit
} else {
    $records_per_page = 10; // edit
}

$starting_position = 0;
if(isset($_GET["halaman"])) {
    $starting_position = ($conn->real_escape_string(filter($_GET["halaman"]))-1) * $records_per_page;
}
$new_query = $cek_pesanan." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_pesanan = $new_query->fetch_assoc()) {
    if ($data_pesanan['status'] == "Pending") {
        $label = "warning";
    } else if ($data_pesanan['status'] == "Partial") {
        $label = "danger";
    } else if ($data_pesanan['status'] == "Error") {
        $label = "danger";    
    } else if ($data_pesanan['status'] == "Processing") {
        $label = "primary";    
    } else if ($data_pesanan['status'] == "Success") {
        $label = "success";    
    }
    if ($data_pesanan['refund'] == "0") {
        $icon2 = "times-circle";
        $label2 = "danger"; 
    } else if ($data_pesanan['refund'] == "1") {
        $icon2 = "check";
        $label2 = "success";
    }
?>
                                        <tr>
                                            <td><?php echo $data_pesanan['id_order']; ?></td>
                                            <td><?php echo tanggal_indo($data_pesanan['date']); ?>, <?php echo $data_pesanan['time']; ?></td>
                                            <td><?php echo $data_pesanan['kategori']; ?></td>
                                            <td><?php echo $data_pesanan['layanan']; ?></td>
                                            <td><?php echo $data_pesanan['target']; ?></td>
                                            <td><sup>Rp</sup>.<?php echo number_format($data_pesanan['harga'],0,',','.'); ?></td>
                                            <td><?php echo $data_pesanan['status']; ?></td>
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