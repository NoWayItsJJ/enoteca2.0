<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal form
    $id_articolo = $_POST["id"];
    $numero_inventario = $_POST["numeroInventario"];
    $articolo = $_POST["articolo"];
    $stato = $_POST["stato"];
    $categoria = $_POST["categoria"];
    $centro = $_POST["centro"];

    require_once '../db.php';

    $editSql = "UPDATE articoli SET numero_inventario='$numero_inventario', articolo='$articolo', stato='$stato', fk_id_categoria='$categoria', fk_id_centro='$centro' WHERE id_articolo=$id_articolo";
    $conn->query($editSql);
    header("Location: visualizzaArticoli.php");
}
?>