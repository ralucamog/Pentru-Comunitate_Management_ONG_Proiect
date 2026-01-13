<?php
include 'db.php';

if (isset($_POST['register'])) {
    $nume = $_POST['nume'];
    $email = $_POST['email'];
    
    // Securizarea aplicației împotriva atacurilor comune 
    // Criptăm parola înainte de salvare pentru a proteja datele sensibile în caz de acces neautorizat la BD
    $parola = password_hash($_POST['parola'], PASSWORD_DEFAULT);
    // Implicit orice nou venit este voluntar
    $rol = 'voluntar';

    // Verificăm întâi dacă emailul există deja (Securitate extra)
    $check = $conn->prepare("SELECT id FROM utilizatori WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mesaj = "<p style='color:red'>Acest email este deja folosit!</p>";
    } else {
        // Inserare securizată (Prepared Statement)
        $stmt = $conn->prepare("INSERT INTO utilizatori (nume_complet, email, parola, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nume, $email, $parola, $rol);

        if ($stmt->execute()) {
            $mesaj = "<p style='color:green'>Cont creat cu succes! <a href='login.php'>Loghează-te aici</a></p>";
        } else {
            $mesaj = "<p style='color:red'>Eroare la înregistrare.</p>";
        }
        $stmt->close();
    }
    $check->close();
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <title>Înregistrare</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Stiluri pentru o interfață intuitivă */
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

        .btn-register {
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-register:hover {
            background-color: #219150;
        }

        .link-login {
            margin-top: 20px;
            display: block;
            color: #2c3e50;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2>Devino Voluntar</h2>
        <p>Alătură-te echipei noastre!</p>

        <?php
            // Folosirea tagurilor php pentru imbricarea codului în HTML 
            if (isset($mesaj)) echo $mesaj; ?>

        <form method="POST" action="">
            <input type="text" name="nume" placeholder="Nume Complet" required>
            <input type="email" name="email" placeholder="Adresa de Email" required>
            <input type="password" name="parola" placeholder="Alege o Parolă" required>

            <button type="submit" name="register" class="btn-register">Înregistrează-te</button>
        </form>

        <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
        <p>Ai deja un cont?</p>
        <a href="login.php" class="link-login">Intră în cont aici</a>
    </div>

</body>

</html>