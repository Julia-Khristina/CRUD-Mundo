<?php
session_start();

// Remove todos os dados da sessão
session_unset();

session_destroy();

header("Location: ./Index.php");
exit();
?>
