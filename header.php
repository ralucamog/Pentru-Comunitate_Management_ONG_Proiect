<?php
// Inițierea mecanismului de sesiune pentru autentificare și persistența parametrilor pe parcursul navigării
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Reutilizarea codului prin includerea bibliotecii de funcții proprii, evitând tehnica copy/paste
include_once 'functii.php';

// Apelarea unui proces specific aplicației (monitorizarea traficului) prin intermediul unei funcții generice
contorizeazaVizitaGenerala();
?>
<!DOCTYPE html>
<html lang="ro">

<head>
    <?php
        // Realizarea optimizărilor SEO prin integrarea datelor structurate (JSON-LD) pentru motoarele de căutare 
        if (isset($specific_seo_schema)): ?>
        <?php echo $specific_seo_schema; ?>
    <?php else: ?>
        <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "NGO",
        "name": "Pentru Comunitate",
        "url": "https://rmogildea.daw.ssmr.ro/"
        }
        </script>
    <?php endif; ?>
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : "Platforma oficială 'Pentru Comunitate' - Gestionăm proiecte de impact social și voluntariat."; ?>">
    
    <meta name="keywords" content="ONG, voluntariat, proiecte, management, donații, comunitate">
    <meta name="author" content="Mogîldea Raluca-Maria">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>ONG - Pentru Comunitate</title>
    <link rel="canonical" href="https://rmogildea.daw.ssmr.ro<?php echo $_SERVER['PHP_SELF']; ?>">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="logo_ong.png" alt="Logo ONG" style="height: 40px; vertical-align: middle;">
            ONG - Pentru Comunitate
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Acasă</a></li>
            <li><a href="documentatie.php">Documentație</a></li>
            <li><a href="dashboard.php">Proiecte</a></li>
            <li><a href="doneaza.php">Donează</a></li>
            <li><a href="statistici.php">Statistici</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn" style="color: #f1c40f;">Rapoarte &#9662;</a>
                    <div class="dropdown-content">
                        <a href="raport_pdf.php" target="_blank" style="font-weight: bold; color: #d35400;">
                            <i class="fas fa-file-pdf"></i> Vizualizare PDF Donații
                        </a>
                        <a href="export_proiecte.php">Export Proiecte</a>
                        <a href="raport_donatii.php">Export Donații</a>
                    </div>
                </li>
            <?php endif; ?>
            <li><a href="logout.php" class="btn-logout">Ieșire</a></li>
        </ul>
    </nav>
    <div class="container">