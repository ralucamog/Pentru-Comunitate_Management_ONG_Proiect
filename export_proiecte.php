<?php
// Gestionarea sesiunilor pentru persistenta parametrilor și securitatea accesului
session_start();

// Reutilizarea codului PHP prin includerea conexiunii la baza de date
include 'db.php';

// Funcționalitatea de export este restricționată exclusiv administratorilor
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat! Doar administratorii pot descărca rapoartele pentru proiecte.");
}

// Aplicația va permite exportul în diferite formate (excel, doc, pdf, csv etc.) 
// Setarea header-elor pentru a forța descărcarea fișierului sub formă de CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="raport_proiecte.csv"');

// Găsirea unei soluții de implementare generice care permite extinderi ușoare
// Deschiderea fluxului de ieșire pentru scrierea datelor
$output = fopen('php://output', 'w');

//Pentru diacritice
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Mecanism generic de parcurgere/afisare a elementelor aplicației 
// Scrierea capului de tabel în fișierul CSV
fputcsv($output, array('ID', 'Titlu', 'Buget', 'Data Început'));

// Mecanism generic de obținere a informațiilor din baza de date
// Extragerea datelor specifice entităților 'proiecte' pentru raportare 
$result = $conn->query("SELECT id, titlu, buget, DATE_FORMAT(data_inceput, '%d.%m.%Y') as data_de_incepere FROM proiecte");

// Parcurgerea setului de rezultate și inserarea fiecărei linii în export
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Închiderea resursei și finalizarea scriptului pentru a preveni output suplimentar
fclose($output);
exit();
?>
