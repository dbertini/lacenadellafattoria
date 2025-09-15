<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto - Triangolazione Coordinate Avanzata</title>
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
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-size: 1.2em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
            opacity: 0;
            animation: fadeInUp 1s ease 0.6s forwards;
        }
        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(72, 187, 120, 0.4);
        }
        
        /* Features Section */
        .features {
            padding: 100px 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
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
            .features h2 {
                font-size: 2.2em;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">🌍 GeoTriangulator</div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="troviamoci.php">🎯 Troviamoci</a></li>
                <li><a href="#features">Funzionalità</a></li>
                <li><a href="#about">Chi Siamo</a></li>
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
            <h1>Benvenuto in GeoTriangulator</h1>
            <p>La piattaforma più avanzata per la triangolazione di coordinate geografiche. Trova il punto perfetto per i tuoi incontri utilizzando i più sofisticati algoritmi di geolocalizzazione precisi e intuitivi.</p>
            <a href="troviamoci.php" class="cta-button">✨ Inizia Subito</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="features-container">
            <h2>Perché Scegliere GeoTriangulator?</h2>
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
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 GeoTriangulator. Creato con passione per semplificare i vostri incontri. 🚀</p>
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

        // Animazione al caricamento della pagina
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>