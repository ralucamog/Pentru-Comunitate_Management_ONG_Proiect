<?php
// Definirea parametrilor SEO pentru a asigura optimizarea paginii în motoarele de căutare 
$page_title = "Contact"; 
$page_description = "Contactați echipa Pentru Comunitate pentru întrebări sau propuneri de proiecte.";
// Dezactivarea erorilor în varianta finală pentru a nu expune detalii tehnice (aspect de securitate), eu le-am lăsat drept comentarii
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$mesaj_status = "";

// Persistența parametrilor prin metoda POST pentru prelucrarea datelor din formular, se execută DOAR la apăsarea butonului
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['trimite'])) {
   
    // Protecție împotriva transmiterii automate a formularelor publice (CAPTCHA)
    if (isset($_POST['captcha_raspuns'], $_POST['captcha_corect'])) {
        
        if ($_POST['captcha_raspuns'] == $_POST['captcha_corect']) {
            
            // Securizarea împotriva atacurilor XSS prin utilizarea htmlspecialchars
            $nume_exp = htmlspecialchars($_POST['nume']);
            $email_exp = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $subiect_ales = htmlspecialchars($_POST['subiect']);
            $mesaj_text = htmlspecialchars($_POST['mesaj']);

            // Integrare module externe și funcționalitatea de transmitere mesaje email
            // Bibliotecile din folderul 'mail'
            require_once('mail/class.phpmailer.php');
            require_once('mail/mail_config.php');

            $mail = new PHPMailer(true); 
            $mail->IsSMTP();

            try {
                $mail->PluginDir = "mail/"; 
                $mail->SMTPAuth   = true; 
                $mail->SMTPSecure = "ssl";                 
                $mail->Host       = "mail.rmogildea.daw.ssmr.ro"; 
                $mail->Port       = 465;                   
                $mail->Username   = $username; // Din mail_config.php
                $mail->Password   = $password; // Din mail_config.php
                
                $mail->AddAddress('rmmog@rmogildea.daw.ssmr.ro', 'Admin ONG');
                $mail->AddReplyTo($email_exp, $nume_exp);
                $mail->SetFrom($username, 'Formular Contact ONG');
                
                $mail->Subject = $subiect_ales;

                // Formatare HTML pentru corpul email-ului
                $corp_email = "
                    <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                        <h2 style='color: #e91e63;'>Mesaj Nou de pe Site</h2>
                        <p><strong>Expeditor:</strong> {$nume_exp} ({$email_exp})</p>
                        <p><strong>Subiect:</strong> {$subiect_ales}</p>
                        <hr style='border: 0; border-top: 1px solid #eee;'>
                        <p><strong>Mesaj:</strong></p>
                        <div style='background: #f9f9f9; padding: 15px; border-left: 4px solid #e91e63;'>
                            " . nl2br($mesaj_text) . "
                        </div>
                        <br>
                        <p style='font-size: 0.8em; color: #999;'>Acest mesaj a fost trimis prin formularul de contact de pe rmogildea.daw.ssmr.ro.</p>
                    </div>
                ";
                
                $mail->MsgHTML($corp_email);

                if ($mail->Send()) {
                    // Redirecționare pentru a evita re-trimiterea formularului la refresh
                    header("Location: contact.php?sent=success");
                    exit();
                }
            } catch (Exception $e) {
                $mesaj_status = "<p style='color:red; text-align:center;'>Eroare trimitere: " . $mail->ErrorInfo . "</p>";
            }
        } else {
            $mesaj_status = "<p style='color:red; text-align:center;'>Cod CAPTCHA incorect!</p>";
        }
    }
}

include 'header.php'; 
?>

<div class="container" style="max-width: 800px; margin: 40px auto; padding: 20px;">
    <h2 style="margin-bottom: 25px;">Contact</h2>
    
    <?php 
        // Gestionarea feedback-ului vizual pentru utilizator
        if (isset($_GET['sent']) && $_GET['sent'] == 'success') {
            echo "<p style='color: #28a745; font-weight: bold; text-align: center; margin-bottom: 20px;'>Succes! Mesajul a fost trimis!</p>";
        }
        echo $mesaj_status; 
    ?>

    <form method="POST" action="contact.php">
        <input type="text" name="nume" placeholder="Numele tău" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #eee; border-radius: 5px;">
        
        <input type="email" name="email" placeholder="Email-ul tău" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #eee; border-radius: 5px;">
        
        <input type="text" name="subiect" placeholder="Subiect" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #eee; border-radius: 5px;">
        
        <textarea name="mesaj" placeholder="Mesajul tău" rows="6" required style="width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #eee; border-radius: 5px; font-family: inherit;"></textarea>

        <?php 
            // Mecanism CAPTCHA matematic dinamic generat cu rand()
            $n1 = rand(1, 9); 
            $n2 = rand(1, 9); 
        ?>
        <p>Cât face <strong><?php echo "$n1 + $n2"; ?></strong>?</p>
        <input type="hidden" name="captcha_corect" value="<?php echo $n1 + $n2; ?>">
        <input type="number" name="captcha_raspuns" required style="width: 80px; padding: 10px; border: 1px solid #eee; border-radius: 5px;">
        
        <br><br>
        <button type="submit" name="trimite" class="btn-add" style="background-color: #e91e63; color: white; border: none; padding: 12px 30px; border-radius: 25px; cursor: pointer; font-weight: bold; width: 100%;">
            Trimite Mesaj
        </button>
    </form>
</div>

<?php include 'footer.php'; ?>