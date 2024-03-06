<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}

$id = $_SESSION['id_utente'];

$servername = "localhost";
                        $username = "root"; // Sostituisci con il tuo nome utente del database
                        $password = ""; // Sostituisci con la tua password del database
                        $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                        $conn = new mysqli($servername, $username, $password, $dbname);

$nomeSql = "SELECT nome FROM utenti WHERE id_utente = $id";
$result = $conn->query($nomeSql);
while($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $nome = $row['nome'];
}
?>

<html>
    <head>
        <title>Le mie prenotazioni</title>
        <link rel="stylesheet" href="styles.css" type="text/css">
    </head>
    <body>
        <input type="button" name="login" value="Indietro" onclick="location.href='cliente.php'">
        <div style="width: 100%; display: flex;
                    justify-content: center;
                    font-size:x-large;">
            <h1>I prestiti di <?php echo $nome?></h1>
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
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                </tr>
                </thead>
                <tbody>
                    <?php

                        $servername = "localhost";
                        $username = "root"; // Sostituisci con il tuo nome utente del database
                        $password = ""; // Sostituisci con la tua password del database
                        $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Get the ID received via POST method
                        $id = $_GET['id'];

                        // Prepare and execute the query
                        $selectSql = "SELECT numero_inventario, tipologia, categoria, articolo, nome, citta, indirizzo, data_inizio, data_fine FROM prestiti
                                    JOIN articoli ON prestiti.fk_id_articolo = articoli.id_articolo
                                    JOIN categorie ON articoli.fk_id_categoria = categorie.id_categoria
                                    JOIN centri ON articoli.fk_id_centro = centri.id_centro
                                    WHERE fk_id_utente = $id";

                        $result = $conn->query($selectSql);

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
                            $data_fine = $row['data_fine']; //chiedere a piazza se data fine può essere null

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
                                    <td class="colonnaData">'.$data_fine.'</td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        </div>
    </body>
</html>