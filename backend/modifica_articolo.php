<?php
session_start();

require_once '../db.php';

// Recupera l'ID dalla query string
if(isset($_GET["id"]))
{
    $id = $_GET['id'];
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
    <title>Modifica articolo</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
</head>
<body>
    <input type="button" name="login" value="Chiudi" onclick="location.href='visualizzaArticoli.php'">
    <div class="container">
        <div class="login-box">
            <h2>Modifica articolo:</h2>
            
            <form method="post" action="salva_modifiche_articolo.php">
                
                <div class="user-box"><input type="text" name="numeroInventario" <?php echo "value=".$articoloRow["numero_inventario"]?> required><label>Numero Inventario</label></div>
                <div class="user-box"><input type="text" name="articolo" <?php echo "value='". $articoloRow['articolo'] ."'"?> required><label>Articolo</label></div>
                <div class="user-box">
                    <select class="select" name="stato" required>
                    <option value="disponibile" <?php if($stato==='disponibile') echo 'selected="selected"';?>>Disponibile</option>
                    <option value="in prestito" <?php if($stato==='in prestito') echo 'selected="selected"';?>>In prestito</option>
                    <option value="prenotato" <?php if($stato==='prenotato') echo 'selected="selected"';?>>Prenotato</option>
                    <option value="guasto" <?php if($stato==='guasto') echo 'selected="selected"';?>>Guasto</option>
                    </select>
                </div>
                <div class="user-box">
                    <select class="select" name="categoria" required>
                    <?php 
                        require_once '../db.php';
                        $categoriaSql = "SELECT id_categoria, categoria, tipologia FROM categorie";
                        $categoriaResult = $conn->query($categoriaSql);
                        while($categoriaRow = $categoriaResult->fetch_array(MYSQLI_ASSOC)) {
                            $selectedCategoria = ($id_categoria == $categoriaRow['id_categoria']) ? 'selected="selected"' : '';
                            echo "<option value=".$categoriaRow['id_categoria']." ".$selectedCategoria .">".$categoriaRow['tipologia']." - ".$categoriaRow['categoria']."</option>";
                        }
                    ?>
                    </select>
                </div>
                <div class="user-box">
                    <select class="select" name="centro" required>
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