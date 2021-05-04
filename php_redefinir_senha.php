<?php
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // Validate new password
    if(empty(trim($_POST["nova_senha"])))
    {
        $new_password_err = "Por favor insira a nova senha.";     
    }
    elseif(strlen(trim($_POST["nova_senha"])) < 6)
    {
        $new_password_err = "A senha deve ter pelo menos 6 caracteres.";
    }
    else
    {
        $new_password = trim($_POST["nova_senha"]);
    }
    // Valide a confirmacao da senha
    if(empty(trim($_POST["confirmar_senha"])))
    {
        $confirm_password_err = "Por favor confirme a senha.";
    }
    else
    {
        $confirm_password = trim($_POST["confirmar_senha"]);
        if(empty($new_password_err) && ($new_password != $confirm_password))
        {
            $confirm_password_err = "A senha não confere.";
        }
    }
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err))
    {
        // Prepare an update statement
        $sql = "UPDATE usuario SET password = ? WHERE id = ?";
        if($stmt = mysqli_prepare($conection_db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Senha atualizada com sucesso. Destrua a sessão e redirecione para a página de login
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Ups! Algo deu errado. Por favor, tente novamente mais tarde.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($conection_db);
}