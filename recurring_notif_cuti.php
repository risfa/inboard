<?php include ('Db/connect.php');
      include 'wa.php';

    $cek_apakah_saya_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE ID = '$_SESSION[departement]' AND leader = '$_SESSION[ID_karyawan]'"));
        if($cek_apakah_saya_leader[0]==""){
            $cek_saya_leader = "FALSE";
        }else{
            $cek_saya_leader = "TRUE";
        }

    $cek_apakah_saya_top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE top_leader = '$_SESSION[ID_karyawan]'"));
        if($cek_apakah_saya_top_leader[0]==""){
            $cek_saya_top_leader = "FALSE";
        }else{
            $cek_saya_top_leader = "TRUE";
        }
        function fetch_karyawan($id_karyawan){
            $sql = mysql_query("SELECT tb_karyawan.*, tb_jabatan.*, tb_department.* FROM tb_karyawan JOIN tb_jabatan ON tb_karyawan.jabatan = tb_jabatan.ID JOIN tb_department ON tb_karyawan.departement = tb_department.ID WHERE ID_karyawan = '".$id_karyawan."' ");
            return mysql_fetch_array($sql);
        }
    $data_karyawan2 = fetch_karyawan($_SESSION[ID_karyawan]);
        $tanggal_sekarang = date('d-m-Y');
        $time = date('d-m-Y', strtotime('-1 days'));
        // echo "$time";
    $data_cuti_sekarang = mysql_query("SELECT * FROM `tb_permohonan_cuti` where tb_permohonan_cuti.tgl_cuti = '$tanggal_sekarang' AND tb_permohonan_cuti.status = 'DI TERIMA'");
        while($data = mysql_fetch_array($data_cuti_sekarang)){
      
        echo"<br>".$data['ID_karyawan']."<br>";
        echo"<br>".$data['tgl_cuti']."<br>";
        // echo"<br>".$tgl2."<br>";

      $search_karyawan = mysql_fetch_array(mysql_query("SELECT * from tb_karyawan where ID_karyawan = $data[ID_karyawan] ORDER BY ID_karyawan"));
        $departemen = $search_karyawan['departement'];
        echo $departemen."<br>";
        echo $search_karyawan['nama_lengkap']."<br>" .$search_karyawan['no_telp']."<br>";
      $search_departemen = mysql_fetch_array(mysql_query("SELECT * FROM tb_department WHERE tb_department.ID = '$departemen'"));
        $leader = $search_departemen['leader'];
        $Top_leader = $search_departemen['top_leader'];
        echo "LEADER  ".$search_departemen['leader']."<br>";
        echo "TOP_LEADER  ".$search_departemen['top_leader']."<br>";

        $data_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$leader'"));
        echo "NO leader  "."<br>".$data_leader['no_telp']."<br>";
        $data_Top_leader = mysql_fetch_array(mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$Top_leader'"));
        echo "NO top leader"."<br>".$data_Top_leader['no_telp']."<br>";

      $message_karyawan = "YEAY! sekarang adalah hari kamu mengambil cuti, manfaatkan waktu sebaik-baiknya, SELAMAT BERLIBUR :),klik link dibawah ini : ";
     
      // $kirim_feedback_ke_karyawan = send_wa('6281291305529',$message_karyawan,'CUTI','inboard.ardgroup.co.id');

        }           
?>
            
            