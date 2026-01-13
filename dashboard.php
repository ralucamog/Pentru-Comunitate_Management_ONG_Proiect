<div class="wrapper">
<?php
$page_title = "Proiecte"; 
$page_description = "Pagina pentru proiecte.";

include 'db.php';
include 'header.php';

// Implementarea unui mecanism simplu de autentificare 
// Se verifică dacă utilizatorul este logat înainte de a permite accesul la datele sensibile
if (!isset($_SESSION['user_id'])) {
    // Securizarea accesului: Redirecționare dacă sesiunea nu este activă
    header("Location: login.php");
    exit();
}

// Interacțiune de tip CRUD - Citirea informațiilor din baza de date 
// Se utilizează un mecanism de sortare pentru a afișa întâi cele mai noi proiecte
$sql = "SELECT * FROM proiecte ORDER BY data_crearii DESC";
$result = $conn->query($sql);
?>

<div class="container"><h3>Lista Proiecte ONG</h3>

<?php 
    // Separarea rolurilor - Acțiuni specifice doar pentru administrator
    if ($_SESSION['rol'] == 'admin'): 
?>
    <a href="adaugare_proiect.php" class="btn-add">+ Adaugă Proiect Nou</a>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Titlu</th>
        <th>Descriere</th>
        <th>Buget</th>
        <th>Acțiuni</th>
    </tr>
    <?php
    // Verificăm dacă există date returnate de interogarea SQL
    if ($result->num_rows > 0) {
        // Parcurgerea elementelor din baza de date
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>"; // Securizare XSS la afișare
            echo "<td>" . $row['titlu'] . "</td>";
            echo "<td>" . $row['descriere'] . "</td>";
            echo "<td>" . $row['buget'] . " EURO</td>";
            echo "<td>";

            // Separarea rolurilor pentru acțiuni CRUD specifice (Editare/Ștergere)
            if ($_SESSION['rol'] == 'admin') { // Verificarea rolului pentru acțiuni specifice
                echo "<a href='editare_proiect.php?id=" . $row['id'] . "'>Editează</a> | ";
                // Implementarea unui mecanism de confirmare pentru prevenirea acțiunilor accidentale
                echo "<a href='stergere_proiect.php?id=" . $row['id'] . "' class='btn-del' onclick='return confirm(\"Sigur vrei să ștergi?\")'>Șterge</a>";
            } else {
                // Utilizatorii fără drepturi de admin pot doar vizualiza informațiile
                echo "<span>Vizualizare</span>";
            }
            echo "</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Nu există proiecte momentan.</td></tr>";
    }
    ?>
</table>
</div> 
</div>
<?php include 'footer.php'; ?>