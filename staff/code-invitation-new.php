<?php 
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';

        if ($data_user['level'] == 'Member') {
            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Dilarang Mengakses!.');
            exit(header("Location: ".$config['web']['url']));
        }

        if (isset($_POST['buat'])) {
            $level = $conn->real_escape_string(filter($_POST['level']));
            $pin = $conn->real_escape_string(filter($_POST['pin']));

            $kode = acak_nomor(3).acak_nomor(4);

            $cek_pendaftaran = $conn->query("SELECT * FROM harga_kode_undangan WHERE level = '$level'");
            $data_pendaftaran = $cek_pendaftaran->fetch_assoc();

            $error = array();
            if (empty($level)) {
                $error ['level'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($pin)) {
                $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($pin <> $data_user['pin']) {
                $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

            if ($data_user['level'] == "Member") {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Akun Member Tidak Memiliki Izin Untuk Mengakses Fitur Ini.<script>swal("Ups Gagal!", "Akun Member Tidak Memiliki Izin Untuk Mengakses Fitur Ini.", "error");</script>');

            } else if ($data_user['saldo_top_up'] < $data_pendaftaran['harga']) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Yahh, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Buat Kode Undangan.<script>swal("Yahh Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Buat Kode Undangan.", "error");</script>');

            } else {

                    $update = $conn->query("UPDATE users SET saldo_top_up = saldo_top_up-".$data_pendaftaran['harga'].", pemakaian_saldo = pemakaian_saldo + ".$data_pendaftaran['harga']." WHERE username = '$sess_username'");
                    if ($update == TRUE) {
                            $insert = $conn->query("INSERT INTO kode_undangan VALUES ('', '$level', '$sess_username', '$kode', '".$data_pendaftaran['saldo_sosmed']."', '".$data_pendaftaran['saldo_top_up']."', 'Belum Dipakai', '$date', '$time')");
                            $insert = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '".$data_pendaftaran['harga']."', 'Mengurangi Saldo Top Up Melalui Buat Kode Undangan Baru Dengan Kode Undangan : $kode', '$date', '$time')");
                        if ($insert == TRUE) {
                            $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Kode Undangan Berhasil Dibuat.');
                        } else {
                            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                        }
                    }
                }
            }
        }

        require("../lib/header.php");

?>
<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                
            </div>
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Riwayat</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>waktu</th>
                                            <th>Kode</th>
                                            <th>Level</th>
                                            <th>Saldo</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM kode_undangan WHERE kode LIKE '%$cari_aksi%' AND uplink = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM kode_undangan WHERE uplink = '$sess_username' ORDER BY id DESC"; // edit
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
    if ($data_riwayat['status'] == "Belum Dipakai") {
        $label = "primary";
    } else if ($data_riwayat['status'] == "Sudah Dipakai") {
        $label = "danger";
    }
?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo tanggal_indo($data_riwayat['date']); ?>, <?php echo $data_riwayat['time']; ?></td>
                                            <td><?php echo $data_riwayat['kode']; ?></td>
                                            <td><?php echo $data_riwayat['level']; ?></td>
                                            <td>Rp <?php echo number_format($data_riwayat['saldo_top_up'],0,',','.'); ?></td>
                                            <td><?php echo $data_riwayat['status']; ?></td>
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