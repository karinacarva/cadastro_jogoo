<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>

<?php
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"])))
    {
        // Include config file
        require_once "config.php";
        
        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
    
        if($stmt = mysqli_prepare($conection_db, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = trim($_GET["id"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                $result = mysqli_stmt_get_result($stmt);
        
                if(mysqli_num_rows($result) == 1)
                {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name       = $row["name"];
                    $position   = $row["position"];
                    $office     = $row["office"];
                    $age        = $row["age"];
                    $start_date = $row["start_date"];
                    $salary     = $row["salary"];
                
                }
                else
                {
                    // URL doesn't contain valid id parameter. Redirect to error page
                    header("location: erro.php");
                    exit();
                }
            }
            else
            {
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close conection_db
        mysqli_close($conection_db);
    }
    else
    {
        print_r($sql);
        exit();
        // URL doesn't contain id parameter. Redirect to error page
        header("location: erro.php");
        exit();
    }
?>



<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin Painel</title>
<!-- style css php -->
<?php include_once 'css_style/style.php';?>
<!-- add style css -->
<!-- end style css php -->
	<body>
		<div id="wrapper">
            <!-- nav -->
            <?php include_once 'sidebar/nav_form.php';?>
			<!-- end nav -->
			<div id="page-wrapper" class="gray-bg dashbard-1">
                <!-- navbar -->
                <?php include_once 'sidebar/navbar.php';?>
                <!-- end navbar -->
				<div class="wrapper wrapper-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-header">
                                    <h1>Ver registro</h1>
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <label>Name :<span class="font-weight-bold text text-success"> <?= $row["name"]; ?></span></label>
                                </div>
                                <div class="form-group">
                                    <label>Position : <span class="font-weight-bold"> <?= $row["position"]; ?></span></label>
                                </div>
                                <div class="form-group">
                                    <label>Office : <span class="font-weight-bold"> <?= $row["office"]; ?></span></label>
                                </div>
                                <div class="form-group">
                                    <label>Age : <span class="font-weight-bold"> <?= $row["age"]; ?></span></label>
                                </div>
                                <div class="form-group">
                                    <label>Start Date : <span class="font-weight-bold"> <?= $row["start_date"]; ?></span></label>
                                </div>
                                <div class="form-group">
                                    <label>Salary : $<span class="font-weight-bold text-info"> <?= $row["salary"]; ?></span></label>
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
	</body>
</html>

