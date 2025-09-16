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
        .feature-card:nth-child(5) { border-top-color: #f56565; }
        .feature-card:nth-child(6) { border-top-color: #38b2ac; }
        
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
        .feature-card:nth-child(5) .feature-icon { color: #f56565; }
        .feature-card:nth-child(6) .feature-icon { color: #38b2ac; }
        
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