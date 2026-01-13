<?php
// Gestionarea sesiunilor pentru persistenta parametrilor (GET sau POST)
session_start();
include 'db.php';
// Nu se include header.php aici pentru că arată ciudat să ai meniu când nu ești logat

// Verificăm dacă formularul de login a fost trimis prin metoda POST
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $parola = $_POST['parola'];

    // Securitate: Prepared Statements
    $stmt = $conn->prepare("SELECT id, nume_complet, parola, rol FROM utilizatori WHERE email = ?");
    
    // Legarea parametrilor pentru a asigura integritatea datelor
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Implementarea unui mecanism simplu de autentificare
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificarea parolei criptate pentru a asigura securitatea datelor utilizatorului
        if (password_verify($parola, $row['parola'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nume'] = $row['nume_complet'];
           
            // Separarea rolurilor - stocăm rolul pentru a restricționa accesul la funcții admin           
            $_SESSION['rol'] = $row['rol'];

            // Flux intuitiv - redirecționare automată către panoul de control după succes
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Parolă greșită!";
        }
    } else {

        // Gestionarea erorilor fără a afecta inutil ușurința în utilizare
        $error = "Nu există cont cu acest email!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Autentificare</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7f6;
        }

        .login-card {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-login:hover {
            background-color: #34495e;
        }

        .link-register {
            margin-top: 20px;
            display: block;
            color: #27ae60;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2>Bine ai venit!</h2>
        <p>Intră în contul tău ONG</p>

        <?php 
            // Afișarea erorilor de autentificare într-un mod vizibil utilizatorului
            if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Adresa de Email" required>
            <input type="password" name="parola" placeholder="Parola" required>

            <button type="submit" name="login" class="btn-login">Logare</button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
        <p>Nu ai încă un cont?</p>
        <a href="register.php" class="link-register">Creează un cont nou</a>
    </div>

</body>

</html>