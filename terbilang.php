<html>
<head>
<title>Membuat fungsi terbilang dengan PHP AJAX</title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function(){
$('#terbilangg').keyup(function(){
var terbilangg=$('#terbilangg').val();
$.ajax({
type:"post",
url:"proses.php",
data:'terbilangg='+terbilangg,
success:function(html){
$('#tampilkan').html(html);
}
});
});
});
</script>
</head>
<body>
<h1><b> Fungsi Terbilang dengan PHP AJAX  </b></h1><br>
Masukkan Nilai : <input type="text" name="terbilangg" id="terbilangg"/>
<br>
<div id="tampilkan"><input type="" name=""></div>
<!-- <hr align="left"width="40%">Nilai Angka : <div id="tampilkan"></div> -->
<body>
</html>