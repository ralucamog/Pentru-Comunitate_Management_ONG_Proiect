# Pentru-Comunitate_Management_ONG_Proiect
# Proiect DAW

## "Pentru Comunitate" este o platformă web integrată destinată gestionării activităților unui ONG, facilitând interacțiunea digitală între administratori și voluntari/donatori. Sistemul permite monitorizarea proiectelor sociale, colectarea donațiilor și generarea de rapoarte de impact (doar de către administratori).

## Arhitectura Sistemului

Aplicația utilizează o arhitectură de tip **Client-Server**, bazată pe un model modular:
* **Logica de Business:** Separată de prezentare prin includerea fișierelor de `header`/`footer` și funcții utilitare.
* **Managementul Sesiunilor:** Utilizarea `session_start()` pentru menținerea stării utilizatorului.
* **Control Acces:** Restricționarea funcțiilor critice (CRUD) pe baza rolului de `admin`.

## Funcționalități importante:

* **Sistem de Autentificare:** Acces diferențiat pe bază de roluri (**Administrator** vs. **Voluntar**).
* **Gestiune CRUD:** Interfață completă pentru adăugarea, editarea și ștergerea proiectelor sociale.
* **Rapoarte Automate:** Generare de fișiere **CSV** pentru proiecte și donații, optimizate cu **UTF-8 BOM** pentru afișarea corectă a diacriticelor în Excel.

## Tehnologii Utilizate

### Backend & Bază de Date
* **PHP:** Procedural cu funcții, gestionarea sesiunilor și procesare logică.
* **MySQL:** Bază de date relațională utilizând interogări de tip `JOIN` pentru corelarea datelor.
* **FPDF(v.1.86):** Bibliotecă PHP utilizată pentru generarea dinamică a documentelor PDF fără dependințe externe grele.

### Frontend & Multimedia
* **HTML5 & CSS3:** Design responsiv bazat pe unități relative și meta-tag-ul `viewport`.
* **SEO:** Utilizarea meta-tag-urilor, atributelor `alt` și datelor structurate **JSON-LD**.
* **Multimedia:** Integrare conținut video pentru prezentarea vizuală a impactului ONG-ului.

### Integrări & Securitate
* **BNR XML API:** Preluarea cursului valutar în timp real prin `simplexml_load_file()`.
* **PHPMailer:** Comunicare SMTP securizată pe portul 465 (SSL).
* **Prepared Statements:** Protecție completă împotriva **SQL Injection**.
* **Criptare:** Parole securizate prin `password_hash()` și `password_verify()`.
* **CAPTCHA:** Mecanism matematic dinamic pentru protecția formularelor.

## Module Speciale:
* **Email SMTP (PHPMailer):** Implementarea comunicării prin protocolul SMTP pe portul 465 (SSL), utilizând clasa PHPMailer și configurarea externă din mail_config.php pentru o rată de livrare ridicată.
* **Integrare API Extern:** Preluarea și parsarea dinamică a cursului valutar BNR dintr-un flux XML extern utilizând simplexml_load_file().
* **Export Date (CSV):** Generarea automată de rapoarte descărcabile prin scrierea directă în fluxul php://output folosind funcția fputcsv().
* **Generare Rapoarte (PDF):** Sistem de raportare vizuală pentru managementul donațiilor, oferind un format securizat și gata de tipărit.
* **Web Analytics Local:** Monitorizarea traficului prin funcții PHP personalizate (file_put_contents) care gestionează contoare în fișiere text locale.

## Interfață și Multimedia:
* **Compatibilitatea:** Aplicația utilizează un design responsiv bazat pe unități de măsură relative și meta-tag-ul viewport, asigurând funcționarea corectă pe diverse browsere (Chrome, Firefox, Edge) și dispozitive mobile.
* **Elemente Multimedia:** Integrarea conținutului video pentru prezentarea vizuală a impactului unui ONG.
* **Protecție Formulare:** Implementarea unui mecanism CAPTCHA matematic dinamic (generat cu rand()) pentru validarea interacțiunilor umane în paginile publice.
* **Optimizări SEO:** Utilizarea meta-tag-urilor (description, keywords) și a atributelor alt pentru imagini în header.php.
* **Date Structurate:** Utilizarea formatului JSON-LD pentru a defini entitatea ONG și scopul paginilor în fața motoarelor de căutare.
* **Ierarhie Semantică:** Organizarea conținutului folosind tag-uri HTML5 (main, article) și titluri dinamice pentru o indexare corectă.

## Instalare și Configurare:
* **Baza de date:** Importă fișierul rmogildea_proiect.sql în serverul tău MySQL (phpMyAdmin).
* **Conexiune:** Editează fișierul db.php cu datele tale de conectare (localhost, user, parolă).
* **Configurare Mail:** Setările SMTP se realizează în contact.php și în folderul mail/ sau în fișierul de configurare dedicat.
* **Permisiuni:** Asigură-te că fișierele .txt au permisiuni de scriere pentru funcționarea sistemului de analytics.
## Structura Proiectului
```text
```text
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
├── logo_ong.png         (Identitate vizuală)
└── rmogildea_proiect.sql (Scriptul pentru baza de date)
