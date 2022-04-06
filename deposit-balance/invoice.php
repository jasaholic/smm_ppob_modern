<?php
session_start();
require '../config.php';
require '../lib/session_user.php';
require '../lib/header.php';

		if (isset($_GET['kode_deposit'])) {
			$post_kode = filter($_GET['kode_deposit']);
			$cek_deposit = $conn->query("SELECT * FROM deposit WHERE kode_deposit = '$post_kode' AND username = '$sess_username'");
			$data_deposit = mysqli_fetch_assoc($cek_deposit);

			if ($data_deposit['status'] == "Pending") {
	            $label = "warning";
			} else if($data_deposit['status'] == "Error") {
	            $label = "danger";
			} else if($data_deposit['status'] == "Success") {
	            $label = "success";
			}

			if ($cek_deposit->num_rows == 0) {
	            header("Location: ".$config['web']['url']."history/deposit");
			} else {

?>

<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview">
                        <!-- Invoice -->
                        <div class="col-xl-12 col-md-8 col-12">
                            <div class="card invoice-preview-card">
                                <div class="card-body invoice-padding pb-0">
                                    <!-- Header starts -->
                                    <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                        <div>
                                            <div class="logo-wrapper">
                                                <img src="../gambar/logo-sidebar.png" height="50px">
                                                <h3 class="text-primary invoice-logo"><?php echo $data['short_title']; ?></h3>
                                            </div>
                                            <p class="card-text mb-25"><?php echo $data['lokasi']; ?></p>
                                            <p class="card-text mb-25"><?php echo $data['kode_pos']; ?></p>
                                            <p class="card-text mb-0"><?php echo $data['kontak_utama']; ?></p>
                                        </div>
                                        <div class="mt-md-0 mt-2">
                                            <h4 class="invoice-title">
                                                Invoice
                                                <span class="invoice-number">#<?php echo $data_deposit['kode_deposit']; ?></span>
                                            </h4>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Date Issued:</p>
                                                <p class="invoice-date"><?php echo tanggal_indo($data_deposit['date']); ?></p>
                                            </div>
                                            <div class="invoice-date-wrapper">
                                                <p class="invoice-date-title">Time Issued:</p>
                                                <p class="invoice-date"><?php echo $data_deposit['time']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Header ends -->
                                </div>

                                <hr class="invoice-spacing" />

                                <!-- Address and Contact starts -->
                                

                                <!-- Invoice Description starts -->
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="py-1">TIPE BANK</th>
                                                <th class="py-1">SALDO YANG DIDAPATKAN</th>
                                                <th class="py-1">JUMLAH PEMBAYARAN</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="py-1">
                                                    <p class="card-text fw-bold mb-25"><?php echo $data_deposit['provider']; ?></p>
                                                    <p class="card-text text-nowrap">
                                                        <?php echo $data_deposit['catatan']; ?>
                                                    </p>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">Rp <?php echo number_format($data_deposit['get_saldo'],0,',','.'); ?></span>
                                                </td>
                                                <td class="py-1">
                                                    <span class="fw-bold">Rp <?php echo number_format($data_deposit['jumlah_transfer'],0,',','.'); ?></span>
                                                </td>
                                                
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="card-body invoice-padding pb-0">
                                    <div class="row invoice-sales-total-wrapper">
                                        <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">
                                           <br>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                            <div class="invoice-total-wrapper">
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Status:</p>
                                                    <p class="invoice-total-amount"><?php echo $data_deposit['status']; ?></p>
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Discount:</p>
                                                    <p class="invoice-total-amount">0</p>
                                                </div>
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Tax:</p>
                                                    <p class="invoice-total-amount">0</p>
                                                </div>
                                                <hr class="my-50" />
                                                <div class="invoice-total-item">
                                                    <p class="invoice-total-title">Total:</p>
                                                    <p class="invoice-total-amount">Rp <?php echo number_format($data_deposit['jumlah_transfer'],0,',','.'); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Description ends -->

                                <hr class="invoice-spacing" />

                                <!-- Invoice Note starts -->
                                <div class="card-body invoice-padding pt-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="fw-bold">Note:</span>
                                            <span>Silahkan Lakukan Pembayaran sebelum tanggal jatuh tempo agar tidak gagal!</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Invoice Note ends -->
                            </div>
                        </div>
                        <!-- /Invoice -->
                    </div>
                </section>

                

            </div>
        </div>
    </div>
    <!-- END: Content-->



<?php 
require '../lib/footer.php';
}
} else {
	header("Location: ".$config['web']['url']."deposit/history");
}
?>