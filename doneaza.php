<div class="wrapper">
<?php
$page_title = "Donează"; 
$page_description = "Donații pentru proiecte.";

include 'db.php';
include 'header.php';

// Se verifică existența unei sesiuni active înainte de a permite procesarea donației
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['doneaza'])) {
    $id_user = $_SESSION['user_id'];
    $id_proiect = $_POST['id_proiect'];
    $suma = $_POST['suma'];

    // Utilizarea funcțiilor de tip prepared statements
    $stmt = $conn->prepare("INSERT INTO donatii (id_utilizator, id_proiect, suma) VALUES (?, ?, ?)");

    // Folosirea unui mecanism generic de inserare a informațiilor în baza de date
    // Legarea parametrilor asigură integritatea datelor și previne execuția de cod malițios
    $stmt->bind_param("iid", $id_user, $id_proiect, $suma);

    // Implementarea funcționalităților de bază de tip CRUD (Create - Inserare donație)
    if ($stmt->execute()) {
        echo "<p style='color:green'>Mulțumim pentru donație!</p>";
    }
    $stmt->close();
}

// Luăm lista de proiecte pentru formular
$proiecte = $conn->query("SELECT id, titlu FROM proiecte");
?>

<div class="container"> <h2>Susține un Proiect</h2>
<form method="POST" action="">
    <label>Alege Proiectul:</label><br>
    <select name="id_proiect" required style="width: 100%; padding: 10px; margin: 10px 0;">
        <?php
            // Folosirea unui mecanism generic de parcurgere/afisare a elementelor 
            while ($p = $proiecte->fetch_assoc()): 
        ?>
            <option value="<?php echo $p['id']; ?>"><?php echo $p['titlu']; ?></option>
        <?php endwhile; ?>
    </select><br>

    <label>Suma (EURO):</label><br>
    <input type="number" name="suma" step="0.01" required><br><br>

    <button type="submit" name="doneaza" class="btn-add">Trimite Donația</button>
</form>
</div> 
</div>
<?php include 'footer.php'; ?>