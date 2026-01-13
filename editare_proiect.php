<?php
$page_title = "Editare Proiect";
$page_description = "Modificarea detaliilor pentru proiectele ONG existente.";

include 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat! Doar administratorii pot edita proiecte.");
}

// Găsirea unei soluții pentru persistența parametrilor GET
if (isset($_GET['id'])) {
    // Securizarea împotriva SQL Injection prin utilizarea prepared statements
    // Implementarea funcționalității CRUD - pasul de citire (Read) pentru pre-popularea formularului
    $stmt = $conn->prepare("SELECT * FROM proiecte WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $proiect = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (isset($_POST['actualizeaza'])) {
    // Implementarea acțiunii de tip Update din mecanismul CRUD 
    // Se folosește din nou mecanismul generic de modificare securizată a informațiilor
    $stmt = $conn->prepare("UPDATE proiecte SET titlu=?, descriere=?, data_inceput=?, buget=? WHERE id=?");

    // Validarea tipurilor de date pentru a preveni atacurile de tip SQL Injection
    $stmt->bind_param("sssdi", $_POST['titlu'], $_POST['descriere'], $_POST['data_inceput'], $_POST['buget'], $_POST['id']);
    if ($stmt->execute()) {
        // Redirecționare pentru a asigura un flux intuitiv și confirmarea succesului operațiunii
        echo "<script>window.location.href='dashboard.php?mesaj=actualizat';</script>";
    }
    $stmt->close();
}
?>
<h2>Editează Proiectul</h2>
<form method="POST">
   <input type="hidden" name="id" value="<?php echo htmlspecialchars($proiect['id']); ?>">
    
    <label>Titlu:</label><br>
    <input type="text" name="titlu" value="<?php echo htmlspecialchars($proiect['titlu']); ?>" required><br>
    
    <label>Descriere:</label><br>
    <textarea name="descriere" required><?php echo htmlspecialchars($proiect['descriere']); ?></textarea><br>
    
    <label>Data Început:</label><br>
    <input type="date" name="data_inceput" value="<?php echo $proiect['data_inceput']; ?>" required><br>
    
    <label>Buget (EURO):</label><br>
    <input type="number" name="buget" value="<?php echo $proiect['buget']; ?>" required><br>
    
    <button type="submit" name="actualizeaza" class="btn-add">Actualizează Proiectul</button>
</form>
<?php include 'footer.php'; ?>