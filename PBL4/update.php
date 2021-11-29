<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name     = $email        = $password   = "";
$name_err = $email_err    = $password_err = "";

// Processing form data when form is submitted
if(isset($_POST["ID"]) && !empty($_POST["ID"]))
{
    // Get hidden input value 
    $id = $_POST["ID"];
    
    // Validate name
    $input_name = trim($_POST["Name"]);
    if(empty($input_name))
    {
        $name_err = "Please enter a name.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Please enter a valid name.";
    }
    else
    {
        $name = $input_name;
    }

    // Validate email
    $input_email = trim($_POST["Email"]);
    if(empty($input_email))
    {
        $email_err = "Please enter an email.";
    }
    elseif(!($input_email))
    {
        $email_err = "Please enter a valid email.";
    }
    else
    {
        $email = $input_email;
    }

    // Validate password
    $input_password = trim($_POST["Password"]);
    if(empty($input_password))
    {
        $password_err = "Please enter a password.";
    }
    elseif(!($input_password))
    {
        $password_err = "Please enter a valid password.";
    }
    else
    {
        $password = $input_password;
    }

    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($password_err))
    {
        // Prepare an update statement
        $sql = "UPDATE user SET Name=?, Email=?, Password=? WHERE ID=?";

        if($stmt = mysqli_prepare($connection, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $password, $param_id);
            
            // Set parameters
            $name       = $name;
            $email      = $email;
            $password   = $password;
            $param_id   = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            }
            else
            {
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
}
else
{
    // Check existence of id parameter before processing further
    if(isset($_GET["ID"]) && !empty(trim($_GET["ID"])))
    {
        // Get URL parameter
        $id =  trim($_GET["ID"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM user WHERE ID = ?";
        if($stmt = mysqli_prepare($connection, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1)
                {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name       = $row["Name"];
                    $email      = $row["Email"];
                    $password     = $row["Password"];

                }
                else
                {
                    // URL doesn't contain valid id. Redirect to error page
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
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,700">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    
   <!-- add style css -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="container">
        <div class="signup-form">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>

                    <p>Please fill this form and submit to add user information the database.</p>
                    <form action="<?= htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?= (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="Name" class="form-control" value="<?= $name; ?>">
                            <span class="help-block"><?= $name_err;?></span>
                        </div>

                        <div class="form-group <?= (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="Email" class="form-control" value="<?= $email; ?>">
                            <span class="help-block"><?= $email_err;?></span>
                        </div>
                                                                      
                        <div class="form-group <?= (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="text" name="Password" class="form-control" value="<?= $password; ?>">
                            <span class="help-block"><?= $password_err;?></span>
                        </div>

                        <input type="hidden" name="ID" value="<?= $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default" style="color:red;">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>