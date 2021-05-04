<?php
// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate email
    if(empty(trim($_POST["email"])))
    {
        $email_err = "Por favor insira um email.";
    }
        else
    {
        // Prepare a select statement
        $sql = "SELECT id FROM usuario WHERE email = ?";
        
        if($stmt = mysqli_prepare($conection_db, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $email_err = "Este email já existe.";
                }
                    else
                {
                    $email = trim($_POST["email"]);
                }
            }
                else
            {
                echo "Ups! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["senha"])))
    {
        $password_err = "Por favor insira uma senha.";     
        }
            elseif
            (strlen(trim($_POST["senha"])) < 6)
        {
        $password_err = "A senha deve ter pelo menos 6 caracteres.";
    }
        else
    {
        $password = trim($_POST["senha"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmar_senha"])))
    {
        $confirm_password_err = "Por favor confirma a sua senha.";     
    }
        else
    {
        $confirm_password = trim($_POST["confirmar_senha"]);
        if(empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "A senha não confere.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err))
    {
        // Prepare an insert statement
        $sql = "INSERT INTO usuario (email, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($conection_db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);
            
            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Redirect to login page
                header("location: login.php");
            } 
                else
            {
                echo "Algo deu errado. Por favor, tente novamente mais tarde.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($conection_db);
}