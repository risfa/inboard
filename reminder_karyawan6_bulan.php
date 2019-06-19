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

//        for($i=0; $i<=60; $i++) {
//     if(!is_float($i/12)) {
//         $years = floor($i / 12).' Year';
//         $years = $years.($years > 1 ? 's' : '');
//         if($years == 0) {
//             $years = '';
//         }
//     }
//     $months = ' '.($i % 12).' Month';
//     if($months == 0 or $months > 1) {
//         $months = $months.'s';
//     }

//     $display = $years.''.$months;
//     echo '<option value="'.$i.'"';
//     if($result["warrenty"] == $i) {
//         echo 'selected="selected"';
//     }
//     echo '>'.$display.'</option>';
// }


// $b = new DateTime('17:30');
// $interval1 = $a->diff($b);
// echo "interval 1: ", $interval1->format("%H:%I"), "\n";

// $c = new DateTime('08:00');
// $d = new DateTime('13:00');
// $interval2 = $c->diff($d);
// echo "interval 2: ", $interval2->format("%H:%I"), "\n";

// $e = new DateTime('00:00');
// $f = clone $e;
// $e->add($interval1);
// $e->add($interval2);
// echo "Total interval : ", $f->diff($e)->format("%H:%I"), "\n";

       

    $tgl_karyawan = mysql_query("SELECT * FROM `tb_karyawan` WHERE status = 1");
    $today_date = date('d-m-Y', strtotime("now"));
    //	echo $today_date . "</br>";
        while($data = mysql_fetch_array($tgl_karyawan)){

        	 $date1 = $data['mulai_bekerja'];
$date2 = date('Y-m-d');

$diff = abs(strtotime($date2) - strtotime($date1));

// $years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
// $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
// echo"<br>".$months;
if($months >= 6)
{
	echo "<br>".$months;
}
// printf("%d months\n", $months);
            
        // echo"<br>".$data['ID_karyawan']."<br>";
        // echo"<br>".$data['mulai_bekerja']."<br>";
        //$month = strtotime(date("d-m-Y"));
        // $date_6month = date('d-m-Y', )
        	// $start_work = date('d-m-Y', strtotime($data['mulai_bekerja']));
        	// $a = new DateTime($start_work);
			//echo $a; 

			// $b = new DateTime($today_date);
			// $interval = $a->diff($b);
			// echo $interval;
        	
        	//echo $today_date . "</br>";
        	// echo "now " .$now . " ";
        	// echo "+6 : " . date('d-m-Y', strtotime('+6 month', strtotime($data['mulai_bekerja']))). "</br>"; 
        $date_6bulan = date('d-m-Y', strtotime('+6 month', strtotime($data['mulai_bekerja'])));
        //echo $date_6bulan . "</br>";

        	// $date2 = date('d-m-Y', strtotime('+6 month', $data['mulai_bekerja']));
        	//echo "<br>".$date3;
        //$d1 = new DateTime(); 
        //$diff = $d1->diff($today_date);

        // echo $d1;
        // echo $diff;
        // if($today_date >= $date_6bulan){
        	// echo $start_work . " to " . $date_6bulan . "  Yeash </br>";
        // }else{
        	// echo $start_work . " to " . $date_6bulan . "  Ga sama </br>";
        // }


        // if(strtotime(date("d-m-Y")) >= date('d-m-Y', strtotime('+6 month', strtotime($data['mulai_bekerja'])))){
        //     // echo "baba";
        //     $search_karyawan = mysql_query("SELECT * FROM tb_karyawan WHERE ID_karyawan = '$data[ID_karyawan]'");
        //     while($karyawan = mysql_fetch_array($search_karyawan)){
        //     	//echo "baba";
        //     }
        // }
      $message_karyawan = "Karyawan Dengan Nama *".$search_karyawan['nama_lengkap']."* terhitung hari ini sudah menjadi karyawanselama 6 bulan,klik link dibawah ini : ";
      // $kirim_feedback_ke_karyawan = send_wa($search_karyawan['no_telp'],$message_karyawan,'CUTI','inboard.ardgroup.co.id');
      // $kirim_feedback_ke_karyawan = send_wa('6281291305529',$message_karyawan,'CUTI','inboard.ardgroup.co.id');

            //KIRIM MESSAGE KE TOP leader
     // $kirim_ke_atasan = send_wa($data_Top_leader['no_telp'],"Reminder cuti *".$search_karyawan['nama_lengkap']."* pada tanggal *".$data['tgl_cuti']."* telah disetujui, klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
     // $kirim_ke_atasan = send_wa('6281291305529',"Reminder cuti *".$search_karyawan['nama_lengkap']."* pada tanggal *".$data['tgl_cuti']."* telah disetujui, klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
            //END

            //KIRIM MESSAGE KE leader
     // $kirim_ke_atasan = send_wa($data_leader['no_telp'],"Reminder cuti *".$search_karyawan['nama_lengkap']."* pada tanggal *".$data['tgl_cuti']."* telah disetujui, klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
     // $kirim_ke_atasan = send_wa('6281291305529',"Reminder cuti *".$search_karyawan['nama_lengkap']."* pada tanggal *".$data['tgl_cuti']."* telah disetujui, klik link dibawah ini : ",'CUTI','inboard.ardgroup.co.id');
            //END
        
            // SEND MESSAGE KE HR
     // $message_HR = "Reminder cuti *".$search_karyawan['nama_lengkap']."* pada tanggal *".$data['tgl_cuti']."* telah disetujui, klik link dibawah ini : ";
     // $kirim_feedback_ke_HR = send_wa('6281291305529',$message_HR,'CUTI','inboard.ardgroup.co.id');
            //END
        }           
?>


