<?php
/* Credenciais do banco de dados. Supondo que você esteja executando o MySQL
servidor com configuração padrão (usuário 'root' sem senha) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'cadastro_jogoo');
 
/* Tentativa de conexão com o banco de dados MySQL */
$conection_db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($conection_db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>