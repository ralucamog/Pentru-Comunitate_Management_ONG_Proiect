<?php
$page_title = "Statistici ONG"; 
$page_description = "Pagină pentru statistici.";

include 'db.php';
include 'header.php'; // Acesta include deja functii.php

// Apelăm contorul specific pentru această pagină
contorizeazaVizitaStatistici();

// Implementarea interacțiunilor de tip CRUD (Read) pentru a genera statistici în timp real
$res_p = $conn->query("SELECT COUNT(*) as total FROM proiecte");
$total_proiecte = $res_p->fetch_assoc()['total'];

$res_d = $conn->query("SELECT SUM(suma) as total_fonduri FROM donatii");
$fonduri = $res_d->fetch_assoc()['total_fonduri'] ?? 0;

// Preluăm valorile din fișierele text gestionate prin funcțiile din functii.php
$vizite_site = file_exists('vizite.txt') ? (int)file_get_contents('vizite.txt') : 0;
$vizite_stats = file_exists('contor_vizite.txt') ? (int)file_get_contents('contor_vizite.txt') : 0;

/**
 * Integrare module și informație externă parsat/modelată (Curs BNR)
 * Funcție pentru obținerea cursului valutar dintr-o sursă externă (nu direct URL sau frame)
 */
function obtineCursBNR()
{
    // Preluarea conținutului XML de la o sursă externă oficială
    $xml = @simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml");
    if ($xml) {
        // Parsarea structurii XML pentru a identifica rata EUR/RON
        foreach ($xml->Body->Cube->Rate as $rate) {
            if ($rate['currency'] == 'EUR') return (string)$rate;
        }
    }
    return "N/A";
}
?>

<div class="container">
    <h2 style="color: var(--pink); text-align: center; margin-bottom: 40px;">Impactul Nostru în Cifre</h2>

    <div class="card" style="text-align: center; background: var(--soft-pink);">
        <img src="imagine_statistici.png" alt="Imagine Proiecte" style="width: 100%; border-radius: 10px;">
    </div>

    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div class="card">
            <h4 style="margin:0; color: #777;">Proiecte Active</h4>
            <h2 style="color: var(--pink); margin: 10px 0;"><?php echo $total_proiecte; ?></h2>
        </div>
        <div class="card">
            <h4 style="margin:0; color: #777;">Fonduri Totale</h4>
            <h2 style="color: var(--pink); margin: 10px 0;"><?php echo number_format($fonduri, 2); ?> <small>EURO</small></h2>
        </div>

        <div class="card">
            <h4 style="margin:0; color: #777;">Accesări Totale Site</h4>
            <h2 style="color: var(--pink); margin: 10px 0;"><?php echo $vizite_site; ?></h2>
        </div>

        <div class="card">
            <h4 style="margin:0; color: #777;">Vizualizări Impact</h4>
            <h2 style="color: var(--pink); margin: 10px 0;"><?php echo $vizite_stats; ?></h2>
        </div>

        <div class="card" style="background: var(--black); color: white;">
            <h4 style="margin:0; color: var(--pink);">Curs BNR</h4>
            <h2 style="margin: 10px 0;">1 EUR = <?php echo obtineCursBNR(); ?> <small>RON</small></h2>
            <p style="font-size: 0.8rem; opacity: 0.7;">Info parsată extern</p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>