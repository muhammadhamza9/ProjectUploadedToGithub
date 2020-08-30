<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

    require_once("connection.php");

    if(isset($_FILES['image'])){
        $errors= array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $perLocation = "images/".$file_name;
        $formats = array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png");
        
        if(file_exists($perLocation))
            $errors = "<div class='alert alert-danger'>File exists already</div>";

        if($file_size > 2097152) {
            $errors = "<div class='alert alert-danger'>File size must be exactly 4 MB</div>";
        }
        if(!in_array($file_type,$formats)){
            $errors = "<div class='alert alert-danger'>Extension not allowed, please choose a JPEG, PNG, or JPG file.</div>";
        }

        if(empty($errors)==true) {
            
            $qry = "INSERT INTO img_table SET image = '".$file_name."'";
            $execute = mysqli_query($conn, $qry);
            
            if($execute){
                thumbnails_creator($file_tmp,$file_name);
                move_uploaded_file($file_tmp, $perLocation);
                echo "<div class='alert alert-success'>Image uploaded successfully</div>";
            }
            else
                echo "Query not executed";
        
        }else{
            print_r($errors);
      }
    }
?>

        <div class="container">
            <h1>Upload images to MySql using PHP</h1>
        </div>
        <div class="container" id="data">
            <a href="index.php" class="btn btn-primary">Home</a>
            <a href="displayData.php" class="btn btn-primary">Display Images</a>
            <form action = "" method = "POST" enctype = "multipart/form-data">
                <div class="form-group">
                    <br><input type = "file" name = "image" class="form-control-file">
                    <input type = "submit" value="Upload File"  class="btn btn-primary">			
                </div>
            </form>
        </div>
</body>
    <script src="bootstrap/js/bootstrap.min.js"></script>
</html>