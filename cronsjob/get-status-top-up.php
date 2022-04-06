<?php
	require("../config.php");

	$check_order = $conn->query("SELECT * FROM pembelian_pulsa WHERE status IN ('Pending')");

	if (mysqli_num_rows($check_order) == 0) {
	  die("Pesanan Berstatus Pending Tidak Ditemukan.");
	} else {
	  while($data_order = mysqli_fetch_assoc($check_order)) {
	    $o_oid = $data_order['oid'];
	    $o_poid = $data_order['provider_oid'];
	    $o_provider = $data_order['provider'];
	    $username = $data_order['user'];
	    $koin = $data_order['koin'];
	    $layanan = $data_order['layanan'];
	    $provider = $data_order['provider'];
	  if ($o_provider == "MANUAL") {
	    echo "Pesanan Manual<br />";
	  } else {

        $getService = $conn->query("SELECT * FROM layanan_pulsa WHERE layanan = '$layanan' AND provider = '$provider'");
        $getDataService = mysqli_fetch_assoc($getService);

		$check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'DG-PULSA'");
		$data_provider = mysqli_fetch_assoc($check_provider);

		$p_apikey = $data_provider['api_key'];
		$p_api_id = $data_provider['api_id'];

        $url = "https://api.digiflazz.com/v1/transaction";
        $sign = md5("$p_api_id"."$p_apikey".$o_oid);

        $header = array(
            'Content-Type: application/json',
        );

        $data = array( 
            'command' => 'status-pasca',
            'username' => $p_api_id,
            'buyer_sku_code' => $getDataService['service_id'],
            'customer_no' => $data_order['target'],
            'ref_id' => $o_oid,
            'sign' => $sign
        );
        // echo json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        // echo $result;

        $sn = $result['data']['sn'];
        $ht_status = $result['data']['status'];

		if ($ht_status == "Gagal") {
			$status = "Error";
		} else if ($ht_status == "Sukses") {
			$status = "Success";
		} else if ($ht_status == "Pending") {
			$status = "Pending";
		}

	    if ($status == "Success") {
	      $update_order = $conn->query("INSERT INTO riwayat_saldo_koin VALUES ('', '$username', 'Koin', 'Penambahan Koin', '$koin', 'Mendapatkan Koin Melalui Pemesanan $layanan Dengan Kode Pesanan : $o_oid', '$date', '$time')");
	      $update_order = $conn->query("UPDATE users SET koin = koin+$koin WHERE username = '$username'");
	    }
	    $update_order = $conn->query("UPDATE semua_pembelian SET status = '$status' WHERE id_pesan = '$o_oid'");
	    $update_order = $conn->query("UPDATE pembelian_pulsa SET status = '$status', keterangan = '$sn' WHERE oid = '$o_oid'");
	    if ($update_order == TRUE) {
	      echo "===============<br>Berhasil Menampilkan Data Status Top Up<br><br>ID Pesanan : $o_oid<br>Keterangan : $sn<br>Status : $status<br>===============<br>";
	    } else {
	      echo "Gagal Menampilkan Data Status Top Up.<br />";
	    }
	  }
	}
  }
?>