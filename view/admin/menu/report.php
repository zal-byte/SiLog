<?php 

	require_once '../../interface/query.php';
	require_once '../../controller/Barang.php';

	Barang::getInstance();



	$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
	$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
	$first_page = ($page > 1 ) ? ( $page * $limit ) - $limit : 0;

?>

<nav class="navbar">
	<div class="container-fluid">
		<a class="navbar-brand text-decoration-none font-weight-bold">
			<span class="fa-solid fa-box fa-2x"></span>
			Laporan
		</a>
	</div>
</nav>

<style type="text/css">
	.scrollable{
	height: 80vh;
	overflow-y: auto;
}
.scrollable::-webkit-scrollbar{
	display: none;
}
	
</style>

<div class="container-fluid w-50 mt-2">
	<p class="text-center">
		Data Barang yang digunakan pada tanggal 
	</p>
	<?php 
		$list_tanggal = Barang::getDate();
	?>
	<form id="reForm" method="get" action="dashboard.php?view=report" enctype="multipart/form-data">
		<select class="form-select" name="select_date">
			<?php if(isset($_GET['select_date']) && !empty($_GET['select_date'])){
				?>
					<option> <?php echo $_GET['select_date'];?></option>
				<?php
			}else{?>
			<option>Pilih tanggal</option>
		<?php } ?>
			<?php
				if(isset($list_tanggal)){
					for($i=0;$i<count($list_tanggal);$i++){
						// $tgl = 
						?>
							<option value="<?php echo $list_tanggal[$i]['tanggal'];?>"><?php echo $list_tanggal[$i]['tanggal'];?></option>
						<?php
					}
				}
			?>
		</select>
	</form>
</div>

<div class="container">
	<?php 
		if(isset($_GET['select_date']) && !empty($_GET['select_date'])){
			?>
				<a href="dashboard.php?view=report&select_date=<?php echo $_GET['select_date'];?>&type=print"><button class="btn btn-primary text-white">
					<span class="bi-printer"> Cetak </span>
				</button></a>
			<?php
		}else{
			?>
				<button class="btn btn-primary disabled	 text-white">
					<span class="bi-printer"> Cetak </span>
				</button>
			<?php
		}
	?>	
</div>

<div class="container mt-2">
		<?php
		
		if(isset($_GET['select_date'])){
			$barang = Barang::getReportByDate( $_GET['select_date'] );
		}else{
			$barang = Barang::getReport( $limit, $first_page );
		}

		if(isset($_GET['type'])){
			if($_GET['type'] == 'print'){
				$_SESSION['barang'] = $barang;
				$_SESSION['select_date'] = $_GET['select_date'];
				header('location: menu/print.php');
			}
		}
	?>

	<div class="scrollable">
		<table class="table table-flush" style="width: 100%;">
	           <colgroup>
	               <col style="width: 10px;"/>
	               <col style="width:10px;"/>	            	
	               <col style="width: 10px;"/>
	               <col style="width: 20px;"/>
	               <col style="width: 170px;"/>
	               <col style="width: 10px;"/>
	           </colgroup>
	           <thead class="bg-dark text-white">
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
	           </thead>
	           <tbody>
	           		<?php
	           			if(isset($barang)){
	           				for($i=0;$i<count($barang);$i++){
	           					?>
	           						<tr>
	           							<td>
	           								<?php echo $i+1;?>
	           							</td>
	           							<td>
	           								<?php echo $barang[$i]['id_barang_digunakan'];?>
	           							</td>
	           							<td>
	           								<?php echo $barang[$i]['id_barang'];?>
	           							</td>
	           							<td>
	           								<?php echo $barang[$i]['tanggal'];?>
	           							</td>
	           							<td>
	           								<?php echo $barang[$i]['nama_barang'];?>
	           							</td>
	           							<td>
	           								<?php echo $barang[$i]['jumlah'];?>
	           							</td>
	           						</tr>
	           					<?php
	           				}
	           			}else{

	           			}
	           		?>
	           </tbody>
		</table>
	</div>


</div>
<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select[name="select_date"]').on('change',function(){
			$('#reForm')[0].submit();
		});
	});
</script>