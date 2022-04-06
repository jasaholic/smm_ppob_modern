<?php
require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider WHERE code = 'IRVANKEDE'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $cek_harga_website = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'WEBSITE' AND tipe = 'Sosial Media'");
    $data_harga_website = mysqli_fetch_assoc($cek_harga_website);

    $cek_harga_api = $conn->query("SELECT * FROM setting_harga_untung WHERE kategori = 'API' AND tipe = 'Sosial Media'");
    $data_harga_api = mysqli_fetch_assoc($cek_harga_api);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

    $harga_website = $data_harga_website['harga'];
    $harga_api = $data_harga_api['harga'];

    $api_postdata = "api_id=$p_apiid&api_key=$p_apikey";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.irvankede-smm.co.id/services");
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
while($indeks < count($json_result['data'])){

$sid = $json_result['data'][$indeks]['id'];
$category = $json_result['data'][$indeks]['category'];
$service = $json_result['data'][$indeks]['name'];
$min_order = $json_result['data'][$indeks]['min'];
$max_order = $json_result['data'][$indeks]['max'];
$price = $json_result['data'][$indeks]['price'];
$note = $json_result['data'][$indeks]['note'];
$indeks++; 
$i++;
// end get data service 
// setting price 
$rate = $price; 
$rate_asli = $rate + $harga_website; //setting penambahan harga web

$rate_api = $price; 
$rate_api_asli = $rate_api + $harga_api; //setting penambahan harga api
// setting price

$service2 = strtr($service, array(
	'IRVANKEDE' => 'SOLUSIMEDIA',
	'IRVANKEDE' => 'SOLUSIMEDIA',
	'MP' => 'SM',
));

		$check_services = $conn->query("SELECT * FROM layanan_sosmed WHERE service_id = '$sid' AND provider = 'IRVANKEDE'");
        $data_services = mysqli_fetch_assoc($check_services);
        if (mysqli_num_rows($check_services) > 0) {
        $update = $conn->query("UPDATE layanan_sosmed SET harga = '$rate_asli', harga_api = '$rate_api_asli' WHERE service_id = '$sid'");
            echo "<br>Layanan Sudah Ada Di Database => $service2 | $sid \n <br />";
            echo ($update == true) ? '<font color="green">Update Sukses!</font><br />Harga API: '.$rate_api_asli.'<br />Harga WEB: '.$rate_asli.'<br /><br />' : '<font color="red">Update Gagal: '.mysqli_error($conn).'</font><br />';
        } else {

$insert = $conn->query("INSERT INTO layanan_sosmed VALUES ('','$sid','$category','$service2','$note','$min_order','$max_order','$rate_asli','$rate_api_asli','Aktif','$sid','IRVANKEDE', 'SOSIAL MEDIA')");//Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Layanan Sosmed Berhasil Di Tambahkan<br><br>ID Layanan : $sid<br>Nama Layanan : $service2<br>Kategori : $category<br>Minimal Pesan : $min_order<br>Maksimal Pesan : $max_order<br>Harga/1000 : $rate_asli<br>Keterangan : $note<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Layanan Sosmed.<br />";

}
}
}
?>