<?php
session_start();
session_unset();
session_destroy();

// Excluir cookies de autenticação
setcookie("ID", "", time() - 3600, "/");
setcookie("TOKEN", "", time() - 3600, "/");
setcookie("SECURE", "", time() - 3600, "/");

?>
