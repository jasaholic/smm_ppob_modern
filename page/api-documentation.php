<?php
session_start();
require '../config.php';
require '../lib/session_login.php';
require '../lib/session_user.php';
if (isset($_POST['ganti_api_key'])) {
		    $api_barunya = acak(20);
		    if ($conn->query("UPDATE users SET api_key = '$api_barunya' WHERE username = '$sess_username'") == true) {
   		        $_SESSION['hasil'] = array('alert' => 'success', 'pesan' => 'Yeah, Api Key Kamu Berhasil Diubah.<script>swal("Berhasil!", "API Key Kamu Berhasil Diubah.", "success");</script>');
		    } else {
   		        $_SESSION['hasil'] = array('alert' => 'danger', 'pesan' => 'Ups, Gagal! Sistem Kami Sedang Mengalami Gangguan.<script>swal("Ups Gagal!", "Sistem Kami Sedang Mengalami Gangguan.", "error");</script>');
		    }
        }
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
                            <h2 class="content-header-title float-start mb-0">API Key</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?php echo $config['web']['url'] ?>">Home</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#">Pages</a>
                                    </li>
                                    <li class="breadcrumb-item active">API Key
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="content-body">
                <section id="ApiKeyPage">
                    <!-- create API key -->
                    <div class="card">
                        <div class="card-header pb-0">
                            <h4 class="card-title">API Key</h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5 order-md-0 order-1">
                                <div class="card-body">
                                    <!-- form -->
                                    <form method="POST" >
                                        <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                                        <div class="mb-2">
                                        	<label for="nameApiKey" class="form-label">Layanan</label>
                                        	<select class="form-control" id="api">
											            	<option value="0">Pilih salah satu...</option>
											            	<option value="api_social_media">Api Sosial Media</option>
											            	<option value="api_top_up">Api Top Up</option>
											            	<option value="api_pascabayar">Api Pascabayar</option>
												        
											            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="nameApiKey" class="form-label">Apikey Kamu</label>
                                            <input class="form-control" type="text" value="<?php echo $data_user['api_key']; ?>" readonly />
                                        </div>

                                        <button type="submit" name="ganti_api_key" class="btn btn-primary w-100">Ganti</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7 order-md-1 order-0">
                                <div class="text-center">
                                    <img class="img-fluid text-center" src="<?php echo $config['web']['url'] ?>app-assets/images/illustration/pricing-Illustration.svg" alt="illustration" width="310" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- api key list -->
                    <div class="card">
                        <div id="fitur"></div>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <!-- END: Content-->


<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script type="text/javascript">
	       var htmlobjek;
            $(document).ready(function(){
                $("#api").change(function(){
                    var api = $("#api").val();
                $.ajax({
                    url: '<?php echo $config['web']['url'] ?>ajax/api-include.php',
                    data: 'api='+api,
                    type: 'POST',
                    dataType: 'html',
                    success: function(msg){
                        $("#fitur").html(msg);
                    }
                });
            });
        });
		</script>

<?php
include("../lib/footer.php");
?>