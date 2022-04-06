<?php 
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';

        if ($data_user['level'] == 'Member') {
            $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Dilarang Mengakses!.');
            exit(header("Location: ".$config['web']['url']));
        }

        if (isset($_POST['transfer'])) {
            $post_metode = $conn->real_escape_string(filter($_POST['radio7']));
            $tujuan = $conn->real_escape_string(filter($_POST['tujuan']));
            $jumlah = $conn->real_escape_string(filter($_POST['jumlah']));
            $pin = $conn->real_escape_string(filter($_POST['pin']));

            $cek_tujuan = $conn->query("SELECT * FROM users WHERE username = '$tujuan'");
            $cek_tujuan_rows = mysqli_num_rows($cek_tujuan);

            if ($post_metode == "saldo_top_up") {
                $post_metodee = "Saldo Top Up";
            }

            $error = array();
            if (empty($post_metode)) {
                $error ['radio7'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($tujuan)) {
                $error ['tujuan'] = '*Tidak Boleh Kosong.';
            }
            if (empty($jumlah)) {
                $error ['jumlah'] = '*Tidak Boleh Kosong.';
            }
            if (empty($pin)) {
                $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($pin <> $data_user['pin']) {
                $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
            } else {

            if ($cek_tujuan_rows == 0 ) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Nama Pengguna Tujuan Tidak Ditemukan.<script>swal("Ups Gagal!", "Nama Pengguna Tujuan Tidak Ditemukan.", "error");</script>');
            } else if ($jumlah < 5000 ) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Minimal Transfer Saldo Adalah Rp 5.000.<script>swal("Ups Gagal!", "Minimal Transfer Saldo Adalah Rp 5.000.", "error");</script>');
            } else if ($data_user['saldo_top_up'] < $jumlah ) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Transfer Saldo.<script>swal("Ups Gagal!", "Saldo Top Up Kamu Tidak Mencukupi Untuk Melakukan Transfer Saldo.", "error");</script>');
            } else {

                        $check_top = $conn->query("SELECT * FROM top_depo WHERE username = '$tujuan'");
                        $data_top = mysqli_fetch_assoc($check_top);
                    if ($conn->query("UPDATE users set $post_metode = $post_metode + $jumlah WHERE username = '$tujuan'") == true) {
                        $conn->query("UPDATE users set saldo_top_up = saldo_top_up - $jumlah, pemakaian_saldo = pemakaian_saldo + $jumlah  WHERE username = '$sess_username'");
                        $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$sess_username', 'Saldo', 'Pengurangan Saldo', '$jumlah', 'Mengurangi Saldo Top Up Melalui Transfer Saldo Ke $tujuan Sejumlah Rp $jumlah', '$date', '$time')");   
                        $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$tujuan', 'Saldo', 'Penambahan Saldo', '$jumlah', 'Mendapatkan $post_metodee Melalui Transfer Saldo Dari $sess_username Sejumlah Rp $jumlah ', '$date', '$time')");
                        $conn->query("INSERT INTO riwayat_transfer VALUES ('', '$post_metodee', '$sess_username', '$tujuan', '$jumlah','$date', '$time')");
                        if (mysqli_num_rows($check_top) == 0) {
                            $insert_topup = $conn->query("INSERT INTO top_depo VALUES ('', 'Deposit', '$tujuan', '$jumlah', '1')");
                        } else {
                            $insert_topup = $conn->query("UPDATE top_depo SET jumlah = ".$data_top['jumlah']."+$jumlah, total = ".$data_top['total']."+1 WHERE username = '$tujuan' AND method = 'Deposit'");
                        }
                        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip, Berhasil Transfer Saldo.');
                    } else {
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                    }
                }                   
            }
        }

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
                            <h2 class="content-header-title float-start mb-0">Staff</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Tambah Saldo</a>
                                    </li>
                                    <li class="breadcrumb-item active"><a href="#">Member</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Kirim Saldo</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="first-name">Pilihan</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                         <input type="radio" name="radio7" id="metod" value="saldo_top_up"><label class="col-form-label" for="metod"> Tambahkan Saldo</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="email-id">Tujuan</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="username" class="form-control" name="tujuan" placeholder="Tujuan" value="<?php echo $tujuan; ?>" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="contact-info">Jumlah</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number"  class="form-control" name="jumlah" placeholder="Jumlah Transfer" value="<?php echo $jumlah; ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="password">PIN</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="password"  class="form-control" name="pin" placeholder="PIN" />
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" name="transfer" class="btn btn-primary me-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Riwayat</h4>
                                </div>
                                <div class="card-body">
                                <div class="row">
                                    <form method="POST">
                                        <div class="col-md-12 col-12 mb-1">
                                            <div class="input-group">
                                                <input type="text" name="aksi" class="form-control" placeholder="Cari Username" aria-describedby="button-addon2" />
                                                <button class="btn btn-outline-primary"  type="submit"><i data-feather="search"></i> Cari</button>
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                 <div class="table-responsive">
                                 <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>
                                            <th>Tipe</th>
                                            <th>Penerima</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
// start paging config
$no=1;
if (isset($_GET['tampil'])) {
    $cari_urut = $conn->real_escape_string(filter($_GET['tampil']));
    $cari_aksi = $conn->real_escape_string(filter($_GET['aksi']));

    $cek_riwayat = "SELECT * FROM riwayat_transfer WHERE penerima LIKE '%$cari_aksi%' AND pengirim = '$sess_username' ORDER BY id DESC"; // edit
} else {
    $cek_riwayat = "SELECT * FROM riwayat_transfer WHERE pengirim = '$sess_username' ORDER BY id DESC"; // edit
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
?>
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><?php echo tanggal_indo($data_riwayat['date']); ?>, <?php echo $data_riwayat['time']; ?></td>
                                    <td><span class="badge badge-primary"><?php echo $data_riwayat['tipe']; ?></span></td>
                                    <td><span class="badge badge-success"><?php echo $data_riwayat['penerima']; ?></span></td>
                                    <td><span class="badge badge-warning">Rp <?php echo number_format($data_riwayat['jumlah'],0,',','.'); ?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                                </div>
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