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
            <input type="button" name="loans" value="Crea utente" onclick="location.href='registrazione_utente.php'">
        </div>
    </div>
    <div class="container">
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Indirizzo</th>
                    <th>Tipo di utente</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Azioni</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $selectSql = "SELECT id_utente, nome, cognome, indirizzo, email, password, tipo_utente
                                    FROM utenti
                                    ORDER BY tipo_utente DESC";

                    require_once '../db.php';
                    $result = $conn->query($selectSql);
                    while($row = $result->fetch_array(MYSQLI_ASSOC))
                    {
                        $nome = $row['nome'];
                        $cognome = $row['cognome'];
                        $indirizzo = $row['indirizzo'];
                        $tipo_utente = $row['tipo_utente'];
                        $email = $row['email'];
                        $password = $row['password'];

                        echo
                            '<tr>
                                <td class="colonnaNome">'.$nome.'</td>
                                <td class="colonnaCognome">'.$cognome.'</td>
                                <td class="colonnaIndirizzo">'.$indirizzo.'</td>
                                <td class="colonnaTipo">'.$tipo_utente.'</td>
                                <td class="colonnaEmail">'.$email.'</td>
                                <td class="colonnaPassword">'.$password.'</td>
                                <td class="colonnaTasti">
                                    <button class="btn" type="button" onclick="location.href=\'modifica_utente.php?id='.$row["id_utente"].'\'">Modifica</button>
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