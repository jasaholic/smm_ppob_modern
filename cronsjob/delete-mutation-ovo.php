<?php
   require_once("../config.php");

$CallDB = $conn->query("SELECT * FROM mutasi_ovo WHERE provider = 'OVO'");

if (mysqli_num_rows($CallDB) == 0) {
	die("Data Mutasi OVO Tidak Ditemukan.");
} else {
	while($ThisData = $CallDB->fetch_assoc()) {
		$Provider = $ThisData['provider'];
		if ($conn->query("DELETE FROM mutasi_ovo WHERE provider = '$Provider'") == true) {
			echo "Data Mutasi OVO Berhasil Di Hapus.<br />";
    	} else {
			echo "Gagal Menampilkan Data Mutasi OVO.<br />";
		}
	}
}
?>