<?php
session_start();
include 'db.php';

// Doar utilizatorii cu rol de admin au permisiunea de a șterge
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat!");
}

// Identificăm proiectul specific ce urmează a fi eliminat din baza de date
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM proiecte WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);

    // Implementarea funcționalităților de bază de tip CRUD (Delete - Ștergere)
    if ($stmt->execute()) {
        // Redirecționare cu mesaj de confirmare
        header("Location: dashboard.php?mesaj=sters");
    } else {
        // Gestionarea erorilor bazei de date fără a compromite securitatea
        echo "Eroare: " . $conn->error;
    }
    $stmt->close();
}
