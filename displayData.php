<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Images</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>

    <div class="container">
        <br><a href="index.php" class='btn btn-primary'>Insert Data</a><br><br>
    </div>
    
   <?php 
    
        require_once("connection.php");
        
        $results_per_page = 2;          //data that we want to display on each page
        
        //find the total number of results stored in the database
        $query = "SELECT * FROM img_table";
        $result = mysqli_query($conn,$query);
        $number_of_result = mysqli_num_rows($result);

        //determine the total number of pages available  
        $number_of_page = ceil ($number_of_result / $results_per_page);  
    
        //determine which page number visitor is currently on  
        if (!isset ($_GET['page']) ) {  
            $page = 1;  
        } else {  
            $page = $_GET['page'];  
        }

        $previous_page = $page - 1;
	    $next_page = $page + 1;
        
        //determine the sql LIMIT starting number for the results on the displaying page  
        $page_first_result = ($page-1) * $results_per_page;  
            
        //retrieve the selected results from database   
        $query = "SELECT * FROM img_table LIMIT " . $page_first_result . ',' . $results_per_page;  
        $results = mysqli_query($conn, $query);

        if(mysqli_num_rows($results) > 0)
        {                               //displaying data to user in a tubular form
    ?>      <div class="container">
                
                <h1 class="bg-success text-white">Displaying data from database</h1>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <th class="">ID</th>
                        <th>Image</th>
                    </thead>
   <?php
                    while($row = mysqli_fetch_assoc($results))
                    {
                        echo "<tr> <td>".$row['id']."</td>";
                        echo "<td><img class='img-thumbnail' src='thumbnails/".$row['image']."'></td>";
                    } 
    ?>    
                </table>
            
   <?php
        }
                //display the link of the pages in URL  
                if($page > 1){
                    echo "<a class='btn btn-outline-primary' href='?page=$previous_page'>&lsaquo;&lsaquo;Prev</a>";
                }
                if($page < $number_of_page){
                    echo "<a class='btn btn-outline-primary' href='?page=$next_page'>Next&rsaquo;&rsaquo;</a>";
                }
                
                echo "<br><br>";
                for($page = 1; $page<= $number_of_page; $page++) {  
                    echo '<a class="btn btn-primary" href = "?page=' . $page . '">' . $page . '</a>';  
                }
                
                conn_close();     
    ?>
            </div>
     
</body>
</html>