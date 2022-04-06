<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

    	if (isset($_POST['kode_deposit'])) {
    	    $post_kode = $conn->real_escape_string(trim(filter($_POST['kode_deposit'])));

    	    $cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode'");
    	    $data_deposit = mysqli_fetch_assoc($cek_deposit);

    	    if (mysqli_num_rows($cek_deposit) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Tidak Di Temukan.<script>swal("Ups Gagal!", "Isi Saldomu Tidak Di Temukan.", "error");</script>');
    	    } else if($data_deposit['status'] !== "Pending" AND $data_deposit['status'] !== "Processing") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Gak Bisa Dibatalkan.<script>swal("Ups Gagal!", "Isi Saldomu Gak Bisa Dibatalkan.", "error");</script>');
    	    } else {

    	    $update_deposit = $conn->query("UPDATE deposit set status = 'Error' WHERE kode_deposit = '$post_kode'");
    	    if($update_deposit == TRUE) {
    	        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Isi Saldomu Berhasil Di Batalkan.<script>swal("Berhasil!", "Isi Saldomu Berhasil Di Batalkan.", "success");</script>');
    	    } else {
    			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
	        }
	    }

        } else if (isset($_POST['confirm'])) {
    	    $post_kode = $conn->real_escape_string(trim(filter($_POST['confirm'])));

    	    $cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode' AND date = '$date'");
    	    $data_deposit = mysqli_fetch_assoc($cek_deposit);

    	    $post_jumlah = $data_deposit['jumlah_transfer'];
    	    $post_saldo = $data_deposit['get_saldo'];
    	    $post_tipe = $data_deposit['metode_isi_saldo'];

    	    $cek_mutasi = $conn->query("SELECT * FROM mutasi WHERE kode_deposit = '$post_kode' AND date = '$date'");
    	    $data_mutasi = mysqli_fetch_assoc($cek_mutasi);

    	    $post_status = $data_mutasi['status'];

    	    if (mysqli_num_rows($cek_deposit) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Isi Saldomu Tidak Di Temukan.<script>swal("Ups Gagal!", "Isi Saldomu Tidak Di Temukan.", "error");</script>');
    	    } else if (mysqli_num_rows($cek_mutasi) == 0) {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Dana Kamu Tidak Ditemukan.<script>swal("Ups Gagal!", "Dana Kamu Tidak Ditemukan.", "error");</script>');
    	    } else if ($data_mutasi['status'] == "Dana Belum Masuk") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Dana Belum Kami Terima.<script>swal("Ups Gagal!", "Dana Belum Kami Terima.", "error");</script>');
    	    } else if ($data_deposit['status'] == "Success") {
    	        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Invoice Sudah Sukses.<script>swal("Ups Gagal!", "Invoice Sudah Sukses.", "error");</script>');
    	    } else {

        	    $check_top = $conn->query("SELECT * FROM top_depo WHERE username = '$sess_username'");
        	    $data_top = mysqli_fetch_assoc($check_top);
        	    $update = $conn->query("UPDATE deposit set status = 'Success' WHERE kode_deposit = '$post_kode'");
        	    $update = $conn->query("UPDATE users SET $post_tipe = $post_tipe + $post_saldo, pemakaian_saldo = pemakaian_saldo + $post_saldo WHERE username = '$sess_username'");
        	    $update = $conn->query("UPDATE mutasi SET status_aksi = 'Sudah Dikonfirmasi' WHERE kode_deposit = '$post_kode'");
        	    $update = $conn->query("UPDATE mutasi_bca SET status = 'READ' WHERE jumlah = '$post_jumlah' AND provider = 'BCA'");
        	    $update = $conn->query("UPDATE mutasi_gopay SET status = 'READ' WHERE amount = '$post_jumlah' AND provider = 'GOPAY'");
        	    $update = $conn->query("UPDATE mutasi_ovo SET status = 'READ' WHERE amount = '$post_jumlah' AND provider = 'OVO'");
        	    if ($update == TRUE) {
            	    $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Penambahan Saldo', '$post_saldo', 'Mendapatkan Saldo Melalui Isi Saldo Via ".$data_mutasi['tipe']." ".$data_mutasi['provider']." Dengan Kode Isi Saldo : $post_kode', '$date', '$time')");
            	    if($insert == TRUE) {
						if (mysqli_num_rows($check_top) == 0) {
							$insert_topup = $conn->query("INSERT INTO top_depo VALUES ('', 'Deposit', '$sess_username', '$post_saldo', '1')");
						} else {
							$insert_topup = $conn->query("INSERT top_depo SET jumlah = ".$data_top['jumlah']."+$post_saldo, total = ".$data_top['total']."+1 WHERE username = '$sess_username' AND method = 'Deposit'");
						}
            	        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Saldo Kamu Berhasil Dikonfirmasi.<script>swal("Berhasil!", "Saldo Kamu Udah Masuk.", "success");</script>');
            	    } else {
            			$_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
        	        }
        	    }
            }
        }

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
                            <h2 class="content-header-title float-start mb-0">Data Riwayat</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Riwayat</a>
                                    </li>
                                    <li class="breadcrumb-item active">Topup
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-12">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                    <th>Waktu</th>
                                    <th>Pembayaran</th>
                                   
                                    <th>Jumlah </th>
                                    <th>Saldo</th>
                                    <th>Status</th>
                                    <th>Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
// start paging config
$no = 1;
if (isset($_GET['cari'])) {
    $cari_id = $conn->real_escape_string(filter($_GET['cari']));
    $cari_status = $conn->real_escape_string(filter($_GET['status']));

    $cek_depo = "SELECT * FROM deposit WHERE kode_deposit LIKE '%$cari_id%' AND status LIKE '%$cari_status%' AND username = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_depo = "SELECT * FROM deposit WHERE username = '$sess_username' ORDER BY id DESC"; // edit
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
$new_query = $cek_depo." LIMIT $starting_position, $records_per_page";
$new_query = $conn->query($new_query);
// end paging config
while ($data_depo = $new_query->fetch_assoc()) {
    if ($data_depo['status'] == "Pending") {
        $label = "warning";
    } else if ($data_depo['status'] == "Error") {
        $label = "danger";     
    } else if ($data_depo['status'] == "Success") {
        $label = "success";    
    }
?>
                                        <tr>
                                            <td><?php echo $data_depo['kode_deposit']; ?></td>
                                            <td><?php echo tanggal_indo($data_depo['date']); ?>, <?php echo $data_depo['time']; ?></td>
                                    <td><?php echo $data_depo['provider']; ?></td>
                                    
                                    <td>Rp <?php echo number_format($data_depo['jumlah_transfer'],0,',','.'); ?></td>
                                    <td>Rp <?php echo number_format($data_depo['get_saldo'],0,',','.'); ?></td>
                                    <td><?php echo $data_depo['status']; ?></td>
                                    <td align="center">
                                        <a href="<?php echo $config['web']['url'] ?>deposit-balance/invoice?kode_deposit=<?php echo $data_depo['kode_deposit']; ?>" class="btn btn-primary btn-elevate btn-circle btn-icon"><i data-feather="credit-card"></i></a>
                                    </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>





<?php
require '../lib/footer.php';
?>