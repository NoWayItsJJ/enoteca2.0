<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: ../logindenied.php");
}

$id = $_SESSION['id_utente'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Amministrazione</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
</head>
<body>
    <div class="button-container">
        <div class="top-left-container">
            <input type="button" name="logout" value="Logout" onclick="location.href='../logout.php'">
            <input type="button" name="login" value="Torna alla scelta" onclick="location.href='sceltaAdmin.php'">
        </div>
        <div class="top-right-container">
            <input type="button" name="loans" value="Articoli dismessi" onclick="location.href='visualizzaArticoliDismessi.php'">
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
                    <th>Prestito</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                    FROM articoli a JOIN centri c 
                                    ON a.fk_id_centro = c.id_centro
                                    JOIN categorie cat 
                                    ON a.fk_id_categoria = cat.id_categoria
                                    ORDER BY tipologia";

                    require_once '../db.php';
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
                        $isAvailable = ($stato == "disponibile" || $stato == "in prestito") ? 1 : 0;
                        $isLoaned = ($stato == "in prestito") ? 1 : 0;
                        $isBooked = ($stato == "prenotato") ? 1 : 0;

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
                                <button class="btn" type="button" onclick="location.href=\'prestito_articolo.php?id='.$row["id_articolo"].'&loaned='. $isLoaned .'\'" '. ($isAvailable == 1 ? "" : "disabled") . '>'.($isLoaned == 0 ? "Prestito" : "Restituzione").'</button>
                                </td>
                                <td class="colonnaTasti">
                                    <button class="btn" type="button" onclick="location.href=\'modifica_articolo.php?id='.$row["id_articolo"].'\'" '. (($isLoaned == 1 || $isBooked == 1) ? "disabled" : "") . '>Modifica</button>
                                    <button class="btn" type="button" onclick="location.href=\'dismetti_articolo.php?id='.$row["id_articolo"].'\'" '. (($isLoaned == 1 || $isBooked == 1) ? "disabled" : "") . '>Dismetti</button>
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