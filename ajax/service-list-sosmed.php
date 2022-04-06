<?php
require("../config.php");

if (isset($_POST['kategori'])) {
	$post_kategori = $conn->real_escape_string(filter($_POST['kategori']));
	$cek_layanan = $conn->query("SELECT * FROM layanan_sosmed WHERE kategori = '$post_kategori'");
	if (mysqli_num_rows($cek_layanan) != 0) {
	?>

<div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Kategori</th>
                                            <th>Layanan</th>
                                            <th>Harga</th>
                                            <th>API</th>
                                            <th>Min</th>
                                            <th>Max</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                            while ($data_layanan = mysqli_fetch_assoc($cek_layanan)) {
                            if($data_layanan['status'] == "Aktif") {
                                $label = "success";
                            } else if($data_layanan['status'] == "Tidak Aktif") {
                                $label = "danger";
                            }
                            ?>
                                        <tr>
                                            <th><?php echo $data_layanan['service_id']; ?></th>
                                            <td><?php echo $data_layanan['kategori']; ?></td>
                                            <td><?php echo $data_layanan['layanan']; ?></td>
                                            <td><sup>Rp</sup>.<?php echo number_format($data_layanan['harga'],0,',','.'); ?></td>
                                            <td><sup>Rp</sup>.<?php echo number_format($data_layanan['harga_api'],0,',','.'); ?></td>
                                            <td><?php echo number_format($data_layanan['min'],0,',','.'); ?></td>
                                            <td><?php echo number_format($data_layanan['max'],0,',','.'); ?></td>
                                            <td><span class="badge rounded-pill badge-light-<?php echo $label; ?> me-1"><?php echo $data_layanan['status']; ?></span></td>
                                        </tr>
                                        <?php
                            } 
                            ?>
                                    </tbody>
                                </table>
                            </div>





                    
<?php
} else {
?>
<div class="text-center">
<div class="alert alert-primary">Maaf, Layanan Belum Tersedia</div>
</div>
<?php
}
}