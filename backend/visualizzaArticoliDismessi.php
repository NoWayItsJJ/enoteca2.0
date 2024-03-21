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
            <input type="button" name="login" value="Torna agli articoli" onclick="location.href='visualizzaArticoli.php'">
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
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                    FROM articoli_dismessi a JOIN centri c 
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
                                    <button class="btn" type="button" onclick="location.href=\'ripristina_articolo.php?id='.$row["id_articolo"].'\'">Ripristina</button>
                                </td>
                            </tr>'; //pensare di implementare un popup di conferma riprsitino
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
<?php $conn->close();?>
</html>