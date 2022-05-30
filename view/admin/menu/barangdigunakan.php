<?php
	ob_start();

	require_once '../../interface/query.php';
	require_once '../../controller/Barang.php';

	Barang::getInstance();


	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
	$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	$first_page = ($page > 1 ) ? ( $page * $limit ) - $limit : 0;



	if(isset($_GET['d_delete'])){
		$id_barang_digunakan = $_GET['d_delete'];

		$response = Barang::hapus_dataBarangPenggunaan( $id_barang_digunakan );
		if( $response[0] != false ){
			$_SESSION['d_delete_success'] = "Penggunaan berhasil dihapus";
		}else{
			if($response[1] == 'not_found'){
				$_SESSION['d_delete_error'] = "Barang tidak ditemukan";
			}else{
				$_SESSION['d_delete_error'] = "Gagal menghapus Penggunaan";
			}
		}

	}

?>
<style type="text/css">
	.scrollable{
	height: 80vh;
	overflow-y: auto;
}
.scrollable::-webkit-scrollbar{
	display: none;
}
	
</style>
<nav class="navbar">
	<div class="container-fluid">
		<a class="navbar-brand text-decoration-none font-weight-bold">
			<span class="fa-solid fa-box fa-2x"></span>
			Penggunaan Barang
		</a>
		<form class="d-flex" type='GET' action="dashboard.php" enctype="multipart/form-data">
			<input type="text" name="d_search" class="form-control me-2" placeholder="Search" aria-label="Search">
			<button class="btn btn-outline-success" type="submit" id="searchBtn"> Search </button>
		</form>
	</div>
</nav>
<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>

<?php
	if(isset($_SESSION['d_delete_success']) || isset($_SESSION['edit_penggunaan_success'])){
		?>
			<div class="mt-2 mb-2 bg-success p-2 rounded text-white" id="success">
				<?php
					if(isset($_SESSION['d_delete_success'])){
						echo $_SESSION['d_delete_success'];
						unset($_SESSION['d_delete_success']);
					}else if(isset($_SESSION['edit_penggunaan_success'])){
						echo $_SESSION['edit_penggunaan_success'];
						unset($_SESSION['edit_penggunaan_success']);
					}
				?>
			</div>
		<?php
	}else if(isset($_SESSION['d_delete_error']) || isset($_SESSION['edit_penggunaan_error'])){
		?>
			<div class="mt-2 mb-2 bg-danger text-white p-2 rounded" id="error">
				<?php
					if(isset($_SESSION['d_delete_error'])){
						echo $_SESSION['d_delete_error'];
						unset($_SESSION['d_delete_error']);
					}else if(isset($_SESSION['edit_penggunaan_error'])){
						echo $_SESSION['edit_penggunaan_error'];
						unset($_SESSION['edit_penggunaan_error']);
					}
				?>
			</div>
		<?php
	}
?>

