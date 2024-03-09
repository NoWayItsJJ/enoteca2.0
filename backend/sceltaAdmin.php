<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || $_SESSION['tipo_utente'] != "admin") {
    header("Location: ../logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<html>
    <head>
        <title>Amministrazione</title>
        <link rel="stylesheet" href="../style/styles.css">
    </head>
    <body>
        <input type="button" name="logout" value="Logout" onclick="location.href='../logout.php'">
        <div class="container">
            <h1>Scegli quale tabella visualizzare:</h1>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="ARTICOLI" onclick="location.href='visualizzaArticoli.php'">
            </div>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="PRESTITI" onclick="location.href='visualizzaPrestiti.php'">
            </div>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="PRENOTAZIONI" onclick="location.href='visualizzaPrenotazioni.php'">
            </div>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="UTENTI" onclick="location.href='visualizzaUtenti.php'">
            </div>
        </div>
    </body>
</html>