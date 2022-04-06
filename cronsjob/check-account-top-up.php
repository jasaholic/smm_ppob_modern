<?php
   require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'DG-PULSA'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];
    $provider = "DG-PULSA";

    $url = "https://api.digiflazz.com/v1/cek-saldo";
    $sign = md5($p_apiid.$p_apikey."depo");
    $data = array( 
        'cmd' => 'deposit',
	    'username' => $p_apiid,
	    'sign' => $sign
    );
    $header = array(
        'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    curl_close($ch);
    $json_result = json_decode($chresult, true);
    // print_r($json_result);

$indeks=0; 
$i = 1;
// get data service
while($indeks < count($json_result['data'])) {

$sisa_saldo = $json_result['data']['deposit'];
$indeks++; 
$i++;

        $cek_akun = $conn->query("SELECT * FROM cek_akun WHERE provider = 'DG-PULSA'");
        $data_akun = mysqli_fetch_assoc($cek_akun);
        if (mysqli_num_rows($cek_akun) > 0) {
        $update = $conn->query("UPDATE cek_akun SET saldo = '$sisa_saldo', date = '$date', time = '$time' WHERE provider = 'DG-PULSA'");
            echo "<br>Data Informasi Akun Top Up Sudah Ada Di Database.<br>";
            echo ($update == true) ? '<font color="green">Update Sukses!</font>' : '<font color="red">Update Gagal: '.mysqli_error($conn).'</font><br />';
        } else {
            
$insert = $conn->query("INSERT INTO cek_akun VALUES ('','$sisa_saldo','$date','$time','TOP UP','DG-PULSA')");//Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Berhasil Menampilkan Data Informasi Akun Top Up<br><br>Sisa Saldo : $sisa_saldo<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Informasi Akun Top Up.<br />";
    
}
}
}
?>