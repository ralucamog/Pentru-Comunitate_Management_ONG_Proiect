<?php
session_start();
include 'db.php';

// Accesul la rapoartele financiare este restricționat strict categoriei de utilizator admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat! Doar administratorii pot vedea rapoartele financiare.");
}


// Configurarea header-elor pentru generarea unui fișier descărcabil de tip CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="raport_donatii_ong.csv"');

// Utilizarea fluxului de ieșire direct pentru scrierea raportului
$output = fopen('php://output', 'w');
//Pentru diacritice
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
// Definirea capului de tabel pentru fișierul exportat
fputcsv($output, array('ID Donatie', 'Voluntar', 'Proiect', 'Suma (EURO)', 'Data'));

// Interogare complexă (JOIN) pentru a lega tabelele 
$query = "SELECT d.id, u.nume_complet, p.titlu, d.suma,
          DATE_FORMAT(d.data_donatie, '%d.%m.%Y') as data_simpla
          FROM donatii d 
          JOIN utilizatori u ON d.id_utilizator = u.id 
          JOIN proiecte p ON d.id_proiect = p.id";

// Folosirea unui mecanism generic de obținere a informațiilor din BD
$result = $conn->query($query);

// Parcurgerea rezultatelor și scrierea fiecărei înregistrări în documentul CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

// Închiderea resurselor și terminarea execuției pentru a asigura integritatea fișierului
fclose($output);
exit();
?>