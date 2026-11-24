<?php
//credenciais
$servidor = "localhost";
$usuario = "root";
$senha = "Eu_xz2010";
$banco = "sobrepatas";

//conectando
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

$conexao->set_charset("utf8mb4");

?>
