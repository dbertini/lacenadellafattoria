<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    nav {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
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
        padding: 8px 16px;
        border-radius: 20px;
    }
    .nav-links a:hover {
        background: linear-gradient(135deg, #4299e1, #3182ce);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(66, 153, 225, 0.3);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 50px 20px;
    }

    .header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    .header h1 {
        color: #4a5568;
        margin: 0 0 10px 0;
        font-size: 2.5em;
    }
    .header p {
        color: #718096;
        margin: 0;
        font-size: 1.2em;
    }

    .sondaggio-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .sondaggio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .sondaggio-title {
        color: #4a5568;
        font-size: 2em;
        margin: 0 0 15px 0;
        font-weight: 600;
    }
    .sondaggio-description {
        color: #718096;
        font-size: 1.1em;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    .sondaggio-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        font-size: 0.95em;
        color: #718096;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .vote-form {
        border-top: 2px solid #e2e8f0;
        padding-top: 30px;
    }
    .form-section {
        margin-bottom: 25px;
    }
    .form-section h3 {
        color: #4a5568;
        margin: 0 0 20px 0;
        font-size: 1.3em;
    }

    .user-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: #4a5568;
        font-weight: 600;
        margin-bottom: 8px;
    }
    .form-group input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1em;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    .form-group input:focus {
        outline: none;
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    /* --- Opzioni (radio + checkbox) unificate --- */
    .options-grid {
        display: grid;
        gap: 15px;
        margin-bottom: 30px;
    }
    .option-item {
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    .option-item:hover {
        border-color: #4299e1;
        background: #ebf8ff;
        transform: translateX(5px);
    }
    .option-item input[type="radio"],
    .option-item input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }
    .option-item.selected {
        border-color: #4299e1;
        background: #ebf8ff;
        box-shadow: 0 5px 15px rgba(66, 153, 225, 0.2);
    }
    .option-text {
        color: #4a5568;
        font-weight: 600;
        font-size: 1.1em;
        padding-left: 35px;
        position: relative;
    }
    .option-text::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 2px solid #cbd5e0;
        border-radius: 4px;     /* quadrato con angoli leggermente arrotondati */
        background: white;
        transition: all 0.3s ease;
    }
    .option-item.selected .option-text::before {
        border-color: #4299e1;
        background: #4299e1;
        box-shadow: inset 0 0 0 4px white;
    }
    /* --- Fine opzioni --- */

    .btn {
        background: linear-gradient(135deg, #4299e1, #3182ce);
        color: white;
        padding: 18px 40px;
        border: none;
        border-radius: 12px;
        font-size: 1.2em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(66, 153, 225, 0.4);
    }
    .btn:disabled {
        background: #cbd5e0;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .alert {
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-weight: 600;
    }
    .alert-success {
        background: #c6f6d5;
        color: #22543d;
        border: 2px solid #9ae6b4;
    }
    .alert-error {
        background: #fed7d7;
        color: #742a2a;
        border: 2px solid #fc8181;
    }
    .alert-warning {
        background: #fef5e7;
        color: #744210;
        border: 2px solid #f6ad55;
    }

    .status-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9em;
        font-weight: 600;
    }
    .status-attivo {
        background: #c6f6d5;
        color: #22543d;
    }
    .status-scaduto {
        background: #fed7d7;
        color: #742a2a;
    }

    .no-sondaggi {
        text-align: center;
        padding: 60px 20px;
        color: #718096;
    }
    .no-sondaggi h3 {
        font-size: 1.5em;
        margin-bottom: 15px;
    }

    .footer {
        background: rgba(26, 32, 44, 0.9);
        color: white;
        text-align: center;
        padding: 40px 20px;
        backdrop-filter: blur(10px);
    }

    @media (max-width: 768px) {
        .container {
            padding: 30px 15px;
        }
        .sondaggio-card {
            padding: 25px 20px;
        }
        .user-info {
            grid-template-columns: 1fr;
        }
        .sondaggio-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
