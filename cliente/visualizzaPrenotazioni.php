<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: ../logindenied.php");
}

$id = $_SESSION['id_utente'];

require_once "../db.php";

$nomeSql = "SELECT nome FROM utenti WHERE id_utente = $id";
$result = $conn->query($nomeSql);
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $nome = $row['nome'];
}
?>

<html>
    <head>
        <title>Le mie prenotazioni</title>
        <link rel="stylesheet" href="../style/styles.css" type="text/css">
    </head>
    <body>
        <input type="button" name="login" value="Indietro" onclick="location.href='cliente.php'">
        <div style="width: 100%; display: flex;
                    justify-content: center;
                    font-size:x-large;">
            <h1>Le prenotazioni di <?php echo $nome?></h1>
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
                    <th>Centro</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>Data</th>
                    <th>Annulla la prenotazione</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        // Get the ID received via POST method
                        $id = $_GET['id'];

                        // Prepare and execute the query
                        $selectSql = "SELECT id_prenotazione, numero_inventario, tipologia, categoria, articolo, nome, citta, indirizzo, data_inizio FROM prenotazioni
                                    JOIN articoli ON prenotazioni.fk_id_articolo = articoli.id_articolo
                                    JOIN categorie ON articoli.fk_id_categoria = categorie.id_categoria
                                    JOIN centri ON articoli.fk_id_centro = centri.id_centro
                                    WHERE fk_id_utente = $id";

                        $result = $conn->query($selectSql);
                        $conn->close();

                        while($row = $result->fetch_array(MYSQLI_ASSOC))
                            {
                            $n_inventario = $row['numero_inventario'];
                            $tipologia = $row['tipologia'];
                            $categoria = $row['categoria'];
                            $articolo = $row['articolo'];
                            $nome = $row['nome'];
                            $citta = $row['citta'];
                            $indirizzo = $row['indirizzo'];
                            $data_inizio = $row['data_inizio'];

                            echo
                                '<tr>
                                    <td class="colonnaNumero">'.$n_inventario.'</td>
                                    <td class="colonnaTipo">'.$tipologia.'</td>
                                    <td class="colonnaCategoria">'.$categoria.'</td>
                                    <td class="colonnaArticolo">'.$articolo.'</td>
                                    <td class="colonnaNome">'.$nome.'</td>
                                    <td class="colonnaCitta">'.$citta.'</td>
                                    <td class="colonnaIndirizzo">'.$indirizzo.'</td>
                                    <td class="colonnaData">'.$data_inizio.'</td>
                                    <td class="colonnaTasti">
                                        <button class="btn" type="button" onclick="location.href=\'annullaPrenotazione.php?id='.$row["id_prenotazione"].'\'">Annulla</button>
                                    </td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </body>
</html>