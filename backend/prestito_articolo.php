<?php
session_start();

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

switch($loaned) {
    case 1:
        //zero ideeeeeeeeee
        break;
    case 0:
        $loaned = 1;
        break;
}

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
</head>
<body>
    <input type="button" name="login" value="Chiudi" onclick="location.href='visualizzaArticoli.php'">
    <div class="container">
        <div class="login-box">
            <h2>Prestito articolo:</h2>
            
            <form method="post" action="salva_prestito.php">
                <div class="user-box">
                    <select class="select" name="cliente" required>
                    <?php 
                        require_once '../db.php';
                        $centroSql = "SELECT id_centro, nome, citta FROM centri";
                        $centroResult = $conn->query($centroSql);
                        while($centroRow = $centroResult->fetch_array(MYSQLI_ASSOC)) {
                            $selectedCentro = ($id_centro == $centroRow['id_centro']) ? 'selected="selected"' : '';
                            echo "<option value=".$centroRow['id_centro']." ".$selectedCentro .">".$centroRow['nome']. " - " . $centroRow['citta'] . "</option>";
                        }
                    ?>
                    </select>
                </div>
                <div><input type="hidden" name="id" <?php echo "value=".$articoloRow["id_articolo"]?>></div>
                <input class="submit" type="submit" value="Salva modifiche">
            </form>
        </div>
    </div>
</body>
</html>