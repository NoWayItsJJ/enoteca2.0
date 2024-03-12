<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal form
    $id_articolo = $_POST["id_articolo"];
    $numero_inventario = $_POST["numeroInventario"];
    $articolo = $_POST["articolo"];
    $stato = $_POST["stato"];
    $categoria = $_POST["categoria"];
    $centro = $_POST["centro"];

    require_once '../db.php';

    //$editSql = "UPDATE ticket SET tipo_ticket='$tipo2', titolo='$titolo2', descrizione='$descrizione2', urgente='$urgente2', risolto='$risolto2' WHERE id=$id";

    echo $id_articolo;
    echo $numero_inventario;
    echo $articolo;
    echo $stato;
    echo $categoria;
    echo $centro;
}
?>