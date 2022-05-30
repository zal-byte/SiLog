<?php
	require_once '../../interface/query.php';
    require_once '../../controller/Barang.php';

    Barang::getInstance();

    $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $first_page = ($page > 1 ) ? ( $page * $limit) - $limit : 0;

    if(isset($_GET['delete'])){
    	$response = Barang::hapus_dataBarang( $_GET['delete']);
    	if( $response[0] == true ){
    		if( $response[1] == 'success'){
    			$_SESSION['hapus_success'] = "Barang berhasil dihapus";
    		}
    	}else if($response[0] == false){
    		if($response[1] == 'error'){
    			$_SESSION['hapus_error'] = "Barang tidak bisa dihapus";
    		}else if($response[1] == 'not_found'){
    			$_SESSION['hapus_error'] = "Barang tidak dapat ditemukan";
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


@media screen and (min-width: 768px){
	.stik{
		position: sticky;
		top: 0;
	}
}

@media screen and (max-width: 768px){
	button{
		margin-bottom: 5px;
	}
}
</style>

<nav class="navbar p-0">
	<div class="container-fluid">
		<a class="navbar-brand text-decoration-none font-weight-bold">
			<span class="bi bi-table fs-1"></span>
			Data Barang
		</a>
		<form class="d-flex" type='get' action="dashboard.php">
			<input type="text" name="search" class="form-control me-2" placeholder="Search" aria-label="Search">
			<button class="btn btn-outline-success" type="submit" id="searchBtn"> Search </button>
		</form>
	</div>
</nav>
<?php if(isset($_SESSION['hapus_success']) || isset($_SESSION['edit_success']) || isset($_SESSION['use_success'])){
	?>
		<div class="mt-2 mb-2 bg-success p-2 rounded" id="success">
			<p class="text-white">
				<?php
				if(isset($_SESSION['hapus_success'])){ 
						echo $_SESSION['hapus_success'];
						unset($_SESSION['hapus_success']);
				}else if(isset($_SESSION['edit_success'])){
						echo $_SESSION['edit_success'];
						unset($_SESSION['edit_success']);
				}else if(isset($_SESSION['use_success'])){
						echo $_SESSION['use_success'];
						unset($_SESSION['use_success']);
				}?>
			</p>
		</div>
	<?php
}?>

<?php if(isset($_SESSION['hapus_error']) || isset($_SESSION['edit_error']) || isset($_SESSION['use_error'])){
	?>
		<div class="mt-2 mb-2 bg-danger p-2 rounded" id="error">
			<p class="text-white">

				<?php 
				if(isset($_SESSION['hapus_error'])){
					echo $_SESSION['hapus_error'];
					unset($_SESSION['hapus_error']);
				}else if(isset($_SESSION['edit_error'])){ 
					echo $_SESSION['edit_error'];
					unset($_SESSION['edit_error']);
				}else if(isset($_SESSION['use_error'])){
					echo $_SESSION['use_error'];
					unset($_SESSION['use_error']);
				}?>
			</p>
		</div>
	<?php } ?>


<?php
	$barang = null;
    if(!isset($_GET['search'])){
	    $barang = Barang::ambil_dataBarang( $limit, $first_page );
    }else{
    	$cari = $_GET['search'];
    	$barang = Barang::cari_dataBarang( $cari, $limit, $first_page);
    }
?>
<div class="container">
	<div class="scrollable">
		<table class="table table-flush" style="width:100%;">
	            <colgroup>
	                <col style="width: 10px;"/>	            	
	                <col style="width: 10px;"/>
	                <col style="width: 200px;"/>
	                <col style="width: 10px;"/>
	                <col style="width: 10px"/>
	            </colgroup>
			<thead class="bg-dark text-white stik">
				<tr>
					<th>
						NO
					</th>
					<th scope="col">
						ID 
					</th>	
					<th scope="col">
						Nama
					</th>
					<th scope="col">
						Sisa
					</th>
					<th scope="col">
						Aksi
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if(isset($barang)){
						for( $i = 0; $i < count($barang);$i++){
							?>
								<tr>
									<td>
										<?php echo $i+1;?>
									</td>
									<td>
										<p id="barang_id_<?php echo $barang[$i]['id_barang'];?>"><?php echo $barang[$i]['id_barang'];?></p>
									</td>
									<td>
										<p id="m_n_barang_<?php echo str_replace('=','',base64_encode($barang[$i]['nama_barang']));?>"><?php echo $barang[$i]['nama_barang'];?></p>
									</td>
									<td>
										<?php echo $barang[$i]['sisa_barang'];?>
									</td>
									<td>
										<button onclick="edit($('#barang_id_<?php echo $barang[$i]['id_barang'];?>'))" class="btn btn-solid btn-primary text-white">
											Edit
										</button>
										<button onclick="hapus($('#barang_id_<?php echo $barang[$i]['id_barang'];?>'))" class="btn btn-solid btn-warning text-white">
											Hapus
										</button>
										<button class="btn btn-outline-success" onclick="use( $('#barang_id_<?php echo $barang[$i]['id_barang'];?>'), $('#m_n_barang_<?php echo str_replace('=','',base64_encode($barang[$i]['nama_barang']));?>') )">
											Gunakan
										</button>
									</td>
								</tr>

								<p id="td_jumlah_barang_<?php echo $barang[$i]['jumlah_barang'];?>" hidden><?php echo $barang[$i]['jumlah_barang'];?></p>
							<?php
						}
					}else
					{

					}
				?>
			</tbody>
		</table>
	</div>
	<div class="container" style="margin-top: 10px;	">
		<?php

			$previous = $page - 1;
			$next = $page + 1;

			if(isset($_GET['search'])){
				$data = Handler::$con->prepare('SELECT * FROM barang WHERE nama_barang LIKE ? order by id_barang desc');
				$data->bindValue(1, "%" . $_GET['search'] . "%", PDO::PARAM_STR);
				$data->execute();
				$total_data = $data->fetchAll(PDO::FETCH_ASSOC);
				echo count($total_data);
			}else{
				$data = Handler::$con->prepare('SELECT * FROM barang');
				$data->execute();
				$total_data = $data->fetchAll(PDO::FETCH_ASSOC);
			}

			$total_halaman = ceil(count($total_data) / $limit);
		?>
		<div class="d-flex justify-content-center">
			<ul class="pagination">
				<li class="page-item">
					<a class="page-link <?php if($page <= 1){echo "d-none";} ?>" <?php if( $page > 1 ){echo "href='?page=$previous&view=databarang'";} ?>><i class="bi bi-arrow-left"></i></a>
				</li>
				<?php

				for($i = 0; $i < $total_halaman;$i++){
					if( $page == $i+1){
						?>
						<li class="page-item disabled">
							<a class="page-link" href="?page=<?php echo $i+1; ?>&view=databarang">
								<?php echo $i+1;?>
							</a>
						</li>
						<?php
					}else{
					?>
						<li class="page-item">
							<a class="page-link" href="?page=<?php echo $i+1; ?>&view=databarang">
								<?php echo $i+1;?>
							</a>
						</li>
					<?php
					}
				}

				?>
					<li class="page-item">
						<a  class="page-link <?php if( $page == $total_halaman){echo "d-none";} ?>" <?php if($page < $total_halaman) { echo "href='?page=$next&view=databarang'"; } ?>><i class="bi bi-arrow-right"></i></a>
					</li>
				<?php
				?>
			</ul>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="font-weight-bold">
					Hapus barang ini ?
				</h4>
			</div>
			<div class="modal-body">
				<p>
					Kamu akan menghapus barang ini
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary text-white" onclick="$('#deleteModal').modal('hide');">Kembali</button>
				<a href="" id='href'><button class="btn btn-warning text-white">Hapus</button></a>
			</div>	
		</div>
	</div>	
</div>


<div class="modal fade" id="editModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="font-weight-bold">
					Edit <i id="n_barang"> HEllo </i>
				</h3>
			</div>
			<div class="modal-body">
				<form method="post" action="process.php" enctype="multipart/form-data">
					<div class="form-group">
						<input value="edit" name="request" hidden>
						<input name="input_id_barang" id="input_id_barang" hidden>
						<label for="input_nama_barang"> Nama Barang </label>
						<input type="text" name="nama_barang" id="input_nama_barang" class="form-control" placeholder="Nama barang" required>
						<label for="input_jumlah_barang"> Jumlah Barang </label>
						<input type="number" name="jumlah_barang" id="input_jumlah_barang" class="form-control mt-2" placeholder="Jumlah barang" required>
						<button type="submit" class="btn mt-2 w-100 btn-primary text-white"> Simpan </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="useModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="font-weight-bold">
					Menggunakan <i id="g_n_barang" class="bg-primary text-white p-1 rounded"> Root </i>
				</h3>
			</div>
			<form method="post" action="process.php" enctype="multipart/form-data">
				<div class="modal-body">
					<input type="number" name="id_barang" hidden>
					<input value="use" name="request" hidden>
					<label for="g_tanggal"> Tanggal </label>
					<input type="date" class="form-control" name="g_tanggal" id="g_tanggal">
					<label for="g_jumlah"> Jumlah </label>
					<input type="number" id="g_jumlah" name="g_jumlah" placeholder="Jumlah" class="form-control">
				</div>
				<div class="modal-footer">
					<button class="mt-2 float-end btn btn-success text-white" type="submit"> Gunakan </button>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>
<script type="text/javascript">
	function hapus( element ){
		$("#href").attr("href", "dashboard.php?delete=" + element[0].innerText+"&view=databarang");
		$("#deleteModal").modal('show');
	}

	function edit( id ){
		$.ajax({
			type:'GET',
			url:'../../controller/api.php?request=getBarang&id_barang=' + id.text(),
			contentType: 'application/json',
			success:function(res){
				var js = JSON.parse(JSON.stringify(res));
				if(js['status']==1){
					$('#n_barang').html(js['data'][0]['nama_barang']);
					// console.log(js['data'][0]['id_barang']);
					$("input[name='input_id_barang']").attr('value',js['data'][0]['id_barang']);
					$("input[id='input_nama_barang']").val( js['data'][0]['nama_barang']);
					$('#input_jumlah_barang').val(js['data'][0]['jumlah_barang']);
					$('#editModal').modal('show');
				}else{
					alert('No_data');
				}
			}
		});
	}

	function use(el_id, el_nama){
		console.log(el_nama);
		$("#g_n_barang").html(el_nama.text());
		$("input[name='id_barang']").attr('value', el_id.text());

		$('#useModal').modal('show');	
	}

	$(function(){
		if($('#success').is(':visible')){
			setTimeout(function(){$('#success').fadeOut(1000);},2000);
		}else if($('#error').is(':visible')){
			setTimeout(function(){$("#error").fadeOut(1000);},2000);
		}
	});
</script>	