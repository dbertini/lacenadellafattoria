<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTriangulator - Sistema Sondaggi</title>
    <?php require 'styles.php'; ?>
</head>
<body>
    <?php require 'menu.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="hero-content">
            <h1>Benvenuto in GeoTriangulator</h1>
            <p>La piattaforma più avanzata per la triangolazione di coordinate geografiche e sondaggi intelligenti. Trova il punto perfetto per i tuoi incontri e prendi decisioni collaborative utilizzando algoritmi di geolocalizzazione precisi e intuitivi.</p>
            <p>Crea, gestisci e analizza sondaggi con la nostra piattaforma intuitiva e potente. Raccogli opinioni, prendi decisioni informate e coinvolgi la tua community.</p>
            <div class="cta-buttons">
                <a href="troviamoci.php" class="cta-button cta-primary">🎯 Triangolazione Geografica</a>
                <a href="sondaggi.php" class="cta-button cta-primary">🗳️ Partecipa ai Sondaggi</a>
                <a href="risultati.php" class="cta-button cta-secondary">📈 Vedi i Risultati</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stats-grid">
                <?php
                require_once 'config.php';
                try {
                    $pdo = getDBConnection();
                    
                    // Conta sondaggi totali
                    $stmt = $pdo->query("SELECT COUNT(*) FROM sondaggi");
                    $totale_sondaggi = $stmt->fetchColumn();
                    
                    // Conta sondaggi attivi
                    $stmt = $pdo->query("SELECT COUNT(*) FROM sondaggi WHERE attivo = 1 AND (data_scadenza IS NULL OR data_scadenza > NOW())");
                    $sondaggi_attivi = $stmt->fetchColumn();
                    
                    // Conta voti totali
                    $stmt = $pdo->query("SELECT COUNT(*) FROM voti");
                    $voti_totali = $stmt->fetchColumn();
                    
                    // Conta partecipanti unici
                    $stmt = $pdo->query("SELECT COUNT(DISTINCT CONCAT(nome_votante, COALESCE(email_votante, ''))) FROM voti");
                    $partecipanti_unici = $stmt->fetchColumn();
                    
                } catch (Exception $e) {
                    // Valori di fallback se il database non è disponibile
                    $totale_sondaggi = 0;
                    $sondaggi_attivi = 0;
                    $voti_totali = 0;
                    $partecipanti_unici = 0;
                }
                ?>
                
                <div class="stat-item">
                    <span class="stat-number"><?php echo $totale_sondaggi; ?></span>
                    <span class="stat-label">Sondaggi Totali</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $sondaggi_attivi; ?></span>
                    <span class="stat-label">Sondaggi Attivi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $voti_totali; ?></span>
                    <span class="stat-label">Voti Raccolti</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number"><?php echo $partecipanti_unici; ?></span>
                    <span class="stat-label">Partecipanti</span>
                </div>
            </div>
        </div>
    </section>
