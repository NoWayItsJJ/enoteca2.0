<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<html>
    <head>
        <title>Visualizza</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
        <div class="container">
            <h1>Scegli quali articoli visualizzare:</h1>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="TUTTO" onclick="location.href='cliente.php'">
            </div>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="CENTRI" onclick="location.href='scegliCentro.php'">
            </div>
            <div class="megaButtonContainer">
                <input type="button" class="megaButton" name="visualizzaTutti" value="TIPOLOGIE" onclick="location.href='scegliTipologia.php'">
            </div>
        </div>
    </body>
</html>