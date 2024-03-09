<!DOCTYPE html>
<html>
<head>
    <title>Registrazione cliente</title>
    <link rel="stylesheet" href="style/styles.css" type="text/css">
</head>
<body>

<?php
// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Recupera i dati dal form
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $indirizzo = $_POST["indirizzo"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $passCheck = $_POST["passCheck"];

    //Connessione al database
    require_once "db.php";

    if(filter_var($email, FILTER_VALIDATE_EMAIL) && ($pass === $passCheck))
    {
        $passmd5 = md5($pass);
        
        $getSql = "SELECT * FROM utenti WHERE email='$email'";
        $getResult = $conn->query($getSql);
        if($getResult->num_rows>0)
        {
            echo '<script>alert("Utente già esistente, effettua il login")</script>';
        } else {
            $insertStmt = $conn->prepare("INSERT INTO utenti (nome, cognome, indirizzo, email, password, tipo_utente) VALUES (?, ?, ?, ?, ?, 'cliente')");
            $insertStmt->bind_param("sssss", $nome, $cognome, $indirizzo, $email, $passmd5);
            $insertStmt->execute();
            session_start();
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $passmd5;
            $result = $conn->query($getSql);
            while($row = $result->fetch_assoc())
            {
                $_SESSION['id_utente'] = $row["id_utente"];
                $_SESSION['tipo_utente'] = $row["tipo_utente"];
            }
            header("Location: cliente.php");
        }
    } else {
        echo '<script>alert("Dati inseriti non validi")</script>';
    }
}
?>
<input type="button" name="login" value="Accedi" onclick="location.href='index.php'">
<div class="container">
    <div class="login-box">
        <h2>Crea un account cliente:</h2>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="user-box"><input type="text" name="nome" required><label>Nome</label></div>
            <div class="user-box"><input type="text" name="cognome" required><label>Cognome</label></div>
            <div class="user-box"><input type="text" name="indirizzo" required/><label>Indirizzo</label></div>
            <div class="user-box"><input type="email" name="email" required><label>Email</label></div>
            <div class="user-box"><input type="password" name="pass" required><label>Password</label></div>
            <div class="user-box"><input type="password" name="passCheck" required><label>Conferma Password</label></div>
            <input class="submit" type="submit" value="Crea">
        </form>
    </div>
</div>
</body>
</html>