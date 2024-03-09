<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: ../logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<html>
    <head>
        <title>Scegli centro</title>
        <link rel="stylesheet" href="../style/styles.css">
    </head>
    <body>
        <input type="button" name="logout" value="Logout" onclick="location.href='../logout.php'">
        <div class="container">
            <h1>Scegli il centro da visualizzare:</h1>
            <?php 
                require_once "../db.php";
                $selectSql = "SELECT DISTINCT * FROM centri";
                $result = $conn->query($selectSql);
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $stringa = $row['nome'] . " - " . $row['citta'] . " - " . $row['indirizzo'];
                    $idCentro = $row['id_centro'];
                    echo '<div class="megaButtonContainer">
                        <input type="button" class="megaButton" value="' . $stringa . '" onclick="location.href=\'cliente.php?idCentro=' . $idCentro . '\'">
                        </div>';
                }
            ?>
        </div>
    </body>
</html>