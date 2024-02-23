<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<html>
    <head>
        <title>Scegli centro</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
        <div class="container">
            <h1>Scegli la tipologia da visualizzare:</h1>
            <?php 
                $servername = "localhost";
                $username = "root"; // Sostituisci con il tuo nome utente del database
                $password = ""; // Sostituisci con la tua password del database
                $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                $conn = new mysqli($servername, $username, $password, $dbname);
                $selectSql = "SELECT DISTINCT * FROM categorie";
                $result = $conn->query($selectSql);
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $stringa = $row['tipologia'] . " - " . $row['categoria'];
                    $idCategoria = $row['id_categoria'];
                    echo '<div class="megaButtonContainer">
                        <input type="button" class="megaButton" value="' . $stringa . '" onclick="location.href=\'cliente.php?idCategoria=' . $idCategoria . '\'">
                        </div>';
                }
            ?>
        </div>
    </body>
</html>