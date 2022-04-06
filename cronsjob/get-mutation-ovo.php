<?php
require_once("../config.php");
require("../lib/ovo-class.php");

$p = $conn->query("SELECT * FROM ovo WHERE id = 'S1'")->fetch_assoc();
$ovo = new OVO($p['nomor'],$p['device']);
$result = $ovo->seeMutation($p['token'],'100');

for($i = 0; $i <= count($result['data'])-1; $i++) {
    $data = $result['data'][$i];
    $invoice = $data['merchant_name'].'/'.$data['merchant_invoice'];
    $account = $data['name'];
    $amount = $data['transaction_amount'];
    $desc = $data['desc1'];
    $sender = $data['desc3'];
    $datetime = $data['transaction_date'].' '.$data['transaction_time'];

    $cek_data = $conn->query("SELECT * FROM mutasi_ovo WHERE invoice = '$invoice'");
    $data_ovo = mysqli_fetch_assoc($cek_data);
    $cek_mutasi = $conn->query("SELECT * FROM mutasi WHERE amount = '$amount'");
    $data_mutasi = mysqli_fetch_assoc($cek_mutasi);
    if($data['desc2'] == 'Transfer Masuk' OR $data['desc2'] == 'Incoming Transfer') {
    if (mysqli_num_rows($cek_data) > 0) {
        echo "<br>Data Mutasi OVO Sudah Ada Di Database<br>";
    } else {

    $insert = $conn->query("INSERT INTO mutasi_ovo VALUES ('', '$invoice','$account','$amount','$desc','$sender','$datetime','UNREAD','OVO')");
    $insert = $conn->query("UPDATE mutasi SET status = 'Dana Sudah Masuk', status_aksi = 'Belum Dikonfirmasi' WHERE jumlah = '$amount'");
    if ($insert == TRUE){
        echo "===============<br>Data Mutasi OVO Berhasil Di Tambahkan<br><br>Nama Akun : $account<br>Deskripsi : $desc<br>Jumlah : $amount<br>Tanggal & Waktu : $datetime<br>===============<br>";
    } else {
        echo "Gagal Menampilkan Data Mutasi OVO.<br />";
    }
}
    } else {
        echo '<b><font color="red">GAGAL! -></font> MUTASI UANG KELUAR</b><br>';
    }
}
?>