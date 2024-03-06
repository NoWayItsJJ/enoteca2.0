<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}
// elimina le variabili di sessione impostate
$_SESSION = array();
// elimina la sessione
session_destroy();
header("Location: index.php");
?>