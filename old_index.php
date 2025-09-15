<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoTriangulator - Sistema Sondaggi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Navigation Menu */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }
        nav .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
        }
        .logo {
            font-size: 1.8em;
            font-weight: bold;
            background: linear-gradient(135deg, #4299e1, #3182ce);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .nav-links {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 30px;
        }
        .nav-links a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            padding: 8px 16px;
            border-radius: 20px;
        }
        .nav-links a:hover {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(66, 153, 225, 0.3);
        }
        
        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 100px 20px 50px;
            position: relative;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }
        .hero h1 {
            font-size: 4em;
            color: white;
            margin: 0 0 20px 0;
            text-shadow: 2px 2px 20px rgba(0, 0, 0, 0.3);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
        }
        .hero p {
            font-size: 1.3em;
            color: rgba(255, 255, 255, 0.9);
            margin: 0 0 40px 0;
            line-height: 1.6;
            opacity: 0;
            animation: fadeInUp 1s ease 0.3s forwards;
        }
        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
        }
        .cta-button {
            display: inline-block;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        .cta-primary {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }
        .cta-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(72, 187, 120, 0.4);
        }
        .cta-secondary {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
        }
        .cta-secondary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(66, 153, 225, 0.4);
        }
        
        /* Stats Section */
        .stats {
            padding: 80px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            text-align: center;
        }
        .stat-item {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px 20px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .stat-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }
        .stat-number {
            font-size: 3em;
            font-weight: bold;
            color: #4299e1;
            display: block;
            margin-bottom: 10px;
        }
        .stat-label {
            color: #4a5568;
            font-size: 1.1em;
            font-weight: 600;
        }
        
        /* Features Section */
        .features {
            padding: 100px 20px;
            background: rgba(255, 255, 255, 0.05);
        }
        .features-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .features h2 {
            text-align: center;
            color: white;
            font-size: 3em;
            margin: 0 0 60px 0;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }
        .feature-card:nth-child(1) { border-top-color: #4299e1; }
        .feature-card:nth-child(2) { border-top-color: #48bb78; }
        .feature-card:nth-child(3) { border-top-color: #ed8936; }
        .feature-card:nth-child(4) { border-top-color: #9f7aea; }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }
        .feature-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }
        .feature-card:nth-child(1) .feature-icon { color: #4299e1; }
        .feature-card:nth-child(2) .feature-icon { color: #48bb78; }
        .feature-card:nth-child(3) .feature-icon { color: #ed8936; }
        .feature-card:nth-child(4) .feature-icon { color: #9f7aea; }
        
        .feature-card h3 {
            color: #4a5568;
            font-size: 1.5em;
            margin: 0 0 15px 0;
        }
        .feature-card p {
            color: #718096;
            line-height: 1.6;
            margin: 0;
        }
        
        /* Recent Polls Section */
        .recent-polls {
            padding: 100px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        .recent-polls-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .recent-polls h2 {
            text-align: center;
            color: white;
            font-size: 3em;
            margin: 0 0 60px 0;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }
        .polls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }
        .poll-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .poll-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        .poll-title {
            color: #4a5568;
            font-size: 1.4em;
            font-weight: 600;
            margin: 0 0 15px 0;
        }
        .poll-meta {
            color: #718096;
            font-size: 0.9em;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .poll-winner {
            background: #f0fff4;
            border: 2px solid #c6f6d5;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .poll-winner-title {
            color: #22543d;
            font-size: 0.9em;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .poll-winner-text {
            color: #38a169;
            font-weight: 600;
        }
        .poll-actions {
            display: flex;
            gap: 10px;
        }
        .btn-small {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            font-size: 0.9em;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 153, 225, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: 600;
        }
        .status-attivo { background: #c6f6d5; color: #22543d; }
        .status-scaduto { background: #fed7d7; color: #742a2a; }
        
        /* Footer */
        .footer {
            background: rgba(26, 32, 44, 0.9);
            color: white;
            text-align: center;
            padding: 40px 20px;
            backdrop-filter: blur(10px);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Floating elements */
        .floating-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.7;
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
                opacity: 1;
            }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 20px;
                padding: 0 20px;
            }
            .nav-links {
                gap: 15px;
            }
            .hero {
                padding: 120px 20px 50px;
            }
            .hero h1 {
                font-size: 2.5em;
            }
            .hero p {
                font-size: 1.1em;
            }
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            .features h2, .recent-polls h2 {
                font-size: 2.2em;
            }
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            .polls-grid {
                grid-template-columns: 1fr;
            }
            .poll-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">🗳️ GeoTriangulator Sondaggi</div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="sondaggi.php">🗳️ Sondaggi</a></li>
                <li><a href="risultati.php">📊 Risultati</a></li>
                <li><a href="admin.php">🛠️ Admin</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <div class="hero-content">
            <h1>Sistema Sondaggi Avanzato</h1>
            <p>Crea, gestisci e analizza sondaggi con la nostra piattaforma intuitiva e potente. Raccogli opinioni, prendi decisioni informate e coinvolgi la tua community.</p>
            <div class="cta-buttons">
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

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2>Funzionalità Principali</h2>
            <div class="features-grid">
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

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 GeoTriangulator Sondaggi. Sistema di votazione intelligente per decisioni migliori. 🚀</p>
    </footer>

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