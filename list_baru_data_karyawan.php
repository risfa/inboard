<?php include ('Db/connect.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#result-datatable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                'copy', 'csv', 'excel', 'print'
                ]
            } );
        } );
    </script>
</head>
<body>
    <table id="result-datatable" class="display" style="width: 100%">
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>AGAMA</th>
                <th>PENDIDIKAN TERAKHIR</th>
                <th>KTP</th>
                <th>NPWP</th>
                <th>PERUSAHAAN</th>
                <th>DEPARTEMEN</th>
                <th>JABATAN</th>
                <th>MULAI BEKERJA</th>
                <th>ALAMAT</th>
                <th>TELEPON</th>
                <th>EMAIl</th>
                <th>BANK</th>
                <th>NAMA PEMILIK BANK</th>
                <th>REKENING</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $list_karyawan = mysql_query("SELECT * FROM tb_karyawan JOIN tb_bank ON tb_karyawan.ID_karyawan = tb_bank.ID_karyawan JOIN tb_login ON tb_karyawan.ID_karyawan = tb_login.ID_karyawan JOIN tb_department ON tb_karyawan.departement= tb_department.ID JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID ORDER BY tb_karyawan.ID_karyawan ASC");
        while($data = mysql_fetch_array($list_karyawan)){
        ?>
        <tr>
         <td><?php echo $data['NIP'] ?></td>
         <td><?php echo $data['nama_lengkap'] ?></td>
         <td><?php echo $data['jenis_kelamin'] ?></td>
         <td><?php echo $data['tgl_lahir'] ?></td>
         <td><?php echo $data['agama'] ?></td>
         <td><?php echo $data['pendidikan'] ?></td>
         <td><?php echo $data['no_ktp'] ?></td>
         <td><?php echo $data['no_npwp'] ?></td>
         <td><?php echo $data['perusahaan'] ?></td>
         <td><?php echo $data['nama_department'] ?></td>
         <td><?php echo $data['nama_jabatan'] ?></td>
         <td><?php echo $data['mulai_bekerja'] ?></td>
         <td><?php echo $data['alamat'] ?></td>
         <td><?php echo $data['no_telp'] ?></td>
         <td><?php echo $data['email'] ?></td>
         <td><?php echo $data['bank'] ?></td>
         <td><?php echo $data['nama_pemilik_bank'] ?></td>
         <td><?php echo $data['no_rek'] ?></td>
        </tr>
        <?php
          }
        ?>
</tbody>
</table>
</body>
</html>
