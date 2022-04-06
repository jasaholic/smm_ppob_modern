<?php
   require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider_pulsa WHERE code = 'DG-PULSA'");
    $data_provider = mysqli_fetch_assoc($check_provider);
    
    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

    $url = "https://api.digiflazz.com/v1/price-list";
    $sign = md5("$p_apiid+$p_apikey+pricelist");

    $data = array( 
	    'username' => $p_apiid,
	    'sign' => $sign
    );
    $header = array(
    'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    // echo $response;
    // die;
    $result = json_decode($response);
    // print_r($result);

$indeks=0; 
$i = 1;
// get data service
foreach($result->data as $data) {

$category = $data->brand;
$type = $data->category;
$indeks++; 
$i++;
// end get data service 

		//INSERT LAYANAN
		$type2 = strtr($type, array(
			'Paket SMS & Telpon' => 'Paket SMS Telpon',
			'China TOPUP' => 'Pulsa Internasional',
			'Malaysia TOPUP' => 'Pulsa Internasional',
			'Philippines TOPUP' => 'Pulsa Internasional',
			'Singapore TOPUP' => 'Pulsa Internasional',
			'Thailand TOPUP' => 'Pulsa Internasional',
			'Vietnam TOPUP' => 'Pulsa Internasional',
		));

	    $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE kode = '$type2 $category' AND server = '$type2'");
        $data_services = mysqli_fetch_assoc($cek_kategori);
        if (mysqli_num_rows($cek_kategori) > 0) {
            echo "Kategori Sudah Ada Di Database => $type2 $category \n <br>";
        } else {

$insert = $conn->query("INSERT INTO kategori_layanan VALUES ('','$type2 $category','$type2 $category','Top Up','$type2')"); //Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Kategori Top Up Berhasil Di Tambahkan<br><br>Nama Kategori : $category<br>Kode Kategori : $type2 $category<br>Server : $type2<br>Tipe : Top Up<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Kategori Top Up.<br />";
}
}
}
?>