<div class="container">
	<div class="scrollable">
		<table class="table table-flush" style="width:100%;">
	           <colgroup>
	               <col style="width: 10px;"/>
	               <col style="width:10px;"/>	            	
	               <col style="width: 10px;"/>
	               <col style="width: 20px;"/>
	               <col style="width: 170px;"/>
	               <col style="width: 10px;"/>
	               <col style="width: 20px;"/>
	           </colgroup>
			<thead class="bg-dark text-white stik">
				<tr>
					<th scope="col">
						NO
					</th>	
					<th scope="col">
						ID Penggunaan
					</th>
					<th scope="col">
						ID Barang
					</th>	
					<th scope="col">
						Tanggal
					</th>
					<th scope="col">
						Nama Barang
					</th>
					<th scope="col">
						Terpakai
					</th>
					<th scope="col">
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(isset($_GET['d_search'])){
						$barang_digunakan = Barang::cari_dataBarangPenggunaan( $_GET['d_search'], $limit, $first_page );
					}else{
						$barang_digunakan = Barang::ambil_dataBarangPenggunaan( $limit, $first_page );
					}

					if(count($barang_digunakan) > 0)
					{
						for($i = 0; $i < count($barang_digunakan); $i++){
							?>
								<tr>
									<td>
										<?php echo $i+1;?>
									</td>
									<td>
										<p id="id_barang_digunakan_<?php echo $barang_digunakan[$i]['id_barang_digunakan'];?>"><?php echo $barang_digunakan[$i]['id_barang_digunakan'];?></p>
									</td>
									<td>
										<?php echo $barang_digunakan[$i]['id_barang'];?>
									</td>
									<td>
										<?php echo $barang_digunakan[$i]['tanggal'];?>
									</td>
									<td>
										<p id="d_nama_barang_<?php echo str_replace('=','', base64_encode($barang_digunakan[$i]['nama_barang']));?>"><?php echo $barang_digunakan[$i]['nama_barang'];?>
									</td>
									<td>
										<?php echo $barang_digunakan[$i]['jumlah'];?>
									</td>
									<td>
										<button class="btn btn-primary text-white" onclick="edit( $('#id_barang_digunakan_<?php echo $barang_digunakan[$i]['id_barang_digunakan'];?>'), $('#d_nama_barang_<?php echo str_replace('=','', base64_encode($barang_digunakan[$i]['nama_barang']));?>') )"> Edit </button>
										<button class="btn btn-warning text-white" onclick="hapus($('#id_barang_digunakan_<?php echo $barang_digunakan[$i]['id_barang_digunakan'];?>'))"> Hapus </button>
									</td>
								</tr>
							<?php
						}
					}
				?>
			</tbody>
		</table>
	</div>	
	<div class="container" style="margin-top:10px;">
		<?php
			$previous = $page - 1;
			$next = $page + 1;

			if(isset($_GET['d_search'])){
				$data = Handler::$con->prepare('SELECT * FROM barang_digunakan INNER JOIN barang USING(id_barang) LIKE ? ORDER BY id_barang_digunakan DESC');
				$data->bindValue(1, "%" . $_GET['d_search'] . "%", PDO::PARAM_STR );
				$data->execute();
				$total_data = $data->fetchAll(PDO::FETCH_ASSOC);

			}else{
				$data = Handler::$con->prepare('SELECT * FROM barang_digunakan');
				$data->execute();
				$total_data = $data->fetchAll(PDO::FETCH_ASSOC);
			}

			$total_halaman = ceil(count($total_data) / $limit );
		?>
		<div class="d-flex justify-content-center">
			<ul class="pagination">
				<li class="page-item">
					<a class="page-link <?php if($page <= 1){echo "d-none";} ?>" <?php if( $page > 1 ){echo "href='?page=$previous&view=barangdigunakan'";} ?>><i class="bi bi-arrow-left"></i></a>
				</li>
				<?php

				for($i = 0; $i < $total_halaman;$i++){
					if( $page == $i+1){
						?>
						<li class="page-item disabled">
							<a class="page-link" href="?page=<?php echo $i+1; ?>&view=barangdigunakan">
								<?php echo $i+1;?>
							</a>
						</li>
						<?php
					}else{
					?>
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo $i+1; ?>&view=barangdigunakan">
								<?php echo $i+1;?>
							</a>
						</li>
					<?php
					}
				}

				?>
					<li class="page-item">
						<a  class="page-link <?php if( $page == $total_halaman){echo "d-none";} ?>" <?php if($page < $total_halaman) { echo "href='?page=$next&view=barangdigunakan'"; } ?>><i class="bi bi-arrow-right"></i></a>
					</li>
			</ul>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="font-weight-bold">
					Hapus penggunaan ini ?
				</h3>
			</div>
			<div class="modal-body">
				<p>
					Hapus penggunaan barang ini ?
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary text-white" onclick="$('#deleteModal').modal('hide');"> Kembali </button>
				<a href="" id="href"><button class="btn btn-warning text-white"> Hapus </button></a>
			</div>
		</div>	
	</div>
</div>
<div class="modal fade" id="editModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form method="post" action="process.php" enctype="multipart/form-data">
			<div class="modal-header">
				<h3 class="font-weight-bold">
					Mengubah <i class="bg-primary text-white p-2 rounded" id="nama_barang"></i>
				</h3>
			</div>
			<div class="modal-body">
				<input value="editPenggunaan" name="request" hidden>
				<input id="id_barang_digunakan" name="id_barang_digunakan" value="" hidden>
				<div class="form-group">
					<label> Tanggal </label>
					<input type="date" class="form-control" id="input_tanggal" name="tanggal" required>
					<label> Jumlah </label>
					<input type="number" class="form-control" id="input_jumlah" name="jumlah" required placeholder="Jumlah">
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary text-white">
					Simpan
				</button>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	function hapus( element ){

		$('#href').attr('href', 'dashboard.php?view=barangdigunakan&d_delete=' + element[0].innerText);
		$('#deleteModal').modal('show');

	}

	function edit( id_barang_digunakan , d_nama_barang ){

		d_nama_barang = d_nama_barang[0].innerText;
		id_barang_digunakan = id_barang_digunakan[0].innerText;

		$('#id_barang_digunakan').attr('value', id_barang_digunakan);
		$('#nama_barang').html(d_nama_barang);

		$.ajax({
			type:'GET',
			url:'../../controller/api.php?request=getBarangDigunakan&id_barang_digunakan=' + id_barang_digunakan,
			contentType: 'application/json',
			success:function(res)
			{
				var js = JSON.parse(res);
				if( js['status'] != false ){
					$("#input_tanggal").attr("value", js['data'][0]['tanggal']);
					$('#input_jumlah').attr('value', parseInt(js['data'][0]['jumlah']));
				}else{

				}
			}
		});

		$('#editModal').modal('show');

	}

	$(function(){
		if($("#success").is(':visible')){
			setTimeout(function(){$("#success").fadeOut(1000);},2000);
		}else if($("#error").is(':visible')){
			setTimeout(function(){$("#error").fadeOut(1000);},2000);
		}
	});

</script>
<?php ob_end_flush();?>