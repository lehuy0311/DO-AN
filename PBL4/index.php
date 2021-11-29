<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data table</title>
    <!-- library css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.bootstrap4.min.css">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <br>
                <h3 class="titulo-tabla"> Users management</h3>
                <hr>
                    <?php
                        // Include config file
                        require_once "config.php";
                        
                        // Attempt select query execution
                        $sql = "SELECT * FROM user";
                    ?>
                    <?php
                    if($result = mysqli_query($connection, $sql))
                    {
                        if(mysqli_num_rows($result) > 0)
                        {
                    ?>
                            <table id="example" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>                                        
                                        <th>Email</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        while($row = mysqli_fetch_array($result))
                                        {
                                        ?>
                                        <tr>
                                            <td><?= $row['ID'] ;?></td>
                                            <td><?= $row['Name'] ;?></td>
                                            <td><?= $row['Email']; ?></td>
                                            <td><?= $row['Password'] ;?></td>
                                            <td>
                                                <?php
                                                echo "<a href='read.php?ID=". $row['ID'] ."' title='View Record' data-toggle='tooltip'> <i class='fa fa-eye' aria-hidden='true' style='color:black'></i></a>";
                                                echo "<a href='update.php?ID=". $row['ID'] ."' title='Update Record' data-toggle='tooltip'> <i class='fa fa-edit' aria-hidden='true' style='color:#3ca23c;'></i></a>";
                                                echo "<a href='delete.php?ID=". $row['ID'] ."' title='Delete Record' data-toggle='tooltip'> <i class='fa fa-trash' aria-hidden='true' style='color:red;'></i></a>";
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>                          
                            </table>
                        <?php
                            // Free result set
                            mysqli_free_result($result);
                        }
                        else
                        {
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    }
                    else
                    {
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);
                    }
 
                    // Close connection
                    mysqli_close($connection);
                    ?>
                <a href="create.php" class="btn btn-success pull-left">Add New User</a>

            </div>
        </div>
    </div>
        <!-- library js -->
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.colVis.min.js"></script>
        
       
        <!-- internal script -->
        <script src="js/export.js"></script>

</body>
</html>