<?php

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name     = $position     = $office     = $age     = $start_date     = $salary     = "";
$name_err = $position_err = $office_err = $age_err = $start_date_err = $salary_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name))
    {
        $name_err = "Por favor insira um nome.";
    }
    elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Por favor, indique um nome válido.";
    }
    else
    {
        $name = $input_name;
    }

    // Validate position
    $input_position = trim($_POST["position"]);
    if(empty($input_position))
    {
        $position_err = "Por favor, insira uma posição.";
    }
    elseif(!($input_position))
    {
        $position_err = "Por favor, insira uma posição válida.";
    }
    else
    {
        $position = $input_position;
    }

    // Validate office
    $input_office = trim($_POST["office"]);
    if(empty($input_office))
    {
        $office_err = "Por favor, insira um escritório.";
    }
    elseif(!($input_office))
    {
        $office_err = "Please enter a valid office.";
    }
    else
    {
        $office = $input_office;
    }

    // Validate age
    $input_age = trim($_POST["age"]);
    if(empty($input_age))
    {
        $age_err = "Por favor insira a idade.";     
    } 
    elseif(!($input_age))
    {
        $age_err = "Insira um valor inteiro positivo.";
    }
    else
    {
        $age = $input_age;
    }

    // Validate date
    $input_start_date = trim($_POST["start_date"]);
    if(empty($input_start_date))
    {
        $start_date_err = "Por favor, insira a data de início do jogo.";     
    } 
    elseif(!($input_start_date))
    {
        $start_date_err = "Insira um valor inteiro positivo.";
    }
    else
    {
        $start_date = $input_start_date;
    }
    
    // Validate salary
    $input_salary = trim($_POST["salary"]);
    if(empty($input_salary))
    {
        $salary_err = "Por favor, insira o valor do salário.";     
    } 
    elseif(!ctype_digit($input_salary))
    {
        $salary_err = "Insira um valor inteiro positivo.";
    }
    else
    {
        $salary = $input_salary;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($position_err) && empty($office_err) && empty($age_err) && empty($start_date_err) && empty($salary_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, position, office, age, start_date, salary) VALUES (?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($conection_db, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $name, $position, $office, $age, $start_date, $salary);
            
            // Set parameters
            $name       = $name;
            $position   = $position;
            $office     = $office;
            $age        = $age;
            $start_date = $start_date;
            $salary     = $salary;
            $param_id   = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: bem_vindo.php");
                exit();
            }
            else
            {
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close conection_db
    mysqli_close($conection_db);
}
?>

<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
    <style>
        .help-block{
            color:red;
        }
    </style>
		<div id="wrapper">
            <!-- nav -->
            <?php include_once 'sidebar/nav_form.php';?>
			<!-- end nav -->
			<div id="page-wrapper" class="gray-bg dashbard-1">
                <!-- navbar -->
                <?php include_once 'sidebar/navbar.php';?>
                <!-- end navbar -->
				<div class="wrapper wrapper-content">
                    <div class="signup-form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-header">
                                    <h2>Criar registro</h2>
                                </div>
                                <p>Preencha este formulário e envie para adicionar o registro do jogador ao banco de dados.</p>
                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="form-group <?= (!empty($name_err)) ? 'has-error' : ''; ?>">
                                        <label>Nome</label>
                                        <input type="text" name="name" class="form-control" value="<?= $name; ?>">
                                        <span class="help-block"><?= $name_err;?></span>
                                    </div>
                                    <div class="form-group <?= (!empty($position_err)) ? 'has-error' : ''; ?>">
                                        <label>Posição</label>
                                        <input type="text" name="position" class="form-control" value="<?= $position; ?>">
                                        <span class="help-block"><?= $position_err;?></span>
                                    </div>
                                    <div class="form-group <?= (!empty($office_err)) ? 'has-error' : ''; ?>">
                                        <label>Escritorio</label>
                                        <input type="text" name="office" class="form-control" value="<?= $office; ?>">
                                        <span class="help-block"><?= $salary_err;?></span>
                                    </div>
                                    <div class="form-group <?= (!empty($age_err)) ? 'has-error' : ''; ?>">
                                        <label>Idade</label>
                                        <input type="number" name="age" class="form-control" value="<?= $age; ?>">
                                        <span class="help-block"><?= $age_err;?></span>
                                    </div>
                                    <div class="form-group<?= (!empty($start_date_err)) ? 'has-error' : ''; ?>">
                                        <label>Data inicio</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= $start_date; ?>">
                                        <span class="help-block"><?= $start_date_err;?></span>
                                    </div>
                                    <div class="form-group <?= (!empty($salary_err)) ? 'has-error' : ''; ?>">
                                        <label>Salario</label>
                                        <input type="text" name="salary" class="form-control" value="<?= $salary; ?>">
                                        <span class="help-block"><?= $salary_err;?></span>
                                    </div>
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                    <a href="bem_vindo.php" class="btn btn-default" style="color:red;">Cancelar</a>
                                </form>
                            </div>
                        </div>        
                    </div>
                            
                </div>
            </div>
                <!-- foodter -->
                <?php include_once 'foodter/foodter.php';?>
				<!-- end foodter -->
			</div>
            <!-- end chart -->
            <?php include_once 'script/js.php';?>
		</div>
	</body>
</html>

