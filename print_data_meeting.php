<?php include ('otu/connect.php');
date_default_timezone_set("Asia/Bangkok");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Document Print</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<style type="text/css">
		*{
			font-family: 'Roboto', sans-serif;
		}
		.td_data{
			padding: 10px;
			border: 1px solid #ECECEC;
		}

		table{
		}
	</style>
</head>
<body>
	<br><br>
	<img src="http://xeniel.5dapps.com/inboard/img/logo.png" height="65px">
	<?php 
		$data_meeting = mysql_fetch_array(mysql_query("SELECT * FROM tb_meeting WHERE ID_meeting = '$_GET[id]'"));
	 ?>
	<table  width="100%">
		<tr>
			<td colspan="3"><h1>DAFTAR HADIR</h1></td>
		</tr>
		<tr>
			<td style="width: 10%">Perihal</td>
			<td style="width: 1%">:</td>
			<td style="width: 80%"><?php echo $data_meeting['judul_meeting']; ?></td>
		</tr>
		<tr>
			<td>Tanggal</td>
			<td>:</td>
			<td><?php echo $data_meeting['tanggal_meeting']; ?></td>
		</tr>
		<tr>
			<td>Waktu</td>
			<td>:</td>
			<td><?php echo $data_meeting['waktu_mulai']." -> ".$data_meeting['waktu_akhir']; ?></td>
		</tr>
		<tr>
			<td>Lokasi</td>
			<td>:</td>
			<td><?php echo $data_meeting['Lokasi']; ?></td>
		</tr>
		<tr>
			<td>Meeting Code</td>
			<td>:</td>
			<td><?php echo $data_meeting['kode_meeting']; ?></td>
		</tr>
	</table>
	<br><br>
	<table  class="table_data" style="width: 100%">
		<tr style="background: #ECECEC; color: #000">
			<th class="td_data">No</th>
			<th class="td_data">Nama</th>
			<th class="td_data">No. Handphone</th>
			<th class="td_data">Email</th>
			<th class="td_data">Tanggal Check-in</th>
		</tr>
		<?php 
			$no=1;
			$sql = mysql_query("SELECT tb_peserta_absensi.*, tb_karyawan.nama_lengkap,tb_karyawan.NIP, tb_karyawan.no_telp, tb_login.email FROM tb_peserta_absensi JOIN tb_karyawan ON tb_karyawan.ID_karyawan = tb_peserta_absensi.ID_karyawan JOIN tb_login ON tb_login.ID_karyawan = tb_peserta_absensi.ID_karyawan where ID_meeting = '$_GET[id]' ORDER BY waktu_absen ASC");
			while($data=mysql_fetch_array($sql)){
		 ?>
		<tr style="text-align: center;">
			<td class="td_data"><center><?php echo $no; ?></center></td>
			<td class="td_data"><?php echo $data['nama_lengkap'] ?></td>
			<td class="td_data"><?php echo $data['no_telp'] ?></td>
			<td class="td_data"><?php echo $data['email'] ?></td>
			<td class="td_data"><?php echo $data['waktu_absen'] ?></td>
		</tr>
		<?php $no++; } ?>
	</table>
	<br>
	<center>
		- END OF PAGE -<br>
		Printed Time : <?php echo date('d-M-Y H:i:s'); ?>
	</center>
</body>
</html>