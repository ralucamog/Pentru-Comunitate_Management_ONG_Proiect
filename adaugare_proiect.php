<?php
$page_title = "Adăugare Proiect";
$page_description = "Pagină pentru adăugare de proiecte noi.";
// Reutilizarea codului HTML pentru structura paginii
include 'db.php';
include 'header.php';
// Verificarea separării rolurilor și restricționarea accesului 
// Doar utilizatorii autentificați cu rolul de admin pot accesa această funcționalitate 
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat! Doar administratorii pot adăuga proiecte.");
}
// Gestionarea parametrilor POST pentru persistența datelor
if (isset($_POST['salveaza'])) {
    // Securizarea împotriva atacurilor de tip SQL Injection
    // Utilizarea interogărilor pregătite (prepared statements) este recomandată pentru securitate
    $stmt = $conn->prepare("INSERT INTO proiecte (titlu, descriere, data_inceput, buget) VALUES (?, ?, ?, ?)");
    // Legarea parametrilor pentru a asigura tipul corect de date și a preveni injectarea de cod
    $stmt->bind_param("sssd", $_POST['titlu'], $_POST['descriere'], $_POST['data_inceput'], $_POST['buget']);

    if ($stmt->execute()) {
        // Implementarea funcționalităților de tip CRUD (Create)
        echo "<script>alert('Proiect adăugat cu succes!'); window.location.href='dashboard.php';</script>";
    }
    $stmt->close();
}
?>
<h2>Adaugă un Proiect Nou</h2>
<form method="POST">
    <label>Titlu Proiect:</label><br><input type="text" name="titlu" required><br>
    <label>Descriere:</label><br><textarea name="descriere" required></textarea><br>
    <label>Data Început:</label><br><input type="date" name="data_inceput" required><br>
    <label>Buget (EURO):</label><br><input type="number" name="buget" required><br>
    <button type="submit" name="salveaza" class="btn-add">Salvează Proiectul</button>
</form>
<?php 
    //Reutilizarea footer-ului pentru consistența aplicației
    include 'footer.php'; 
?>