<!-- Recent Polls Section -->
    <section class="recent-polls">
        <div class="recent-polls-container">
            <h2>📈 Sondaggi Recenti</h2>
            <div class="polls-grid">
                <?php
                if (isset($pdo)) {
                    try {
                        // Ottieni gli ultimi 3 sondaggi con i risultati
                        $stmt = $pdo->query("
                            SELECT 
                                s.id,
                                s.titolo,
                                s.descrizione,
                                s.data_creazione,
                                s.data_scadenza,
                                s.attivo,
                                COUNT(v.id) as totale_voti,
                                (SELECT os.testo_opzione 
                                 FROM opzioni_sondaggio os 
                                 LEFT JOIN voti v2 ON os.id = v2.opzione_id 
                                 WHERE os.sondaggio_id = s.id 
                                 GROUP BY os.id 
                                 ORDER BY COUNT(v2.id) DESC 
                                 LIMIT 1) as opzione_vincente,
                                (SELECT COUNT(v2.id) 
                                 FROM opzioni_sondaggio os 
                                 LEFT JOIN voti v2 ON os.id = v2.opzione_id 
                                 WHERE os.sondaggio_id = s.id 
                                 GROUP BY os.id 
                                 ORDER BY COUNT(v2.id) DESC 
                                 LIMIT 1) as voti_vincente
                            FROM sondaggi s 
                            LEFT JOIN voti v ON s.id = v.sondaggio_id 
                            GROUP BY s.id 
                            ORDER BY s.data_creazione DESC 
                            LIMIT 3
                        ");
                        
                        $sondaggi_recenti = $stmt->fetchAll();
                        
                        if (empty($sondaggi_recenti)) {
                            echo '<div class="poll-card" style="grid-column: 1/-1; text-align: center; padding: 60px 30px;">
                                    <h3 style="color: #4a5568; margin-bottom: 15px;">🤔 Nessun sondaggio disponibile</h3>
                                    <p style="color: #718096; margin-bottom: 25px;">Inizia creando il primo sondaggio!</p>
                                    <a href="admin.php" class="btn-primary btn-small" style="max-width: 200px; display: inline-block;">➕ Crea Sondaggio</a>
                                  </div>';
                        } else {
                            foreach ($sondaggi_recenti as $sondaggio) {
                                $isAttivo = isSondaggioAttivo($sondaggio);
                                $statusClass = $isAttivo ? 'status-attivo' : 'status-scaduto';
                                $statusText = $isAttivo ? 'Attivo' : 'Scaduto';
                                
                                echo '<div class="poll-card">
                                        <h3 class="poll-title">' . htmlspecialchars($sondaggio['titolo']) . '</h3>
                                        <div class="poll-meta">
                                            <span>📅 ' . date('d/m/Y', strtotime($sondaggio['data_creazione'])) . '</span>
                                            <span class="status-badge ' . $statusClass . '">' . $statusText . '</span>
                                        </div>';
                                
                                if ($sondaggio['totale_voti'] > 0 && $sondaggio['opzione_vincente']) {
                                    echo '<div class="poll-winner">
                                            <div class="poll-winner-title">🏆 Opzione in testa:</div>
                                            <div class="poll-winner-text">"' . htmlspecialchars($sondaggio['opzione_vincente']) . '"</div>
                                            <div style="color: #718096; font-size: 0.9em; margin-top: 5px;">' . $sondaggio['voti_vincente'] . ' voti su ' . $sondaggio['totale_voti'] . ' totali</div>
                                          </div>';
                                } else {
                                    echo '<div style="background: #fef5e7; border: 2px solid #f6ad55; border-radius: 12px; padding: 15px; margin-bottom: 20px; text-align: center; color: #744210;">
                                            📭 Nessun voto ancora
                                          </div>';
                                }
                                
                                echo '<div class="poll-actions">
                                        <a href="risultati.php?id=' . $sondaggio['id'] . '" class="btn-small btn-primary">📈 Risultati</a>';
                                
                                if ($isAttivo) {
                                    echo '<a href="sondaggi.php" class="btn-small btn-success">🗳️ Vota</a>';
                                }
                                
                                echo '</div></div>';
                            }
                        }
                        
                    } catch (Exception $e) {
                        echo '<div class="poll-card" style="grid-column: 1/-1; text-align: center; padding: 60px 30px; border: 2px solid #fed7d7; background: #fef5f5;">
                                <h3 style="color: #742a2a; margin-bottom: 15px;">⚠️ Errore di connessione</h3>
                                <p style="color: #742a2a;">Impossibile caricare i sondaggi. Verifica la configurazione del database.</p>
                              </div>';
                    }
                } else {
                    echo '<div class="poll-card" style="grid-column: 1/-1; text-align: center; padding: 60px 30px;">
                            <h3 style="color: #4a5568; margin-bottom: 15px;">🔧 Configurazione necessaria</h3>
                            <p style="color: #718096;">Configura il database per iniziare a utilizzare i sondaggi.</p>
                          </div>';
                }
                ?>
            </div>
            
            <?php if (isset($sondaggi_recenti) && count($sondaggi_recenti) >= 3): ?>
                <div style="text-align: center; margin-top: 40px;">
                    <a href="risultati.php" class="cta-button cta-secondary">📊 Vedi Tutti i Risultati</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2>Funzionalità Principali</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Triangolazione Precisa</h3>
                    <p>Algoritmi avanzati per calcolare il punto ottimale equidistante da tutti i partecipanti. Massima precisione garantita.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🗺️</div>
                    <h3>Mappe Interattive</h3>
                    <p>Visualizza i risultati su mappe dettagliate con markers personalizzati e informazioni sui ristoranti nelle vicinanze.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🗳️</div>
                    <h3>Sondaggi Intuitivi</h3>
                    <p>Crea sondaggi con opzioni multiple facilmente. Interface user-friendly per massima partecipazione.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Analisi Dettagliate</h3>
                    <p>Visualizza risultati in tempo reale con grafici e statistiche complete per ogni sondaggio.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Gestione Partecipanti</h3>
                    <p>Traccia chi ha partecipato, previeni voti duplicati e mantieni la trasparenza del processo.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚙️</div>
                    <h3>Pannello Admin</h3>
                    <p>Gestisci tutti i sondaggi da un'unica dashboard. Attiva, disattiva e monitora facilmente.</p>
                </div>
            </div>
        </div>
    </section>

    

    <?php require 'footer.php'; ?>

    <script>
        // Smooth scrolling per i link di navigazione
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Effetto parallax leggero per le forme fluttuanti
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const shapes = document.querySelectorAll('.shape');
            
            shapes.forEach((shape, index) => {
                const speed = (index + 1) * 0.5;
                shape.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Animazione contatori nelle statistiche
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = parseInt(counter.textContent);
                        let current = 0;
                        const increment = target / 50;
                        
                        const updateCounter = () => {
                            if (current < target) {
                                current += increment;
                                counter.textContent = Math.ceil(current);
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.textContent = target;
                            }
                        };
                        
                        updateCounter();
                        observer.unobserve(counter);
                    }
                });
            });
            
            counters.forEach(counter => observer.observe(counter));
        }

        // Avvia le animazioni quando il DOM è caricato
        document.addEventListener('DOMContentLoaded', () => {
            animateCounters();
            
            // Animazione di entrata per le cards
            const cards = document.querySelectorAll('.feature-card, .poll-card');
            const cardObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '0';
                        entry.target.style.transform = 'translateY(30px)';
                        entry.target.style.transition = 'all 0.6s ease';
                        
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, 100);
                        
                        cardObserver.unobserve(entry.target);
                    }
                });
            });
            
            cards.forEach(card => cardObserver.observe(card));
        });

        // Animazione al caricamento della pagina
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>