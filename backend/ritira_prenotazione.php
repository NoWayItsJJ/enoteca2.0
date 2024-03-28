<?php 
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || ($_SESSION['tipo_utente'] != "operatore") && ($_SESSION['tipo_utente'] != "admin")) {
        header("Location: ../logindenied.php");
    }

    $idArticolo = $_GET['id'];
    $idPrenotazione = $_GET['booking'];

    require_once "../db.php";

    $updateSql = "UPDATE articoli SET stato = 'in prestito' WHERE id_articolo = $idArticolo";
    $conn->query($updateSql);

    $selectSql = "SELECT * FROM prenotazioni WHERE id_prenotazione = $idPrenotazione";
    $result = $conn->query($selectSql);
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        $data_inizio = $row['data_inizio'];
        $id_utente = $row['fk_id_utente'];
        $id_articolo = $row['fk_id_articolo'];
    }

    $createSql = "INSERT INTO prestiti(id_prestito, data_inizio, data_fine, fk_id_utente, fk_id_articolo) VALUES(NULL, '$data_inizio', NULL, $id_utente, $id_articolo)";
    $conn->query($createSql);

    $deleteSql = "DELETE FROM prenotazioni WHERE id_prenotazione = $idPrenotazione";
    if($conn->query($deleteSql))
    {
        header("Location: visualizzaPrenotazioni.php");
    }
?>