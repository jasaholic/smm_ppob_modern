<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM kategori_layanan WHERE tipe = 'Sosial Media'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Kategori Sosial Media Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		if ($conn->query("DELETE FROM kategori_layanan WHERE tipe = 'Sosial Media'") == true) {
			echo "Data Kategori Sosial Media Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Kategori Sosial Media.<br />";
		}
	}
}
?>