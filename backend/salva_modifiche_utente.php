<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal form
    $id = $_POST["id"];
    $nome2 = $_POST["nome"];
    $cognome2 = $_POST["cognome"];
    $tipo2 = $_POST["tipo_utente"];
    $indirizzo2 = $_POST["indirizzo"];
    $email2 = $_POST["email"];
    $oldEmail = $_POST["old_email"];
    $pass2 = $_POST["password"];
    $oldPass = $_POST["old_psw"];
    $pass2md5 = ($pass2 === $oldPass) ? $pass2 : md5($pass2);

    // Connessione al database
    require_once '../db.php';

    $getSql = "SELECT * FROM utenti WHERE email='$email2'";
    $getResult = $conn->query($getSql);
    if($getResult->num_rows>0 && $email2 != $oldEmail){
        echo '<script>alert("Mail utente già esistente nel database");
              window.location="visualizzaUtenti.php"</script>';
    } else {
        $editSql = "UPDATE utenti SET tipo_utente='$tipo2', nome='$nome2', cognome='$cognome2', indirizzo='$indirizzo2', email='$email2', password='$pass2md5' WHERE id_utente=$id";
        if ($conn->query($editSql) === TRUE) {
            header("Location: visualizzaUtenti.php");
        } else {
            header("Location: modifica_utente.php?id='.$id'");
        }
    }
}
?>