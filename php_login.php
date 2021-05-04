<?php
// Define variables and initialize with empty values
$email = $password          = "";
$email_err = $password_err  = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Check if email is empty
    if(empty(trim($_POST["email"])))
    {
        $email_err = "Por favor digita o seu email.";
    }
        else
    {
        $email = trim($_POST["email"]);
    }
    // Check if password is empty
    if(empty(trim($_POST["senha"])))
    {
        $password_err = "Por favor, digita a sua senha.";
    }
        else
    {
        $password = trim($_POST["senha"]);
    }
    // Validar credenciais
    if(empty($email_err) && empty($password_err))
    {
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM usuario WHERE email = ?";
        if($stmt = mysqli_prepare($conection_db, $sql))
        {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1)
                {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to welcome page
                            header("location: bem_vindo.php");
                        }
                        else
                        {
                            // Display an error message if password is not valid
                            $password_err = "A senha que você digitou não era válida.";
                        }
                    }
                }
                else
                {
                    // Display an error message if email doesn't exist
                    $email_err = "Nenhuma conta encontrada com esse email.";
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
    // Close connection
    mysqli_close($conection_db);
}