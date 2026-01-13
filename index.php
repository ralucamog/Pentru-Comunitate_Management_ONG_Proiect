<?php
$page_title = "Acasă";
$page_description = "Pagina de start după login, unde avem o sinteză la ce face un ONG";
include 'header.php';
?>


<main>
    <section class="presentation-section" style="text-align: center; padding: 60px 20px; max-width: 1000px; margin: 0 auto;">

        <h1 style="color: var(--pink); font-size: 2.5rem; margin-bottom: 20px;">
            Povestea Noastră 
        </h1>
        <p style="font-size: 1.3em; max-width: 700px; margin: 0 auto 40px auto; color: #555; line-height: 1.6;">
            Suntem vocea celor care au nevoie de ajutor. Urmărește videoclipul de mai jos pentru a înțelege ce este un ONG și cum se poate transforma generozitatea în speranță reală.
        </p>
        
        <div class="video-frame" style="background-color: #fff0f5;
                                        padding: 20px; /* Spațiu între video și ramă */
                                        border-radius: 30px; /* Colțuri foarte rotunjite pentru ramă */
                                        box-shadow: 0 10px 30px rgba(225, 33, 105, 0.15);
                                        max-width: 800px; margin: 0 auto;">

            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 15px;">
                <iframe
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                    src="https://www.youtube.com/embed/BiIlXavREFo?rel=0&modestbranding=1"
                    title="Prezentare Video Asociație"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <div style="margin-top: 50px;">

            <?php
                // Mecanism simplu de autentificare pentru personalizarea experienței 
                if (isset($_SESSION['user_id'])): ?>
                <p style="font-size: 1.1rem;">Bine ai revenit, <strong><?php echo htmlspecialchars($_SESSION['nume']); ?></strong>!</p>
                <a href="dashboard.php" class="btn-main" style="margin-top: 10px; display: inline-block;">Mergi la Panou</a>
            <?php else: ?>
                <a href="login.php" class="btn-main" style="padding: 15px 40px; font-size: 1.2rem; background-color: var(--pink); color: white; border-radius: 30px; text-decoration: none; display: inline-block;">Alătură-te Nouă</a>
            <?php endif; ?>
        </div>

    </section>

    <section class="features" style="display: flex; gap: 25px; padding: 40px 20px 80px 20px; max-width: 1200px; margin: 0 auto; flex-wrap: wrap;">
        <article class="card" style="flex: 1 1 300px; text-align: center; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); background: white;">
            <h2 style="color: var(--pink); font-size: 1.5rem; margin-bottom: 15px;">Proiecte Sociale</h2>
            <p style="color: #666;">Inițiative educaționale și sociale active în toată țara.</p>
        </article>

        <article class="card" style="flex: 1 1 300px; text-align: center; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); background: white;">
            <h2 style="color: var(--pink); font-size: 1.5rem; margin-bottom: 15px;">Comunitate Voluntari</h2>
            <p style="color: #666;">
                <?php
                    include 'db.php';
                    $nr_voluntari = 0;
                    // Un try-catch simplu pentru a evita erori fatale dacă BD nu merge
                    try {
                        $v = $conn->query("SELECT COUNT(*) as t FROM utilizatori");
                        if($v) {
                             $nr_voluntari = $v->fetch_assoc()['t'];
                        }
                        } catch (Exception $e) { 
                            $nr_voluntari = "mulți";
                        }
                    // Dacă este 1, folosim "om", altfel "oameni"
                    $text_om = ($nr_voluntari == 1) ? "om inimos implicat activ" : "oameni inimoși implicați activ";
            
                    // Afișăm introducerea (scoatem "peste" dacă avem doar 1 om pentru a suna natural)
                    echo ($nr_voluntari == 1) ? "O familie de " : "O familie de ";
                ?>
                <strong style="color: var(--pink); font-size: 1.2em;">
                    <?php echo $nr_voluntari; ?>
                </strong>
                <?php echo $text_om; ?>.
            </p>
        </article>

        <article class="card" style="flex: 1 1 300px; text-align: center; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); background: white;">
            <h2 style="color: var(--pink); font-size: 1.5rem; margin-bottom: 15px;">Transparență Totală</h2>
            <p style="color: #666;">Fiecare sumă donată este urmărită pentru a asigura impactul maxim.</p>
        </article>
    </section>
</main>

<?php include 'footer.php'; ?>