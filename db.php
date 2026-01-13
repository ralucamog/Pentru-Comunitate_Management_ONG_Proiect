<?php
// Acest fișier este componenta principală care gestionează conexiunea cu serverul MySQL.

$servername = "localhost";
$username = "demo";
$password = "demo";          // Credențiale setate pentru baza de date
$dbname = "rmogilde_proiect"; // Numele bazei de date

// Găsirea unei soluții pentru reutilizarea codului PHP în aplicație 
// Prin crearea acestui fișier separat și includerea lui în restul modulelor, 
// se centralizează logica de conectare și se evită duplicarea codului.

// Crearea conexiunii folosind biblioteca mysqli
// Obiectul $conn creat aici este pilonul central pentru toate interacțiunile de tip CRUD.
// Această conexiune permite utilizarea funcțiilor de tip 'prepared statements' ($conn->prepare()),
// metodă recomandată în mod explicit pentru protecția bazei de date și ajută la securizarea împotriva SQL Injection

$conn = new mysqli($servername, $username, $password, $dbname);

// Securizarea aplicației împotriva atacurilor comune 
// Verificarea conexiunii previne continuarea execuției codului în cazul unor defecțiuni tehnice.
if ($conn->connect_error) {
    // Oprirea scriptului pentru a preveni expunerea erorilor interne utilizatorilor neautorizați
    die("Conexiune eșuată: " . $conn->connect_error);
}
