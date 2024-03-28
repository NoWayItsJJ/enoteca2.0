<?php
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id_utente']) || !isset($_SESSION['tipo_utente']) || ($_SESSION['tipo_utente'] != "operatore") && ($_SESSION['tipo_utente'] != "admin")) {
        header("Location: ../logindenied.php");
    }

    //per vedere lo storico dei prestiti si possa fare l'unione delle due tabelle e joinare con la tabella prestiti

    require_once '../db.php';
    $id = $_GET['id'];
    $editSql = "UPDATE articoli_dismessi SET stato='disponibile' WHERE id_articolo2 = $id";
    $conn->query($editSql);
    $deleteSql = "DELETE FROM articoli_dismessi WHERE id_articolo2 = $id";
    $conn->query($deleteSql);
    header('Location: visualizzaArticoli.php');
    exit;
?>