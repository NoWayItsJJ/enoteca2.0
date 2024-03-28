<?php 
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || $_SESSION['tipo_utente'] != "cliente") {
        header("Location: ../logindenied.php");
    }
    

    $idPrenotazione = $_GET['id'];

    require_once "../db.php";

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