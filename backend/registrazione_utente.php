<!DOCTYPE html>
<html>
<head>
    <title>Registrazione cliente</title>
    <link rel="stylesheet" href="../style/styles.css" type="text/css">
</head>
<body>

<?php
// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recupera i dati dal form
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $indirizzo = $_POST["indirizzo"];
    $tipo = $_POST["tipo_utente"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $passCheck = $_POST["passCheck"];

    //Connessione al database
    require_once "../db.php";

    if(filter_var($email, FILTER_VALIDATE_EMAIL) && ($pass === $passCheck))
    {
        $passmd5 = md5($pass);
        
        $getSql = "SELECT * FROM utenti WHERE email='$email'";
        $getResult = $conn->query($getSql);
        if($getResult->num_rows>0)
        {
            echo '<script>alert("Errore, utente già esistente")</script>';
        } else {
            $insertStmt = $conn->prepare("INSERT INTO utenti (nome, cognome, indirizzo, email, password, tipo_utente) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("ssssss", $nome, $cognome, $indirizzo, $email, $passmd5, $tipo);
            $insertStmt->execute();
            header("Location: visualizzaUtenti.php");
        }
    } else {
        echo '<script>alert("Dati inseriti non validi")</script>';
    }
}
?>
<input type="button" name="login" value="Indietro" onclick="location.href='visualizzaUtenti.php'">
<div class="container">
    <div class="login-box">
        <h2>Crea un utente:</h2>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="user-box"><input type="text" name="nome" required><label>Nome</label></div>
            <div class="user-box"><input type="text" name="cognome" required><label>Cognome</label></div>
            <div class="user-box"><input type="text" name="indirizzo" required/><label>Indirizzo</label></div>
            <div><select class="select" name="tipo_utente" required>
                <option value="" disabled selected hidden>Seleziona...</option>
                <option value="cliente">Cliente</option>
                <option value="operatore">Operatore</option>
                <option value="admin">Admin</option>
            </select>
            </div>
            <div class="user-box"><input type="email" name="email" required><label>Email</label></div>
            <div class="user-box"><input type="password" name="pass" required><label>Password</label></div>
            <div class="user-box"><input type="password" name="passCheck" required><label>Conferma Password</label></div>
            <input class="submit" type="submit" value="Crea">
        </form>
    </div>
</div>
</body>
</html>