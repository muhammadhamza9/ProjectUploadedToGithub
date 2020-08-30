<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connection</title>
</head>
<body>
   
   <?php 
        
        $server = "localhost";
        $username = "root";
        $password = "";
    
        $database = "images";
        $conn = mysqli_connect($server,$username,$password,$database);
    
        if(!$conn)
        die("Connection Failed: ".mysqli_connect_error());
    
        function conn_close()
        {
            global $conn;
            mysqli_close($conn);
        }
    
    ?>
    <?php
    
    //this function will create images of the same size i-e width = 80 pixel and height = 80px
    function resizer($ID,$width,$height)
    {
        $upd_width = 80;
        $upd_height = 80;

        $targLayer = imagecreatetruecolor($upd_width,$upd_height);
        imagecopyresampled($targLayer,$ID,0,0,0,0,$upd_width,$upd_height,$width,$height);
        return $targLayer;
    }

    //this will store the thumbnail in local folder
    function thumbnails_creator($file,$file_name)
    {
        $iProp = getimagesize($file);
        $iType = $iProp[2];

        if($iType == IMAGETYPE_JPEG)
        {
            $iResID = imagecreatefromjpeg($file);
            $targLayer = resizer($iResID,$iProp[0],$iProp[1]);
            imagejpeg($targLayer,"thumbnails/".$file_name);
        }
        else if($iType == IMAGETYPE_PNG)
        {
            $iResID = imagecreatefrompng($file);
            $targLayer = resizer($iResID,$iProp[0],$iProp[1]);
            imagepng($targLayer,"thumbnails/".$file_name);
        }
        else if($iType == IMAGETYPE_JPG)
        {
            $iResID = imagecreatefromjpg($file);
            $targLayer = resizer($iResID,$iProp[0],$iProp[1]);
            imagejpg($targLayer,"thumbnails/".$file_name);
        }
    }

?>
</body>
</html>
<?php
    require_once("connection.php");
    if(isset($_POST['submit']))
    {
      //inserting data into the database
      $qry = "INSERT INTO user SET username = '".$_POST['username']."', email = '".$_POST['email']."',
              password = '".$_POST['password']."'"; //the created_at and updated_at can be filled automatically by using CURRENT_TIMESTAMP and CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP respectively
      $execute = mysqli_query($conn, $qry);   //executing the query

      //to check if the data is inserted or not 

      if($execute)
        echo "inserted successfully";
      else
        echo "query not executed";

      conn_close();

    }
  ?>