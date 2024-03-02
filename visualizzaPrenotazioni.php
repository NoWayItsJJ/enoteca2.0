<html>
    <head>
        <title>Le mie prenotazioni</title>
        <link rel="stylesheet" href="styles.css" type="text/css">
    </head>
    <body>
        <input type="button" name="login" value="Indietro" onclick="location.href='cliente.php'">
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

                        $servername = "localhost";
                        $username = "root"; // Sostituisci con il tuo nome utente del database
                        $password = ""; // Sostituisci con la tua password del database
                        $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Get the ID received via POST method
                        $id = $_GET['id'];

                        // Prepare and execute the query
                        $selectSql = "SELECT id_prenotazione, numero_inventario, tipologia, categoria, articolo, nome, citta, indirizzo, data_inizio FROM prenotazioni
                                    JOIN articoli ON prenotazioni.fk_id_articolo = articoli.id_articolo
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