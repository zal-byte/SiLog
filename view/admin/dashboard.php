<?php 
ob_start();
session_start(); 
    //pagination 



if(!isset($_SESSION['login'])){header('location: index.php');}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../../asset/bs5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../asset/bs5/icon/bs-icon/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../../asset/fa6/css/all.min.css">
	<title> SiLog | Dashboard </title>
    <style>
        body,html{
            height: 100% !important;
        }
    </style>
</head>
<body>





<div class="container-fluid">
    <div class="row">
        <div class="col-sm-auto bg-light sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-nowrap bg-light align-items-center sticky-top">
                <a href="?view=mainmenu" id="mainmenu" class="d-block p-3 link-dark text-decoration-none" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Halaman utama">
                    <i class="bi-house fa-2x"></i>
                </a>
                <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center align-items-center">
                    <li class="nav-item">
                        <a href="?view=databarang" id="databarang" class="nav-link py-3 px-2" title="" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Data barang">
                            <i class="bi-table fa-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                    	<a href="?view=tambahbarang" id="tambahbarang" class="nav-link py-3 px-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Tambah Barang">
                    		<i class="bi-plus-square fa-2x"></i>
                    	</a>
                    </li>
                     <li class="nav-item">
                        <a href="?view=barangdigunakan" id="tambahbarang" class="nav-link py-3 px-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Penggunaan barang">
                            <i class="fa-solid fa-box fa-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                    	<a href="#" class="nav-link py-3 px-2" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Cetak Laporan">
                    		<i class="bi-card-list fa-2x"></i>
                    	</a>
                    </li>

                    <li class="nav-item">
                        <a href="?view=userprofile" class="nav-link py-3 px-2" style="color:black;" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="User profile">
                            <i class="bi-person-square fa-2x"></i>
                        </a>
                    </li>

                    <li class="nav-item">
                    	<a class="nav-link py-3 px-2" onclick="$('#modalLogout').modal('show');" style="color:red;" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Logout">
                    		<i class="bi-door-open fa-2x"></i>
                    	</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm p-3 min-vh-100">
            <!-- content -->
            <div id="content">
                <?php
                    if(isset($_GET['search'])){
                        include 'menu/databarang.php';
                    }else if(isset($_GET['d_search'])){
                        include 'menu/barangdigunakan.php';
                    }
                    else{
                        if(isset($_GET['view'])){
                            switch( $_GET['view']){
                                case 'tambahbarang':
                                include 'menu/tambahbarang.php';
                                break;
                                case 'mainmenu':
                                include 'menu/mainmenu.php';
                                break;
                                case 'databarang':
                                include 'menu/databarang.php';
                                break;
                                case 'barangdigunakan':
                                include 'menu/barangdigunakan.php';
                                break;
                                case 'userprofile':
                                include 'menu/userprofile.php';
                                break;
                                default:
                                include 'menu/mainmenu.php';
                                break;
                            }
                        }else{
                            include 'menu/mainmenu.php';
                        }                        
                    }

                ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalLogout" tabindex="-1" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="font-weight-bold">
                    Keluar ?
                </h4>   
            </div>  
            <div class="modal-body">
                <p>
                    Apakah kamu ingin keluar ?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal"> Tutup </button>
                <a href="lo.php"><button type="button" class="btn btn-warning text-white"> Keluar </button></a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../../asset/pub_js/jquery.min.js"></script>
<script type="text/javascript" src="../../asset/pub_js/popper.min.js"></script>
<script type="text/javascript" src="../../asset/pub_js/tooltip.js"></script>
<script type="text/javascript" src="../../asset/bs5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../asset/fa6/js/all.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("[data-bs-toggle='tooltip']").tooltip();
    });
</script>
</body>
</html>
<?php ob_end_flush();?>