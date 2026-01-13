<?php
// Evitarea folosirii tehnicii copy/paste
// Scrierea de funcții dedicate pentru sarcini repetitive
/**
 * Implementarea unui mecanism generic de gestionare a informațiilor 
 * Funcție de bază pentru persistența datelor într-un fișier extern (mecanism de contorizare vizite).
 */
if (!function_exists('actualizeazaContor')) {
    function actualizeazaContor($numeFisier)
    {
        // Verificăm existența fișierului pentru a asigura funcționarea corespunzătoare
        $vizite = file_exists($numeFisier) ? (int)file_get_contents($numeFisier) : 0;
        $vizite++;

        // Asigurăm persistența parametrilor prin scrierea în fișier
        file_put_contents($numeFisier, $vizite);
        return $vizite;
    }
}

/**
 * Gruparea funcționalităților cu proprietăți comune pentru o arhitectură decuplată
 * Funcție specializată pentru contorizarea vizitelor generale pe site.
 */
if (!function_exists('contorizeazaVizitaGenerala')) {
    function contorizeazaVizitaGenerala()
    {
        return actualizeazaContor('vizite.txt');
    }
}

/**
 * Procese specifice aplicației - monitorizarea impactului pe pagini cheie 
 * Funcție utilizată în pagini precum 'statistici.php' unde este prezentat elementul multimedia
 */
if (!function_exists('contorizeazaVizitaStatistici')) {
    function contorizeazaVizitaStatistici()
    {
        return actualizeazaContor('contor_vizite.txt');
    }
}
?>