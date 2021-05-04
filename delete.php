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
// process delete operation after confirmation
if(isset($_POST['id']) && !empty($_POST['id']))
{
    // include config connection db
    include_once 'config.php';

    // Prepare a delete statement
    $sql = "DELETE FROM employees WHERE id =?";
    if($stmt = mysqli_prepare($conection_db,  $sql))
    {
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // set parameters
        $param_id = trim($_POST['id']);

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt))
        {
            //  Records delete successfully. Redirect to landing page
            header("location:bem_vindo.php");
            exit();
        }
        else
        {
            echo "Ops! Algo deu errado. Tente novamente mais tarde.";
        }
    }
    // close statement
    mysqli_stmt_close($stmt);

    // close connection
    mysqli_close($conection_db);
}  
    else
{
      // Check existence of id parameter
        if(empty(trim($_GET['id'])))
        {
            // URL doesn't contain id parameter. Redirect to error page
            header("location:erro.php");
            exit();
        }
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ver registro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
                        <h1>Apagar Registro</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Tem certeza que deseja excluir este registro?</p><br>
                            <p>
                                <input type="submit" value="Sim" class="btn btn-danger">
                                <a href="bem_vindo.php" class="btn btn-default">Não</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


