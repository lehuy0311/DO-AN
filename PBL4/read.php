<?php
// Check existence of id parameter before processing further
if(isset($_GET["ID"]) && !empty(trim($_GET["ID"])))
{
    // Include config file
    require_once "config.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM user WHERE ID = ?";
  
    if($stmt = mysqli_prepare($connection, $sql))
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["ID"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1)
            {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name     = $row["Name"];
                $email    = $row["Email"];
                $password = $row["Password"];
            
            }
            else
            {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        }
        else
        {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($connection);
}
else
{
    print_r($sql);
    exit();
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>View Record</h1>
                        <hr>
                    </div>
                    <div class="form-group">
                        <label>Name :<span class="font-weight-bold text text-success"> <?= $row["Name"]; ?></span></label>
                    </div>
            
                    <div class="form-group">
                        <label>Email :<span class="font-weight-bold text"> <?= $row["Email"]; ?></span></label>
                    </div>
                    
                    <div class="form-group">
                        <label>Password : <span class="font-weight-bold text-info"> <?= $row["Password"]; ?></span></label>
                    </div>

                    <p><a href="index.php" type="button" class="btn btn-outline-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>