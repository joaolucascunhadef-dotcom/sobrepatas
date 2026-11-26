<?php
session_start();
// Destri todas as variáveis da sessão
$_SESSION = array();
// Destri a sessão
session_destroy();
// Redireciona de volta para a página principal
header("Location: index.php");
exit;
?>