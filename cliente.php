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
    <input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
    <div class="container">
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <tr>
                    <th>Numero di inventario</th>
                    <th>Tipologia</th>
                    <th>Categoria</th>
                    <th>Stato</th>
                    <th>Centro</th>
                    <th>Città</th>
                    <th>Indirizzo</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $servername = "localhost";
                    $username = "root"; // Sostituisci con il tuo nome utente del database
                    $password = ""; // Sostituisci con la tua password del database
                    $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, stato, nome, citta, indirizzo
                                FROM articoli a JOIN centri c 
                                ON a.fk_id_centro = c.id_centro
                                JOIN categorie cat 
                                ON a.fk_id_categoria = cat.id_categoria";
                    $result = $conn->query($selectSql);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        $n_inventario = $row['numero_inventario'];
                        $tipologia = $row['tipologia'];
                        $categoria = $row['categoria'];
                        $stato = $row['stato'];
                        $nome = $row['nome'];
                        $citta = $row['citta'];
                        $indirizzo = $row['indirizzo'];

                        echo
                            '<tr>
                                <td class="colonnaNumero">'.$n_inventario.'</td>
                                <td class="colonnaTipo">'.$tipologia.'</td>
                                <td class="colonnaCategoria">'.$categoria.'</td>
                                <td class="colonnaStato">'.$stato.'</td>
                                <td class="colonnaNome">'.$nome.'</td>
                                <td class="colonnaCitta">'.$citta.'</td>
                                <td class="colonnaIndirizzo">'.$indirizzo.'</td>
                                <td class="colonnaTasti">
                                    <a class="btn" href="prenota.php?id='.$row["id_articolo"].'">Prenota</a>
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