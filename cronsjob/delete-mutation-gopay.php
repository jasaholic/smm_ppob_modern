<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM mutasi_gopay WHERE provider = 'GOPAY'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Mutasi OVO Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM mutasi_gopay WHERE provider = '$Provider'") == true) {
			echo "Data Mutasi GOPAY Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Mutasi GOPAY.<br />";
		}
	}
}
?>