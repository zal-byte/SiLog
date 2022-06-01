<?php

	interface query{
		const adminLogin = 'SELECT password FROM admin WHERE username = :username';


		const dataBarang = "select * from barang ORDER BY id_barang DESC limit :page, :limit";
		const cariDataBarang = "select * from barang where nama_barang like ? order by id_barang desc limit ?, ?";

		const tambahDataBarang = "insert into barang (`nama_barang`,`jumlah_barang`,`sisa_barang`) VALUES (:nama_barang, :jumlah_barang,:sisa_barang)";

		const hapusDataBarang = "delete from barang where id_barang = ? ";

		const cekDataBarang = "SELECT * FROM barang WHERE id_barang = ?";

		const editDataBarang = "update barang set nama_barang=?, jumlah_barang=? where id_barang = ?";

		const updateSisaBarang = 'update barang set sisa_barang=? where id_barang = ?';


		const semuaDataBarang = 'SELECT * FROM barang';
		const semuaDataPenggunaan = 'SELECT * FROM barang_digunakan';


		const dataBarangDigunakan = 'SELECT * FROM barang_digunakan INNER JOIN barang USING (id_barang) ORDER BY id_barang_digunakan DESC LIMIT ?, ?';
		const tambahDataBarangDigunakan = 'INSERT INTO barang_digunakan (`tanggal`,`jumlah`,`id_barang`) VALUES (?,?,?)';
		const hapusDataBarangDigunakan = 'DELETE FROM barang_digunakan WHERE id_barang_digunakan = ?';

		const cariDataBarangDigunakan = "SELECT * FROM barang_digunakan INNER JOIN barang USING(id_barang) WHERE barang.nama_barang LIKE :cari ORDER BY barang_digunakan.id_barang_digunakan DESC LIMIT :page, :limit";

		const cekDataBarangDigunakan = "SELECT * FROM barang_digunakan WHERE id_barang_digunakan = ?";


		const editDataBarangDigunakan = "UPDATE barang_digunakan SET tanggal = ? , jumlah = ? WHERE id_barang_digunakan = ?";

		const myProfile = 'SELECT * FROM admin WHERE username = ? ';
		const updatePassword = 'UPDATE admin SET password=? WHERE username=?';


		const getReportByDate = "SELECT * FROM barang_digunakan INNER JOIN barang USING (id_barang) WHERE barang_digunakan.tanggal = ? ORDER BY barang_digunakan.id_barang_digunakan DESC";
		const getReportDate = "SELECT DISTINCT tanggal FROM barang_digunakan";
		const getReport = "SELECT * FROM barang_digunakan INNER JOIN barang USING (id_barang) ORDER BY id_barang_digunakan DESC LIMIT ?, ?";
	}



?>