<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
    header("Location: logindenied.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Operatore</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>

<input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
<div class="container">
    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Tipo di ticket</th>
                <th>Titolo</th>
                <th>Descrizione</th>
                <th>Urgente</th>
                <th>Risolto</th>
                <th>Azioni</th>
            </tr>
            </thead>
            <tbody>
            <?php

                //ANCORA TUTTO DA FARE

                $servername = "localhost";
                $username = "root"; // Sostituisci con il tuo nome utente del database
                $password = ""; // Sostituisci con la tua password del database
                $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                $conn = new mysqli($servername, $username, $password, $dbname);
                $selectSql = "SELECT * FROM `ticket`";
                $result = $conn->query($selectSql);
                while($row = $result->fetch_array(MYSQLI_ASSOC))
                {
                    $id_cliente = $row['fk_id_utente'];
                    $tipo_out = $row['tipo_ticket'];
                    $titolo_out = $row['titolo'];
                    $descrizione_out = $row['descrizione'];
                    $urgente_check = $row['urgente'];
                    $risolto_check = $row['risolto'];
                    $urgente_out = ($urgente_check == 1) ? "&#10003;": "&#10007;";
                    $risolto_out = ($risolto_check == 1) ? "&#10003;": "&#10007;";

                    echo
                        '<tr>
                            <td class="colonnaId">'.$id_cliente.'</td>
                            <td class="colonnaTipo">'.$tipo_out.'</td>
                            <td class="colonnaTitolo">'.$titolo_out.'</td>
                            <td class="colonnaDescrizione">'.$descrizione_out.'</td>
                            <td class="colonnaCheck">'.$urgente_out.'</td>
                            <td class="colonnaCheck">'.$risolto_out.'</td>
                            <td class="colonnaTasti">
                                <a class="btn" href="modifica_ticket.php?id='.$row["id"].'">Modifica</a>
                                <a class="btn" href="elimina_ticket.php?id='.$row["id"].'">Elimina</a>
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