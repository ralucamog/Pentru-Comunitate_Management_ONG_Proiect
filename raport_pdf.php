<?php
session_start();
// Includem biblioteca și conexiunea la baza de date
require('libs/fpdf.php'); 
include 'db.php'; 

// Accesul la rapoartele financiare este restricționat strict categoriei de utilizator admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("Acces refuzat! Doar administratorii pot vedea rapoartele financiare.");
}

// Funcție pentru eliminarea diacriticelor care blochează FPDF
// Fără această curățare, coloanele cu nume sau proiecte care conțin diacritice apar goale.
function curata_pt_pdf($text) {
    $cautare   = array('ă', 'â', 'î', 'ș', 'ț', 'Ă', 'Â', 'Î', 'Ș', 'Ț');
    $inlocuire = array('a', 'a', 'i', 's', 't', 'A', 'A', 'I', 'S', 'T');
    return str_replace($cautare, $inlocuire, $text);
}

class PDF extends FPDF {
    function Header() {
        // Verificăm dacă logo-ul există înainte de a-l afișa
        if (file_exists('logo_ong.png')) {
            $this->Image('logo_ong.png', 10, 6, 30);
        }
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(80);
        // Titlul antetului curățat
        $this->Cell(30, 10, curata_pt_pdf('Raport Activitate ONG'), 0, 0, 'C');
        $this->Ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Crearea documentului
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, curata_pt_pdf('Situatie Donatii Proiecte Sociale'), 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Data generarii: ' . date('d.m.Y H:i'), 0, 1, 'L');
$pdf->Ln(5);

// Antet Tabel
$pdf->SetFillColor(230, 230, 230);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(60, 10, 'Nume Donator', 1, 0, 'C', true);
$pdf->Cell(90, 10, curata_pt_pdf('Proiect Sustinut'), 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Suma (EUR)', 1, 1, 'C', true);

$pdf->SetFont('Arial', '', 10);

// Coloanele din rmogilde_proiect.sql sunt id_utilizator și id_proiect
$sql = "SELECT u.nume_complet, p.titlu, d.suma 
        FROM donatii d 
        JOIN utilizatori u ON d.id_utilizator = u.id 
        JOIN proiecte p ON d.id_proiect = p.id 
        ORDER BY d.id DESC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Curățăm datele din DB înainte de afișare
        $nume = curata_pt_pdf($row['nume_complet']);
        $proiect = curata_pt_pdf($row['titlu']);
        $suma = $row['suma'] . ' EUR';

        $pdf->Cell(60, 10, $nume, 1);
        $pdf->Cell(90, 10, $proiect, 1);
        $pdf->Cell(40, 10, $suma, 1, 1, 'R');
    }
} else {
    // Mesaj afișat dacă nu există donații care să aibă utilizatori și proiecte valide
    $pdf->Cell(190, 10, curata_pt_pdf('Nu exista date de afisat.'), 1, 1, 'C');
}
// Finalizare și afișare
$pdf->Output('I', 'Raport_ONG_PentruComunitate.pdf');
?>
