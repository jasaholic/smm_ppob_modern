<?php
   require_once("../config.php");

    $check_provider = $conn->query("SELECT * FROM provider WHERE code = 'IRVANKEDE'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

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
while($indeks < count($json_result['data'])) {

$category = $json_result['data'][$indeks]['category'];
$indeks++; 
$i++;

        $cek_kategori = $conn->query("SELECT * FROM kategori_layanan WHERE kode = '$category'");
        $data_kategori = mysqli_fetch_assoc($cek_kategori);
        if (mysqli_num_rows($cek_kategori) > 0) {
            echo "Kategori Sudah Ada Di Database => $category \n <br>";
        } else {

$insert = $conn->query("INSERT INTO kategori_layanan VALUES ('','$category','$category','Sosial Media','')"); //Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Kategori Sosial Media Berhasil Di Tambahkan<br><br>Nama Kategori : $category<br>Kode Kategori : $category<br>Tipe : Sosial Media<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Kategori Sosial Media.<br />";
}
}
}
?>