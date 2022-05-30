<?php
	require_once '../../interface/query.php';
	require_once '../../controller/Barang.php';
	Barang::getInstance();

	$barang = Barang::getAllBarang();	
	$penggunaan = Barang::getAllPenggunaan();
?>

<div class="d-flex justify-content-center">
	<div class="card shadow border-0" style="width: 100%;">
		<img class="card-img-top" src="../../asset/img/puskes_crop.jpg.jpeg" style="height: 69vh;">
		<div class="card-body">
			<h3 class="text-center  font-weight-bold">
				Selamat datang, Admin.
			</h3>
		</div>
	</div>
</div>

<div class="container-fluid mt-3">
	<div class="d-flex justify-content-center">
		<div class="card border-0 shadow bg-primary" style="width:15rem;">
			<div class="card-body">
				<p class="text-white text-center"> Barang </p>
				<hr>
				<h2 class="text-center text-white">
					<?php echo count($barang);?>
				</h2>
			</div>
		</div>
		<div class="card border-0 shadow bg-primary" style="width:15rem; margin-left: 10px;">
			<div class="card-body">
				<p class="text-white text-center"> Penggunaan </p>
				<hr>
				<h2 class="text-center text-white">
					<?php echo count($penggunaan);?>
				</h2>
			</div>
		</div>
	</div>
</div>
