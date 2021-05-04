<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
 
// Include config file
require_once "config.php";
require_once "php_redefinir_senha.php";
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Cadastro jogo</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- --------------style css --------------->
<link rel="stylesheet" href="assets/styles.css">

</head>
<body>
<div class="login-form">
    <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <div class="text-center">
            <a href="index.html" aria-label="Space">
                <img class="mb-3" src="assets/image/logo.png" alt="Logo" width="60" height="60">
            </a>
          </div>
        <div class="text-center mb-4">
            <h1 class="h3 mb-0">Redefinir senha</h1>
            <p>Por favor, preencha este formulário para redefinir sua senha.</p>
        </div>
		<div class="form-group" <?= (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-lock"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="nova_senha" placeholder="Nova Senha" value="<?= $new_password; ?>">				
            </div>
            <span class="help-block"><?= $new_password_err; ?></span>
        </div> 
        <div class="form-group"<?= (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-key"></i>
                    </span>                    
                </div>
                <input type="password" class="form-control" name="confirmar_senha" placeholder="Confirmar Senha" value="<?= $confirm_password; ?>">				
            </div>
            <span class="help-block"><?= $confirm_password_err; ?></span>
        </div>          
        <div class="row">
            <div class="col-6">
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary login-btn btn-block">Redefinir senha</button>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <a class="btn btn-primary login-btn btn-block" href="bem_vindo.php">Cancelar</a>
                </div>
            </div>
        </div>
        <div class="or-seperator"><i>OR</i></div>
        <p class="small text-center text-muted mb-0">São reservados ao site de jogos. ©  2021 </p>
    </form>
</div>

</body>
</html>