<?php
session_start();
require '../config.php';
require '../lib/header.php';
?>
<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-start mb-0">Page</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="../">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active">Top User
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <!-- Basic Tables start -->
                <div class="row" id="basic-table">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top 10 Pesanan</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $no = 1;
                                $top_pesanan = $conn->query("SELECT A.* FROM top_users A INNER JOIN (SELECT username,max(jumlah) as maxRev FROM top_users GROUP BY username) B on A.username=B.username and A.jumlah=B.maxRev ORDER BY jumlah DESC LIMIT 10");
                                
                                while ($data_pesanan = mysqli_fetch_assoc($top_pesanan)) {
                                $userstr = "-".strlen($data_pesanan['username']);
                                $usersensor = substr($data_pesanan['username'],$slider_userstr,-4); 
                                if ($no == 1) {
                                    $label = "success";
                                } else if ($no == 2) {
                                    $label = "primary";
                                } else if ($no == 3) {
                                    $label = "dark";
                                } else if ($no == 4) {
                                    $label = "warning";
                                } else if ($no == 5) {
                                    $label = "danger";
                                } else {
                                    $label = "light";
                                }
                                ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <th><?php echo "".$usersensor."****"; ?></th>
                                            <th><?php echo number_format($data_pesanan['total'],0,',','.'); ?></th>
                                        </tr>
                                        <?php
                                $no++;
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top 10 Deposit</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $no = 1;
                                $top_deposit = $conn->query("SELECT SUM(deposit.get_saldo) AS tamount, count(deposit.id) AS tcount, deposit.username, users.username FROM deposit JOIN users ON deposit.username = users.username WHERE MONTH(deposit.date) = '".date('m')."' AND YEAR(deposit.date) = '".date('Y')."' AND deposit.status = 'Success' GROUP BY deposit.username ORDER BY tamount DESC LIMIT 10");
                                while ($data_deposit = mysqli_fetch_array($top_deposit)) {
                                $userstr = "-".strlen($data_deposit['username']);
                                $usersensor = substr($data_deposit['username'],$slider_userstr,-4);             
                                if ($no == 1) {
                                    $label = "success";
                                } else if ($no == 2) {
                                    $label = "primary";
                                } else if ($no == 3) {
                                    $label = "dark";
                                } else if ($no == 4) {
                                    $label = "warning";
                                } else if ($no == 5) {
                                    $label = "danger";
                                } else {
                                    $label = "light";
                                }
                                ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <th><?php echo "".$usersensor."****"; ?></th>
                                            <th>Rp <?php echo number_format($data_deposit['tamount'],0,',','.'); ?></th>
                                        </tr>
                                        <?php
                                $no++;
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><div class="col-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top 10 Layanan</h4>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Layanan</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                $no = 1;
                                $top_layanan = $conn->query("SELECT SUM(pembelian_sosmed.harga) AS tamount, count(pembelian_sosmed.id) AS tcount, pembelian_sosmed.layanan, layanan_sosmed.layanan FROM pembelian_sosmed JOIN layanan_sosmed ON pembelian_sosmed.layanan = layanan_sosmed.layanan WHERE pembelian_sosmed.status = 'Success' GROUP BY pembelian_sosmed.layanan ORDER BY tamount DESC LIMIT 10");
                                while ($data_layanan = mysqli_fetch_assoc($top_layanan)) {                              
                                if ($no == 1) {
                                    $label = "success";
                                } else if ($no == 2) {
                                    $label = "primary";
                                } else if ($no == 3) {
                                    $label = "dark";
                                } else if ($no == 4) {
                                    $label = "warning";
                                } else if ($no == 5) {
                                    $label = "danger";
                                } else {
                                    $label = "light";
                                }
                                ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <th><?php echo $data_layanan['layanan']; ?></th>
                                            <th><?php echo number_format($data_layanan['tcount'],0,',','.'); ?></th>
                                        </tr>
                                        <?php
                                $no++;
                                }
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php
require '../lib/footer.php';
?>