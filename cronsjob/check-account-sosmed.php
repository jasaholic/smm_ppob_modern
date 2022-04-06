<?php
   require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider WHERE code = 'IRVANKEDE'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apikey = $data_provider['api_key'];
    $p_apiid = $data_provider['api_id'];

    $api_postdata = "api_id=$p_apiid&api_key=$p_apikey";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.irvankede-smm.co.id/profile");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $chresult = curl_exec($ch);
    curl_close($ch);
    $json_result = json_decode($chresult, true);

$indeks=0; 
$i = 1;
// get data service
while($indeks < count($json_result['data'])) {

$nama_pengguna = $json_result['data']['username'];
$sisa_saldo = $json_result['data']['balance'];
$indeks++; 
$i++;

        $cek_akun = $conn->query("SELECT * FROM cek_akun WHERE provider = 'IRVANKEDE'");
        $data_akun = mysqli_fetch_assoc($cek_akun);
        if (mysqli_num_rows($cek_akun) > 0) {
        $update = $conn->query("UPDATE cek_akun SET saldo = '$sisa_saldo', date = '$date', time = '$time' WHERE provider = 'IRVANKEDE'");
            echo "<br>Data Informasi Akun Sosial Media Sudah Ada Di Database.<br>";
            echo ($update == true) ? '<font color="green">Update Sukses!</font>' : '<font color="red">Update Gagal: '.mysqli_error($conn).'</font><br />';
        } else {

$insert = $conn->query("INSERT INTO cek_akun VALUES ('','$sisa_saldo','$date','$time','SOSIAL MEDIA','IRVANKEDE')");//Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Berhasil Menampilkan Data Informasi Akun Sosial Media<br><br>Nama Pengguna : $nama_pengguna<br>Saldo : $sisa_saldo<br>Tipe : SOSIAL MEDIA<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Informasi Akun Sosial Media.<br />";
    
}
}
}
?>