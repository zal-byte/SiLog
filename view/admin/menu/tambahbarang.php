<?php ob_start();?>
<nav class="navbar">
	<div class="container-fluid">
		<a class="navbar-brand text-decoration-none font-weight-bold">
			<span class="bi bi-plus-square fs-1"></span>
			Tambah Barang
		</a>
	</div>
</nav>

<div class="container-fluid">
	<div class="d-flex justify-content-center">
		<div class="card border-0 shadow" style="width:25rem;">
			<div class="card-body">
				<form method="post" action="#" enctype="multipart/form-data">
					<div class="form-group">
						<input type="text" name="request" value="tambahbarang" hidden>
						<input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Nama barang" required>
						<input type="number" id="jumlah_barang" name="jumlah_barang" class="form-control mt-2" placeholder="Jumlah Barang" required>
						<button id="simpan" type="submit" class="mt-2 w-100 btn btn-primary text-white"> Tambahkan </button>
						<?php if(isset($_SESSION['tambah_error'])){
							?>
								<div class="mt-2" id="err">
									<div class="card border-0 shadow bg-danger">
										<div class="card-body">
											<p class="text-white">
												<?php echo $_SESSION['tambah_error'];unset($_SESSION['tambah_error']);?>
											</p>	
										</div>
									</div>
								</div>
							<?php
							unset($_SESSION['tambah_error']);
						}?>

						<?php if(isset($_SESSION['tambah_success'])){
							?>
							<div class="mt-2" id="err">
								<div class="card border-0 shadow bg-success">
									<div class="card-body">
										<p class="text-white">
											<?php echo $_SESSION['tambah_success'];unset($_SESSION['tambah_success']);?>
										</p>
									</div>
								</div>
							</div>
							<?php
						}?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>
<script type="text/javascript">
	if($("#err").is(":visible")){
		setTimeout(function(){
			$("#err").fadeOut(100);
		}, 2000);
	}
</script>
<?php
	require_once '../../interface/query.php';
	require_once '../../controller/Barang.php';

	Barang::getInstance();

	if(isset($_SERVER['REQUEST_METHOD'])){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$nama_barang = $_POST['nama_barang'];
			$jumlah_barang=  $_POST['jumlah_barang'];

			if(strlen($nama_barang) <= 0){
				$_SESSION['tambah_error'] = 'Nama barang diperlukan';
			}else{

				if($jumlah_barang > 0 ){
					$response = Barang::tambah_dataBarang($nama_barang, $jumlah_barang);

					if( $response != false ){
						$_SESSION['tambah_success'] = 'Barang berhasil ditambahkan';
					}else{
						$_SESSION['tambah_error'] = 'Ada yang salah ketika memasukan data barang.';
					}
				}else{	
					$_SESSION['tambah_error'] = "Masukan jumlah barang dengan benar";
				}
			}
			header("location: dashboard.php?view=tambahbarang");
		}
	}
	ob_end_flush();
?>