<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || ($_SESSION['tipo_utente'] != "operatore") && ($_SESSION['tipo_utente'] != "admin")) {
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
    </div>
    <div class="container">
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Articolo</th>
                    <th>Numero di inventario</th>
                    <th>Centro</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                    <th>Data di inizio</th>
                    <th>Data di fine</th>
                </tr>
                </thead>
                <tbody>
                <?php

                    $selectSql = "SELECT id_articolo, numero_inventario, articolo, c.nome as centro, citta, c.indirizzo, u.nome as nome, cognome, data_inizio, data_fine
                                FROM prestiti p 
                                JOIN articoli a ON p.fk_id_articolo = a.id_articolo
                                JOIN centri c ON a.fk_id_centro = c.id_centro
                                JOIN utenti u ON p.fk_id_utente = u.id_utente
                                UNION
                                SELECT id_articolo2, numero_inventario, articolo, c.nome as centro, citta, c.indirizzo, u.nome as nome, cognome, data_inizio, data_fine
                                FROM prestiti p
                                JOIN articoli_dismessi d ON p.fk_id_articolo = d.id_articolo2
                                JOIN centri c ON d.fk_id_centro = c.id_centro
                                JOIN utenti u ON p.fk_id_utente = u.id_utente
                                ORDER BY data_inizio DESC";

                    require_once '../db.php';
                    $result = $conn->query($selectSql);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        $nome = $row['nome'];
                        $cognome = $row['cognome'];
                        $n_inventario = $row['numero_inventario'];
                        $articolo = $row['articolo'];
                        $centro = $row['centro'];
                        $citta = $row['citta'];
                        $indirizzo = $row['indirizzo'];
                        $data_inizio = $row['data_inizio'];
                        $data_fine = ($row['data_fine']) ? $row['data_fine'] : 'In prestito';

                        echo
                            '<tr>
                                <td class="colonnaNome">'.$nome.'</td>
                                <td class="colonnaCognome">'.$cognome.'</td>
                                <td class="colonnaArticolo">'.$articolo.'</td>
                                <td class="colonnaNumero">'.$n_inventario.'</td>
                                <td class="colonnaNome">'.$centro.'</td>
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
<?php $conn->close();?>
</html>