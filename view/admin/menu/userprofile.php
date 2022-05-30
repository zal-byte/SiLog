<?php ob_start();
	require_once '../../interface/query.php';
	require_once '../../controller/User.php';

	User::getInstance();

	$user = User::myProfile( $_SESSION['username'] );

?>
<style type="text/css">
	body,html{
		height: 100% !important;
		width: 100%;
	}
	@media screen and (min-width: 768px){
		#mcard{
			width: 40%;
		}
	}
</style>
<div class="d-flex justify-content-center align-items-center mt-3" style="width:100%; height: 100%;">
	<div class="container" id="mcard">
		<div class="card shadow border-0">
			<div class="card-body">
				<h3 class="text-center">
					Ubah kata sandi
				</h3>
				<hr>
			<form method="post" action="process.php" enctype="multipart/form-data">

					<div class="form-group">
						<input value="updatePassword" name="request" hidden>
						<label> Kata sandi lama </label>
						<input type="password" class="form-control" placeholder="Old password" name="old_password" required>
						<label> Kata sandi baru </label>
						<input type="password" class="form-control" placeholder="New password" name="new_password" required>
						<label> Ketik ulang  </label>
						<input type="password" class="form-control" placeholder="Re-Type password" name="verify_password" required>
					</div>
				<?php
					if(isset($_SESSION['update_password_success'])){
						?>
							<div class="mt-2 mb-2 bg-success text-white p-2 rounded" id="success">
								<?php
									echo $_SESSION['update_password_success'];unset($_SESSION['update_password_success']);
								?>
							</div>
						<?php
					}else if(isset($_SESSION['update_password_error'])){
						?>
							<div class="mt-2 mb-2 bg-danger text-white p-2 rounded" id="error">
								<?php
									echo $_SESSION['update_password_error'];
									unset($_SESSION['update_password_error']);
								?>		
							</div>
						<?php
					}
				?>
			</div>
			<div class="card-footer">
				<button class="btn btn-primary text-white float-end" type="submit">
					Simpan
				</button>
				<a href="?view=databarng"><button type="button" class="btn btn-danger text-white float-start">
					Kembali
				</button></a>
			</div>
				</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		if( $('#success').is(':visible')){
			setTimeout(function(){$("#success").fadeOut(1000);},2000);
		}else if($('#error').is(':visible')){
			setTimeout(function(){$('#error').fadeOut(1000);}, 2000);
		}
	});
</script>

<?php ob_end_flush();?>