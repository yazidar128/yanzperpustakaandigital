<?php
 class koneksi{
   public function dbkonek(){
   	  $dbhost='localhost';//set the hostname
   	  $dbname='yazidperpustakaan';//set the database name
   	  $dbuser='root';//set the mysql username
   	$dbpass='';//set the mysql password
   	
   	    try{
   	    	$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
   	    	              $dbConnection->exec("set names utf8");
          $dbConnection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
          return $dbConnection;
   	    }  
   	    catch(PDOException $e){
   	    	return 'Connection failed:'.$e->getMessage();
   	    }
   }
 }

 $conn = mysqli_connect( "localhost" , "root" , "" , "yazidperpustakaan");

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>