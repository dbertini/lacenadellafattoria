<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto in GeoTriangulator - Triangolazione Coordinate Avanzata</title>
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
            <div class="cta-buttons">
                <a href="troviamoci.php" class="cta-button cta-primary">🎯 Triangolazione Geografica</a>
                <a href="sondaggi.php" class="cta-button cta-secondary">🗳️ Partecipa ai Sondaggi</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number" data-target="0">0</span>
                    <span class="stat-label">Sondaggi Totali</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="0">0</span>
                    <span class="stat-label">Sondaggi Attivi</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="0">0</span>
                    <span class="stat-label">Voti Raccolti</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-target="0">0</span>
                    <span class="stat-label">Partecipanti</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2>Funzionalità Complete</h2>
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
                    <div class="feature-icon">🍽️</div>
                    <h3>Suggerimenti Intelligenti</h3>
                    <p>Trova automaticamente ristoranti e luoghi di interesse nel punto centrale calcolato. Perfetto per organizzare incontri.</p>
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
            </div>
        </div>
    </section>

    <!-- Recent Polls Section -->
    <section class="recent-polls">
        <div class="recent-polls-container">
            <h2>📈 Sondaggi Recenti</h2>
            <div class="polls-grid">
                <div class="poll-card" style="grid-column: 1/-1; text-align: center; padding: 60px 30px;">
                    <h3 style="color: #4a5568; margin-bottom: 15px;">🤔 Nessun sondaggio disponibile</h3>
                    <p style="color: #718096; margin-bottom: 25px;">Inizia creando il primo sondaggio o configura il database per visualizzare i sondaggi esistenti!</p>
                    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <a href="admin.php" class="btn-primary btn-small" style="max-width: 200px; display: inline-block;">➕ Crea Sondaggio</a>
                        <a href="sondaggi.php" class="btn-success btn-small" style="max-width: 200px; display: inline-block;">🗳️ Vai ai Sondaggi</a>
                    </div>
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
                        const target = parseInt(counter.getAttribute('data-target') || counter.textContent);
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

            // Simula il caricamento delle statistiche dal database
            loadStatistics();
        });

        // Funzione per simulare il caricamento delle statistiche
        function loadStatistics() {
            // Simula valori di esempio - in produzione questi arriverebbero dal database
            const stats = [
                { selector: '.stat-number:nth-child(1)', value: 12 },
                { selector: '.stat-number:nth-child(1)', value: 8 },
                { selector: '.stat-number:nth-child(1)', value: 47 },
                { selector: '.stat-number:nth-child(1)', value: 23 }
            ];

            // Aggiorna i data-target per l'animazione
            document.querySelectorAll('.stat-number').forEach((el, index) => {
                const value = Math.floor(Math.random() * 50); // Valori casuali per la demo
                el.setAttribute('data-target', value);
            });
        }

        // Animazione al caricamento della pagina
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>