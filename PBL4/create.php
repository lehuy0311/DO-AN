<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name     = $email = $password =  "";
$name_err = $email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate name
    $input_name = trim($_POST["name"]);
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
    $input_email = trim($_POST["email"]);
    if(empty($input_email))
    {
        $email_err = "Please enter the email.";     
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
    $input_password = trim($_POST["password"]);
    if(empty($input_password))
    {
        $password_err = "Please enter the password.";     
    } 
    elseif(!($input_password))
    {
        $password_err = "Please enter a valid password";
    }
    else
    {
        $password = $input_password;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($email_err) && empty($password_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO user (name, email, password) VALUES (?,?,?)";
         
        if($stmt = mysqli_prepare($connection, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);
            
            // Set parameters
            $name       = $name;
            $email      = $email;
            $password   = $password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
   <link rel="stylesheet" href="css/css-create-style.css">

</head>

<body>
    <div class="container">
        <div class="signup-form">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add user to the database.</p>
                    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?= (!empty($name_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $name; ?>">
                            <span class="help-block"><?= $name_err;?></span>
                        </div>
                        
                        <div class="form-group<?= (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?= $email; ?>">
                            <span class="help-block"><?= $email_err;?></span>
                        </div>

                        <div class="form-group <?= (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" value="<?= $password; ?>">
                            <span class="help-block"><?= $password_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default" style="color:red;">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
