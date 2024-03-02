<?php 
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente'])) {
        header("Location: logindenied.php");
    }

    $idPrenotazione = $_GET['id'];

    $servername = "localhost";
    $username = "root"; // Sostituisci con il tuo nome utente del database
    $password = ""; // Sostituisci con la tua password del database
    $dbname = "pauletta_enoteca2"; // Sostituisci con il nome del tuo database
    $conn = new mysqli($servername, $username, $password, $dbname);

    $editSql = "UPDATE articoli SET stato = 'disponibile' WHERE id_articolo = (SELECT fk_id_articolo FROM prenotazioni WHERE id_prenotazione = $idPrenotazione)";
    $result = $conn->query($editSql);

    $deleteSql = "DELETE FROM prenotazioni WHERE id_prenotazione = $idPrenotazione";
    $conn->query($deleteSql);

    if($result)
    {
        header("Location: cliente.php");
    }
    else
    {
        echo "Errore nella prenotazione";
    }
?>