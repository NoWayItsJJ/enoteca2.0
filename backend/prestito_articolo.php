<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || ($_SESSION['tipo_utente'] != "operatore") && ($_SESSION['tipo_utente'] != "admin")) {
    header("Location: ../logindenied.php");
}

require_once '../db.php';

// Recupera l'ID dalla query string
if(isset($_GET["id"]))
{
    $id = $_GET['id'];
}

if(isset($_GET["loaned"]))
{
    $loaned = $_GET['loaned'];
}

require_once '../db.php';

// Query SQL per selezionare il record corrispondente all'ID
$articoloSql = "SELECT id_articolo, numero_inventario, articolo, stato, fk_id_categoria, fk_id_centro FROM articoli WHERE id_articolo = $id";
$articoloResult = $conn->query($articoloSql);
$articoloRow = $articoloResult->fetch_array(MYSQLI_ASSOC);

$numero_inventario = $articoloRow['numero_inventario'];
$articolo = $articoloRow['articolo'];
$stato = $articoloRow['stato'];
$id_categoria = $articoloRow['fk_id_categoria'];
$id_centro = $articoloRow['fk_id_centro'];
?>

<html>
<head>
    <title>Prestito articolo</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
    <link rel="stylesheet" href="../style/prenotaStyle.css" type="text/css">
</head>
<body>
    <input type="button" name="login" value="Chiudi" onclick="location.href='visualizzaArticoli.php'">
    <div class="container">
        <div class="date-selection">
            <h1>Seleziona la data <?php echo ($loaned == 1) ? "di restituzione" : "di prestito" ?></h1>
            <form method="POST" action="salva_prestito.php">
                <input type="date" name="selected_date">
                <?php
                    if($loaned == 0)
                    {
                        echo '<select name="loanUser" class="select">
                        <option value="0">Seleziona l\'utente</option>';
                        
                        $utentiSql = "SELECT id_utente, nome, cognome FROM utenti WHERE tipo_utente = 'Cliente'";
                        $utentiResult = $conn->query($utentiSql);
                        while($utentiRow = $utentiResult->fetch_array(MYSQLI_ASSOC))
                        {
                            echo "<option value=" . $utentiRow['id_utente'] . ">" . $utentiRow['nome'] . " " . $utentiRow['cognome'] . "</option>";
                        }
                        echo '</select>';
                    }
                ?>
                <input type="hidden" name="id_articolo" <?php echo "value=" . $id ?>>
                <input type="hidden" name="loaned" <?php echo "value=" . $loaned ?>>
                <input type="submit" value="Invia">
            </form>
        </div>
    </div>
</body>
</html>