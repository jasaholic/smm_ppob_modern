
<div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">API PPOB</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">Layanan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">Pesanan</a>
                                        </li>
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" id="about-tab" data-bs-toggle="tab" href="#about" aria-controls="about" role="tab" aria-selected="false">Status</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                    <th width="50%">Parameter</th>
                    <th>Keterangan</th>
                </tr>
                <tr>
                    <td>api_key</td>
                    <td>API Key Kamu</td>
                </tr>
                <tr>
                    <td>action</td>
                    <td>layanan</td>
                </tr>
                                                        <tr>
                                                            <td>URL</td>
                                                            <td><?php echo $config['web']['url'] ?>api/top-up</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="50%">Respon Sukses</th>
                        <th>Respon Gagal</th>
                    </tr>
                    <tr>
                        <td>
        <pre>
        {
            "status": true,
            "data": [
                {
                    "sid": "1",
                    "operator": "TELKOMSEL",
                    "layanan": "TELKOMSEL 5000",
                    "harga": "5443",
                    "tipe": "PULSA",
                    "status": "Normal"
                },
                {
                    "sid": "2",
                    "operator": "TELKOMSEL",
                    "layanan": "TELKOMSEL 10000",
                    "harga": "10500",
                    "tipe": "PULSA",
                    "status": "Gangguan"
                },
            ]
        }
        </pre>
                        </td>
                        <td>
        <pre>
        {
            "status": false,
            "data": {
                "pesan": "API Key Salah"
            }
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
            <li>Permintaan Tidak Sesuai</li>
            <li>API Key Salah</li>
        </ul>
                        </td>
                    </tr>
                </table>
            </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                                            <div class="card">
                                                <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="50%">Parameter</th>
                    <th>Keterangan</th>
                </tr>
                <tr>
                    <td>api_key</td>
                    <td>API Key Kamu</td>
                </tr>
                <tr>
                    <td>action</td>
                    <td>pemesanan</td>
                </tr>
                <tr>
                    <td>layanan</td>
                    <td>ID Layanan, Dapat Dilihat Di <a href="<?php echo $config['web']['url'] ?>price-list/top-up" target="blank">Daftar Layanan</a></td>
                </tr>
                <tr>
                    <td>target</td>
                    <td>Target Yang Dibutuhkan Sesuai Layanan, Seperti Nomor HP, ID Game, No Meter</td>
                </tr>
                <tr>
                    <td>Url</td>
                    <td><?php echo $config['web']['url'] ?>api/top-up</td>
                </tr>
            </table>
        </div>
                                            </div>
                                            <div>
                                                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="50%">Respon Sukses</th>
                        <th>Respon Gagal</th>
                    </tr>
                    <tr>
                        <td>
        <pre>
        {
            "status": true,
            "data": {
                "id": "12345"
            }
        }
        </pre>
                        </td>
                        <td>
       <pre>
            {
            "status": false,
            "data": {
                "pesan": "Saldo Kamu Tidak Mencukupi"
            }
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
            <li>Permintaan Tidak Sesuai</li>
            <li>API Key Salah</li>
            <li>Layanan Tidak Ditemukan</li>
            <li>Saldo Kamu Tidak Mencukupi</li>
            <li>Layanan Tidak Tersedia</li>
        </ul>
                        </td>
                    </tr>
                </table>
            </div>
                                            </div>
                                        </div>
                                        
                                        <div class="tab-pane" id="about" aria-labelledby="about-tab" role="tabpanel">
                                            <div class="card">
                                                <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="50%">Parameter</th>
                    <th>Keterangan</th>
                </tr>
                <tr>
                    <td>api_key</td>
                    <td>API Key Kamu</td>
                </tr>
                <tr>
                    <td>action</td>
                    <td>status</td>
                </tr>
                <tr>
                    <td>id</td>
                    <td>ID Pesanan</td>
                </tr>
                <tr>
                    <td>Url</td>
                    <td><?php echo $config['web']['url'] ?>api/top-up</td>
                </tr>
            </table>
        </div>
                                            </div>
                                            <div class="card">
                                                <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th width="50%">Respon Sukses</th>
                        <th>Respon Gagal</th>
                    </tr>
                    <tr>
                        <td>
        <pre>
        {
            "status": true,
            "data": {
                    "id": "12345",
                "status": "Success",
                "catatan": "SN : 09220xxxxxxxx"
            }
        }
        </pre>
        <b>Kemungkinan Status Yang Ditampilkan:</b>
        <ul>
            <li>Pending</li>
            <li>Error</li>
            <li>Success</li>
        </ul>
                        </td>
                        <td>
        <pre>
        {
            "status": false,
            "data": {
                "pesan": "ID Pesanan Tidak Di Temukan"
            }
        }
        </pre>
        <b>Kemungkinan Pesan Yang Ditampilkan:</b>
        <ul>
            <li>Permintaan Tidak Sesuai</li>
            <li>API Key Salah</li>
            <li>ID Pesanan Tidak Di Temukan</li>
        </ul>
                        </td>
                    </tr>
                </table>
            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>