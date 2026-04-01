<?php
session_start(); // inicia a sessao para saber qual ira derrubar
session_unset(); // limpa o cache da sessao
session_destroy(); // destroi a sessao 

header("Location: ../home/index.php");
exit();
?>