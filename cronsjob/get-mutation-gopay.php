<?php
require_once("../config.php");
require_once("../lib/gopay-class.php");

$p = $conn->query("SELECT * FROM gopay WHERE id = 'S1'")->fetch_assoc();
$gopay = new GoPay();
$jsondec = json_decode($gopay->seeMutation($p['token'],'25'), true);

for($i = 0; $i <= count($jsondec['data']['success'])-1; $i++) {
    $shn_amount = (int)$jsondec['data']['success'][$i]['amount'];
    $shn_date = substr($jsondec['data']['success'][$i]['transacted_at'],0,19);
    $shn_desc = $jsondec['data']['success'][$i]['description'];
    $shn_send = str_replace('+','',explode("\n",$shn_desc)[1]);
    $shn_inv = $jsondec['data']['success'][$i]['transaction_ref'];
    $shn_bal = (int)$jsondec['data']['success'][$i]['effective_balance_after_transaction'];

    $cek_data = $conn->query("SELECT * FROM mutasi_gopay WHERE invoice = '$shn_inv'");
    $data_gopay = mysqli_fetch_assoc($cek_data);
    $cek_mutasi = $conn->query("SELECT * FROM mutasi WHERE amount = '$shn_amount'");
    $data_mutasi = mysqli_fetch_assoc($cek_mutasi);
    if($jsondec['data']['success'][$i]['type'] == 'credit') {
    if (mysqli_num_rows($cek_data) > 0) {
        echo "<br>Data Mutasi GOPAY Sudah Ada Di Database<br>";
    } else {

    $insert = $conn->query("INSERT INTO mutasi_gopay VALUES ('', '$shn_inv','$shn_amount','$shn_desc','$shn_date','UNREAD','GOPAY')");
    $insert = $conn->query("UPDATE mutasi SET status = 'Dana Sudah Masuk', status_aksi = 'Belum Dikonfirmasi' WHERE jumlah = '$shn_amount'");
    if ($insert == TRUE){
        echo "===============<br>Data Mutasi GOPAY Berhasil Di Tambahkan<br><br>Deskripsi : $shn_desc<br>Jumlah : $shn_amount<br>Tanggal & Waktu : $shn_date<br>===============<br>";
    } else {
        echo "Gagal Menampilkan Data Mutasi GOPAY.<br />";
    }
}
    } else {
        echo '<b><font color="red">GAGAL! -></font> MUTASI UANG KELUAR</b><br>';
    }
}
?>