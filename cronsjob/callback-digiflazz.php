<?php
require '../config.php';

$get = file_get_contents('php://input');
$header = getallheaders();

function DFStatus($x) {
    if($x == 'Transaksi Pending') $str = 'Pending';
    if($x == 'Transaksi Gagal') $str = 'Error';
    if($x == 'Transaksi Sukses') $str = 'Success';
    return (!$str) ? 'Pending' : $str;
}

if(isset($header['x-digiflazz-event']) && isset($header['x-digiflazz-delivery']) && isset($header['x-hub-signature']) && in_array($header['User-Agent'],['Digiflazz-Hookshot','DigiFlazz-Pasca-Hookshot'])) {
    $array = json_decode($get, true)['data'];
    $json = json_encode($array);
    
    $status = DFStatus($array['message']);
    $trxid = $array['trx_id']; // ID Transaksi DigiFlazz
    $refid = $array['ref_id']; // ID Transaksi dari Panel
    $note = $array['sn'];
    $last = $array['buyer_last_saldo'];

    $format = $refid.' -> '.$array['message'].'<br>'.$note;
    print $format;

	$check_order = $conn->query("SELECT * FROM pembelian_pulsa WHERE status IN ('Pending')");
	$data_order = mysqli_fetch_assoc($check_order);

	$o_oid = $data_order['oid'];
	$username = $data_order['user'];
    $koin = $data_order['koin'];
    $layanan = $data_order['layanan'];

    if ($status == "Success") {
        $update = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$username', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : $o_oid', '$date', '$time')");
        $update = $conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$username'");
    }
    if ($conn->query("SELECT * FROM pembelian_pulsa WHERE oid = '$refid' AND status = 'Pending'")->num_rows == 1) {
        $conn->query("UPDATE semua_pembelian SET status = '$status' WHERE id_pesan = '$refid',keterangan = '$note' WHERE oid = '$refid'");
        $conn->query("UPDATE pembelian_pulsa SET status = '$status', keterangan = '$note' WHERE oid = '$refid'");
    }
} else {
    print 'Access Denied!';
}