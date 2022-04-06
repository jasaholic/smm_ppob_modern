<?php
session_start();
require("../config.php");
require '../lib/session_user.php';

        if (isset($_POST['buat'])) {
            require '../lib/session_login.php';
                $post_metode = $conn->real_escape_string(filter($_POST['radio7']));
            $post_tipe = $conn->real_escape_string(filter($_POST['tipe']));
            $post_provider = $conn->real_escape_string(filter($_POST['provider']));
            $post_pembayaran = $conn->real_escape_string(filter($_POST['pembayaran']));
            $post_pengirim = $conn->real_escape_string(filter($_POST['pengirim']));
            $post_jumlah = $conn->real_escape_string(filter($_POST['jumlah']));
            $post_pin = $conn->real_escape_string(filter($_POST['pin']));

            $cek_metod = $conn->query("SELECT * FROM metode_depo WHERE id = '$post_provider' AND status = 'Aktif' ORDER BY id ASC");
            $data_metod = $cek_metod->fetch_assoc();
            $cek_metod_rows = mysqli_num_rows($cek_metod);

            $cek_depo = $conn->query("SELECT * FROM deposit WHERE username = '$sess_username' AND status = 'Pending'");
            $data_depo = $cek_depo->fetch_assoc();
            $count_depo = mysqli_num_rows($cek_depo);

            $array = array_map('intval', str_split($post_pengirim));
            $data_1 = $array[0];
            $data_2 = $array[1];
        
            if($data_1 == 6 and $data_2 == 2){
            $pengirim = $post_pengirim;
            }else if($data_1 == 0){
            $pengirim = preg_replace('/0/', '62', $post_pengirim, 1);
            } else {
            $pengirim = '62'.$post_pengirim;
            }
            if ($post_metode == "saldo_sosmed"){
                $post_metodee = "Saldo Sosial Media";
            } else if($post_metode == "saldo_top_up"){
                $post_metodee = "Saldo Top Up";
            }

            $tipe_saldo = "saldo_top_up";
            $kode = acak_nomor(3).acak_nomor(3);

            $error = array();
            if (empty($post_metode)) {
                $error ['radio7'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_tipe)) {
                $error ['tipe'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_provider)) {
                $error ['provider'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_pembayaran)) {
                $error ['pembayaran'] = '*Wajib Pilih Salah Satu.';
            }
            if (empty($post_jumlah)) {
                $error ['jumlah'] = '*Tidak Boleh Kosong.';
            }
            if ($post_tipe == 'Transfer Pulsa') {
            if (empty($post_pengirim)) {
                $error ['pengirim'] = '*Tidak Boleh Kosong';
            }
            }
            if (empty($post_pin)) {
                $error ['pin'] = '*Tidak Boleh Kosong.';
            } else if ($post_pin <> $data_user['pin']) {
                $error ['pin'] = '*PIN Yang Kamu Masukkan Salah.';
        } else {
            
            if ($cek_metod_rows == 0 && $post_provider != 'Payment Gateway') {
                
                    $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Tipe Pembayaran Tidak Tersedia.<script>swal("Ups Gagal!", "Tipe Pembayaran Tidak Tersedia.", "error");</script>');
                
            } else if ($count_depo >= 1) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Kamu Masih Memiliki Isi Saldo Yang Berstatus Pending.<script>swal("Ups Gagal!", "Kamu Masih Memiliki Isi Saldo Berstatus Pending.", "error");</script>');
            } else if ($post_jumlah < $data_metod['minimal']) {
                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Minimal Isi Saldo Adalah Rp '.$data_metod['minimal'].'.<script>swal("Ups Gagal!", "Minimal Isi Saldo Adalah Rp '.$data_metod['minimal'].'.", "error");</script>');
            } else {

                if ($data_metod['tipe'] == 'Transfer Bank') {
                    $post_jumlah = $post_jumlah + rand(000,000);
                }
                if($post_provider != 'Payment Gateway'){
                    $get_saldo = $post_jumlah * $data_metod['rate'];
                    $saldo = number_format($get_saldo,0,',','.');
                    $insert = $conn->query("INSERT INTO deposit VALUES ('', '$kode', '$sess_username', '".$data_metod['tipe']."', '".$data_metod['provider']."', '$pengirim', '".$data_metod['tujuan']." ".$data_metod['nama_penerima']."', '".$data_metod['catatan']."','$post_jumlah', '$get_saldo', '$tipe_saldo', '".$data_metod['jenis']."', 'Pending', '$date', '$time','$post_pembayaran','','','','')");
                    $insert = $conn->query("INSERT INTO mutasi VALUES ('', '$kode', '$sess_username', '".$data_metod['tipe']."', '".$data_metod['provider']."', '$post_jumlah', '$get_saldo', 'Dana Belum Masuk', 'Belum Dikonfirmasi', '$date', '$time')");
                    if ($insert == TRUE) {
                        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Kamu Berhasil Buat Isi '.$post_metodee.'.<script>swal("Berhasil!", "Kamu Berhasil Buat Isi Saldo.", "success");</script>');
                    } else {
                       
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
                    }
                }else{
                    // $teks = "INSERT INTO deposit VALUES ('', '$kode', '$sess_username', '".$post_tipe."', '".$post_provider."', '$pengirim', '', '', '','$post_jumlah', '$post_jumlah', '$tipe_saldo', 'Otomatis', 'Pending', '$date', '$time','$post_pembayaran')";
                    $insert = $conn->query("INSERT INTO deposit VALUES ('', '$kode', '$sess_username', '".$post_tipe."', '".$post_provider."', '$pengirim',  '', '','$post_jumlah', '$post_jumlah', '$tipe_saldo', 'Otomatis', 'Pending', '$date', '$time','$post_pembayaran','','','','')");
                    if ($insert == TRUE) {
                        $last_id = $conn->insert_id;
                        // Tripay Action
                        $order_id = $last_id;
                        $payment_method = $post_pembayaran;
                        
                        $apiKey = 'JxBV44hoFRP9MBOLcQ58zv1e3RdD7quTs3i8ihlj';
                        $privateKey = 'Umalp-tIAQD-zj1ZQ-0gSJ1-Q3iFE';
                        $merchantCode = 'T5581';
                        $merchantRef = $last_id;
                        $amount = $post_jumlah;
                        // $amount = $transaksi['amount_to_pay'];
                        $q_user = $conn->query("SELECT * FROM users WHERE username = '$sess_username'");
                        $user = mysqli_fetch_assoc($q_user);
                        $data = [
                        'method'            => $payment_method,
                        'merchant_ref'      => $merchantRef,
                        'amount'            => $amount,
                        'customer_name'     => $user['nama'],
                        'customer_email'    => $user['email'],
                        'customer_phone'    => $user['no_hp'],
                        'order_items'       => [
                            [
                            'sku'       => $order_id,
                            'name'      => 'Topup Saldo Okepedia',
                            'price'     => $amount,
                            'quantity'  => 1
                            ]
                        ],
                        'callback_url'      => 'https://okepedia.my.id/cronsjob/callback_tripay.php',
                        'return_url'        => 'https://okepedia.my.id/cronsjob/callback_tripay.php',
                        'expired_time'      => (time()+(24*60*60)), // 24 jam
                        'signature'         => hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey)
                        ];
                
                        $curl = curl_init();
                
                        curl_setopt_array($curl, array(
                        CURLOPT_FRESH_CONNECT     => true,
                        CURLOPT_URL               => "https://tripay.co.id/api/transaction/create",
                        CURLOPT_RETURNTRANSFER    => true,
                        CURLOPT_HEADER            => false,
                        CURLOPT_HTTPHEADER        => array(
                            "Authorization: Bearer ".$apiKey
                        ),
                        CURLOPT_FAILONERROR       => false,
                        CURLOPT_POST              => true,
                        CURLOPT_POSTFIELDS        => http_build_query($data)
                        ));
                
                        $response = curl_exec($curl);
                        $err = curl_error($curl);
                
                        curl_close($curl);
                        if(!empty($err)){
                            echo json_encode("Data Not Availavble");
                        }else{
                            $data_return = [];
                            $return = json_decode($response,true);
                            if(!empty($return['data'])){
                                $data_payment = $return['data'];
                                // Update Payment Information
                                $amount = $data_payment['amount'];
                                $fee = $data_payment['fee'];
                                $checkout_url = $data_payment['checkout_url'];
                                $payment_method = $data_payment['payment_method'];
                                $payment_name = $data_payment['payment_name'];
                                
                                $conn->query("UPDATE deposit SET amount = '$amount',fee = '$fee',checkout_url = '$checkout_url',payment_method = '$payment_method',payment_name = '$payment_name' WHERE id ='$order_id'");
                                $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Sip! Kamu Berhasil Buat Isi '.$post_metodee.'.<script>swal("Berhasil!", "Kamu Berhasil Buat Isi Saldo.", "success");</script>');
                               
                            }else{
                                $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Gagal koneksi ke API '.$post_metodee.'.<script>swal("Berhasil!", "Gagal koneksi ke API.", "danger");</script>');
                            }
                            
                        }
                        
                    } else {
                        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan berat.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan berat.", "error");</script>');
                    }
                }
                    
                }
            }
        }

        require("../lib/header.php");

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
                            <h2 class="content-header-title float-start mb-0">Deposit</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Deposit Saldo</a>
                                    </li>
                                    
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <!-- Basic Horizontal form layout section start -->
                <?php
                    if (isset($_SESSION['hasil'])) {
                    ?>
                <div class="toast-container">
                                        <div class="toast show basic-toast position-fixed top-0 end-0 m-2" role="alert" aria-live="assertive" aria-atomic="true" >
                                            <div class="toast-header">
                                                <img src="../gambar/logo-sidebar.png" class="me-1" alt="Toast image" height="25" />
                                                <strong class="me-auto">Pemberitahuan!</strong>
                                                <small class="text-muted">Sekarang</small>
                                                <button type="button" class="ms-1 btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                            </div>
                                            <div class="toast-body" id="respon"><?php echo $_SESSION['hasil']['pesan'] ?></div>
                                        </div>
                                    </div>
                                    <?php
                    unset($_SESSION['hasil']);
                    }
                    ?>
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Deposit</h4>
                                </div>
                                <div class="card-body">
                                    <form class="form form-horizontal" method="POST">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="first-name">Tipe</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="tipe" id="tipe">
                                        <option value="0">Pilih Salah Satu</option>
                                        <option value="Transfer Bank">Transfer Bank</option>
                                    </select>
                                    <span class="form-text text-muted"><?php echo ($error['tipe']) ? $error['tipe'] : '';?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="email-id">Provider Pembayaran</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="provider" id="provider">
                                        <option value="0">Pilih Salah Satu</option>
                                    </select>
                                    <span class="form-text text-muted"><?php echo ($error['provider']) ? $error['provider'] : '';?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="contact-info">Metoder Pembayaran</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="pembayaran" id="pembayaran">
                                        <option value="0">Pilih Salah Satu</option>
                                    </select>
                                    <span class="form-text text-muted"><?php echo ($error['pembayaran']) ? $error['pembayaran'] : '';?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12" id="transfer_pulsa">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="password">Pengirim</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" minlength="10" maxlength="14"  class="form-control" placeholder="08xx" value="<?php echo $post_pengirim; ?>" name="pengirim" />
                                                    </div>
                                                    <span class="form-text text-muted"><?php echo ($error['pengirim']) ? $error['pengirim'] : '';?></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="password">Jumlah</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" id="jumlah" class="form-control" name="jumlah" placeholder="Rp.10.000" />
                                                    </div>
                                                    <span class="form-text text-muted"><?php echo ($error['jumlah']) ? $error['jumlah'] : '';?></span>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="password">Saldo Masuk</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="saldo" value="0" id="total" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-1 row">
                                                    <div class="col-sm-3">
                                                        <label class="col-form-label" for="password">PIN Transaksi</label>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="number"  class="form-control" name="pin" placeholder="PIN Transaksi" />
                                                    </div>
                                                    <span class="form-text text-muted"><?php echo ($error['pin']) ? $error['pin'] : '';?></span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-9 offset-sm-3">
                                                <button type="submit" name="buat" class="btn btn-primary me-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Informasi</h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Isi disini Informasi Deposit
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Basic Horizontal form layout section end -->

                <!-- Basic Vertical form layout section start -->
                
                <!-- Basic Floating Label Form section end -->

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <?php
require ("../lib/footer.php");
?>