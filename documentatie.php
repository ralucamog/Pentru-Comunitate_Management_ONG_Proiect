<?php 
$page_title = "Documentație Tehnică";
include 'header.php';
?>

<div class="container" style="line-height: 1.6; padding: 40px 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
    <h1 style="color: var(--pink); border-bottom: 2px solid var(--pink); padding-bottom: 10px;">Documentație Tehnică - Management ONG</h1>

    <section>
        <h2>1. Prezentarea Aplicației</h2>
        <p>Aplicația "Pentru Comunitate" este o platformă web destinată gestionării activităților unui ONG, facilitând interacțiunea dintre administratori și voluntari/donatori.</p>
    
        <strong>Obiective principale:</strong>
        <ul>
            <li>Digitalizarea procesului de înregistrare și gestionare a voluntarilor.</li>
            <li>Gestiunea transparentă a proiectelor sociale și a fondurilor colectate.</li>
            <li>Generarea automată de rapoarte de impact (CSV) și monitorizarea activității web prin analytics local.</li>
            <li>Integrarea cu servicii externe pentru date financiare în timp real (Curs BNR).</li>
        </ul>
    
    </section>

    <hr>

    <section>
        <h2>2. Arhitectura Sistemului</h2>
        <p>Proiectul utilizează o arhitectură <strong>Client-Server</strong> bazată pe PHP(cod prin funcții si fisiere incluse), MySQL(tabele pentru utilizatori, proiecte, donații) și CSS(pentru aspect).</p>
        
        <h3>Managementul Sesiunilor și Accesului:</h3>
        <ul>
            <li><strong>Sesiuni:</strong> Utilizarea <code>session_start()</code> pentru menținerea stării utilizatorului pe parcursul navigării.</li>
            <li><strong>Controlul Accesului:</strong> Verificarea rolului utilizatorului (<code>admin</code> vs <code>voluntar</code>) pentru a restricționa accesul la funcțiile critice precum adăugarea, editarea sau ștergerea proiectelor.</li>
            <li><strong>Securizarea Ieșirii:</strong> Utilizarea <code>header("Location: ...")</code> și <code>exit()</code> pentru redirecționări securizate după operațiuni de tip POST sau Logout.</li>
        </ul>
        <h3>Roluri</h3>
        <ul>
            <li><strong>Administrator:</strong> Acces total la gestiunea proiectelor (CRUD), vizualizarea donațiilor și exportul rapoartelor financiare.</li>
            <li><strong>Voluntar:</strong> Poate vizualiza proiectele active, istoricul impactului și datele personale.</li>
            <li><strong>Vizitator:</strong> Accesează povestea ONG-ului, statistici publice și se poate înregistra în platformă.</li>
        </ul>
        <h3>Entități Bază de Date</h3>
        <table style="width:100%; border-collapse: collapse; margin-top: 10px;">
            <thead>
                <tr style="background-color: var(--pink); color: white;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Tabel</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Rol</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>utilizatori</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Stocarea datelor de profil, parolelor hash-uite și a rolurilor (admin/voluntar).</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>proiecte</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Inventarul inițiativelor sociale, bugete și perioade de desfășurare.</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;"><code>donatii</code></td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Legătura dintre utilizatori și proiecte, înregistrând sumele și data contribuțiilor.</td>
                </tr>
            </tbody>
        </table>
    </section>

    <hr>

    <section>
        <h2>3. Descrierea Bazei de Date</h2>
        <p>Sistemul utilizează o bază de date relațională compusă din trei tabele interconectate:</p>
        <ul>
            <li><strong>Tabelul <code>utilizatori</code>:</strong> Stochează <code>id</code>, <code>nume_complet</code>, <code>email</code>, <code>parola</code> (hash-uită) și <code>rol</code>.</li>
            <li><strong>Tabelul <code>proiecte</code>:</strong> Reține detaliile inițiativelor: <code>titlu</code>, <code>descriere</code>, <code>data_inceput</code> și <code>buget</code>.</li>
            <li><strong>Tabelul <code>donatii:</code></strong> Înregistrează contribuțiile financiare (<code>suma</code>, <code>data_donatie</code>) și realizează legătura logică între utilizatori și proiecte prin chei externe.</li>
        </ul>
        <p>Pentru rapoartele complexe, aplicația utilizează interogări de tip <code>JOIN</code> pentru a corela datele din cele trei tabele.</p>
    </section>

    <hr>

    <section>
        <h2>4. Soluții de Implementare și Securitate</h2>
        
        <p>Arhitectura este de tip <strong>Client-Server</strong>, utilizând un model modular unde logica de business este separată de prezentare prin includerea fișierelor de header/footer și funcții utilitare.</p>
        
        <h3>Tehnologii Utilizate:</h3>
        <ul>
            <li><strong>Backend:</strong> PHP (Procedural cu funcții), gestionarea sesiunilor prin <code>session_start()</code>.</li>
            <li><strong>Bază de date:</strong> MySQL (Relațională), utilizând interogări <code>JOIN</code> pentru corelarea datelor.</li>
            <li><strong>Frontend:</strong> HTML5 (semantic), CSS3 (responsiv/media queries).</li>
            <li><strong>Integrări:</strong> Parsare XML curs BNR, comunicare SMTP prin PHPMailer.</li>
            <li><strong>Analytics:</strong> Sistem local de contorizare în fișiere text (<code>.txt</code>).</li>
            <li><strong>Integrare Biblioteci Externe:</strong> Utilizarea clasei <code>FPDF</code> instanțiate prin <code>new PDF()</code> pentru a construi ierarhia documentului (Header, Footer, Body) și pentru a calcula automat numărul de pagini prin <code>AliasNbPages()</code>.</li>
        </ul>

        <h3>Securitate Implementată:</h3>
        <ul>
            <li><strong>SQL Injection:</strong> Utilizarea exclusivă a <code>Prepared Statements</code>.</li>
            <li><strong>XSS & Data Validation:</strong> Output Escaping cu <code>htmlspecialchars()</code> și filtrare emailuri.</li>
            <li><strong>Auth & Securitate:</strong> Parole criptate cu <code>password_hash()</code> și redirecționări securizate după acțiuni.</li>
            <li><strong>Protecție Formulare:</strong> Mecanism CAPTCHA matematic dinamic.</li>
        </ul>

        <h3>Module Speciale:</h3>
        <ul>
            <li><strong>Email SMTP (PHPMailer):</strong> Implementarea comunicării prin protocolul SMTP pe portul 465 (SSL), utilizând clasa <code>PHPMailer</code> și configurarea externă din <code>mail_config.php</code> pentru o rată de livrare ridicată.</li>
            <li><strong>Integrare API Extern:</strong> Preluarea și parsarea dinamică a cursului valutar BNR dintr-un flux XML extern utilizând <code>simplexml_load_file()</code>.</li>
            <li><strong>Export Date (CSV):</strong> Generarea automată de rapoarte descărcabile prin scrierea directă în fluxul <code>php://output</code> folosind funcția <code>fputcsv()</code>.</li>
            <li><strong>Web Analytics Local:</strong> Monitorizarea traficului prin funcții PHP personalizate (<code>file_put_contents</code>) care gestionează contoare în fișiere text locale.</li>
            <li><strong>Raportare PDF Avansată:</strong> Generarea documentelor portabile securizate folosind biblioteca <code>FPDF</code>, procesând datele din baza de date prin interogări de tip <code>JOIN</code> și livrând fișierul direct către browser prin metoda <code>Output()</code>.</li>
        </ul>
        
        <h3>Interfață și Multimedia:</h3>
        <ul>
            <li><strong>Compatibilitatea:</strong> Aplicația utilizează un design responsiv bazat pe unități de măsură relative și meta-tag-ul <code>viewport</code>, asigurând funcționarea corectă pe diverse browsere (Chrome, Firefox, Edge) și dispozitive mobile.</li>
            <li><strong>Elemente Multimedia:</strong> Integrarea conținutului video pentru prezentarea vizuală a impactului unui ONG.</li>
            <li><strong>Protecție Formulare:</strong> Implementarea unui mecanism CAPTCHA matematic dinamic (generat cu <code>rand()</code>) pentru validarea interacțiunilor umane în paginile publice.</li>
            <li><strong>Optimizări SEO:</strong> Utilizarea meta-tag-urilor (<code>description</code>, <code>keywords</code>) și a atributelor <code>alt</code> pentru imagini în <code>header.php</code>.</li>
            <li><strong>Date Structurate:</strong> Utilizarea formatului JSON-LD pentru a defini entitatea ONG și scopul paginilor în fața motoarelor de căutare.</li>
            <li><strong>Ierarhie Semantică:</strong> Organizarea conținutului folosind tag-uri HTML5 (<code>main</code>, <code>article</code>) și titluri dinamice pentru o indexare corectă.</li>
        </ul>
        </ul>
    </section>
    <section>
        <h2>4. Structura Proiectului (Sistem de fișiere)</h2>
        <pre style="background: #f4f4f4; padding: 15px; border-radius: 5px; overflow-x: auto; font-size: 0.9rem;">
            /public_html
            ├── mail/                (Biblioteca PHPMailer și configurări SMTP)
            ├──libs/
            |  ├── fpdf.php (Nucleul bibliotecii de generare PDF)
            |  └── font/ (Conține seturile de caractere necesare pentru afișarea textului)
            ├── adaugare_proiect.php (Formular adăugare proiecte noi)
            ├── contact.php          (Pagina contact cu validare/CAPTCHA)
            ├── dashboard.php        (Panou control - lista proiecte CRUD)
            ├── db.php               (Configurare conexiune MySQL)
            ├── documentatie.php     (Documentația tehnică a proiectului)
            ├── doneaza.php          (Modul procesare donații)
            ├── editare_proiect.php  (Formular modificare proiecte existente)
            ├── export_proiecte.php  (Export CSV Proiecte - Admin)
            ├── footer.php           (Componentă final pagină)
            ├── functii.php          (Logica procesare - contoare vizite)
            ├── header.php           (Meniu navigare, SEO, Sesiuni)
            ├── index.php            (Pagina principală cu video)
            ├── login.php            (Sistem autentificare)
            ├── logout.php           (Închidere sesiune utilizator)
            ├── raport_donatii.php   (Export CSV Donații - Admin)
            ├── raport_pdf.php       (Export PDF Donații - Admin)
            ├── register.php         (Înregistrare voluntari noi)
            ├── statistici.php       (Vizualizare impact, BNR, Analytics)
            ├── stergere_proiect.php (Procesare eliminare proiecte)
            ├── style.css            (Design responsiv/CSS Variables)
            ├── contor_vizite.txt    (Bază de date text pentru analytics pagini)
            ├── vizite.txt           (Bază de date text pentru analytics general)
            ├── imagine_statistici.png (Element multimedia statistici)
            └── logo_ong.png         (Identitate vizuală)
        </pre>
    </section>
</div>

<?php include 'footer.php'; ?>
