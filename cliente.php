<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Cliente</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div class="button-container">
        <div class="top-left-container">
            <input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
            <input type="button" name="login" value="Torna alla visualizzazione" onclick="location.href='visualizza.php'">
        </div>
        <div class="top-right-container">
            <input type="button" name="bookings" value="Le mie prenotazioni" onclick="location.href='visualizzaPrenotazioni.php?id= <?php echo $id?> '">
            <input type="button" name="loans" value="I miei prestiti" onclick="location.href='visualizzaPrestiti.php?id= <?php echo $id?> '">
        </div>
    </div>
    <div class="container">
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <tr>
                    <th>Numero di inventario</th>
                    <th>Tipologia</th>
                    <th>Categoria</th>
                    <th>Articolo</th>
                    <th>Stato</th>
                    <th>Centro</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>Prenotalo</th>
                </tr>
                </thead>
                <tbody>
                <?php

                    if(isset($_GET['idCentro']))
                    {
                        $idCentro = $_GET['idCentro'];
                    }

                    if(isset($_GET['idCategoria']))
                    {
                        $idCategoria = $_GET['idCategoria'];
                    }

                    if(isset($idCentro))
                    {
                        $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                FROM articoli a JOIN centri c 
                                ON a.fk_id_centro = c.id_centro
                                JOIN categorie cat 
                                ON a.fk_id_categoria = cat.id_categoria
                                WHERE fk_id_centro = $idCentro
                                ORDER BY tipologia ASC";
                    }
                    else if(isset($idCategoria))
                    {
                        $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                    FROM articoli a JOIN centri c 
                                    ON a.fk_id_centro = c.id_centro
                                    JOIN categorie cat 
                                    ON a.fk_id_categoria = cat.id_categoria
                                    WHERE fk_id_categoria = $idCategoria";
                    }
                    else
                    {
                        $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                    FROM articoli a JOIN centri c 
                                    ON a.fk_id_centro = c.id_centro
                                    JOIN categorie cat 
                                    ON a.fk_id_categoria = cat.id_categoria
                                    ORDER BY tipologia";
                    }

                    require_once 'db.php';
                    $result = $conn->query($selectSql);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        $n_inventario = $row['numero_inventario'];
                        $tipologia = $row['tipologia'];
                        $categoria = $row['categoria'];
                        $articolo = $row['articolo'];
                        $stato = $row['stato'];
                        $nome = $row['nome'];
                        $citta = $row['citta'];
                        $indirizzo = $row['indirizzo'];
                        $isAvailable = ($stato == "disponibile") ? 1 : 0;

                        echo
                            '<tr>
                                <td class="colonnaNumero">'.$n_inventario.'</td>
                                <td class="colonnaTipo">'.$tipologia.'</td>
                                <td class="colonnaCategoria">'.$categoria.'</td>
                                <td class="colonnaArticolo">'.$articolo.'</td>
                                <td class="colonnaStato">'.$stato.'</td>
                                <td class="colonnaNome">'.$nome.'</td>
                                <td class="colonnaCitta">'.$citta.'</td>
                                <td class="colonnaIndirizzo">'.$indirizzo.'</td>
                                <td class="colonnaTasti">
                                    <button class="btn" type="button" onclick="location.href=\'prenota.php?id='.$row["id_articolo"].'\'" '. ($isAvailable == 1 ? "" : "disabled") . '>Prenota</button>
                                </td>
                            </tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php $conn->close();?>
</html>