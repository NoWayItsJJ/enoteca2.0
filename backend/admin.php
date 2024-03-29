<?php
session_start();
if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || $_SESSION['tipo_utente'] != "admin") {
    header("Location: logindenied.php");
}

$id = $_SESSION['id_utente'];

//WORK IN PROGRESS
?>

<!DOCTYPE html>
<html>
<head>
    <title>Area Admin</title>
    <link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
    <div class="button-container">
        <div class="top-left-container">
            <input type="button" name="logout" value="Logout" onclick="location.href='logout.php'">
            <input type="button" name="login" value="Torna alle tabelle" onclick="location.href='sceltaAdmin.php'">
        </div>
    </div>
    <div class="container">
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <?php
                require_once "db.php";
                
                switch($_GET['choice']) {
                    case 1:
                        echo '<tr>
                            <th>Numero di inventario</th>
                            <th>Tipologia</th>
                            <th>Categoria</th>
                            <th>Articolo</th>
                            <th>Stato</th>
                            <th>Centro</th>
                            <th>Città</th>
                            <th>Indirizzo</th>
                            <th>Modifica</th>
                        </tr>';
                        $selectSql = "SELECT id_articolo, numero_inventario, tipologia, categoria, articolo, stato, nome, citta, indirizzo
                                    FROM articoli a JOIN centri c 
                                    ON a.fk_id_centro = c.id_centro
                                    JOIN categorie cat 
                                    ON a.fk_id_categoria = cat.id_categoria
                                    ORDER BY tipologia";
                        break;
                    case 2:
                        $selectSql = "SELECT * FROM prestiti";
                        break;
                    case 3:
                        $selectSql = "SELECT * FROM prenotazioni";
                        break;
                    case 4:
                        $selectSql = "SELECT * FROM utenti";
                        break;
                    default:
                        header("Location: sceltaAdmin.php");
                }
                ?>
                <tbody>
                <?php
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

