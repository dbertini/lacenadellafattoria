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
        
        .admin-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .admin-header h1 {
            color: #4a5568;
            margin: 0 0 10px 0;
            font-size: 2.5em;
        }
        .admin-header p {
            color: #718096;
            margin: 0;
            font-size: 1.2em;
        }
        
        .section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .section h2 {
            color: #4a5568;
            margin: 0 0 30px 0;
            font-size: 1.8em;
            border-bottom: 3px solid #4299e1;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 1.1em;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1em;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-group input:focus, .form-group textarea:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }
        .form-group textarea {
            height: 100px;
            resize: vertical;
        }
        
        .options-container {
            border: 2px dashed #cbd5e0;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }
        .option-input {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 10px;
        }
        .option-input input {
            flex: 1;
            margin: 0;
        }
        .remove-option {
            background: #e53e3e;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .remove-option:hover {
            background: #c53030;
            transform: scale(1.1);
        }
        
        .btn {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 153, 225, 0.3);
        }
        .btn-success {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }
        .btn-success:hover {
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.3);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #718096, #4a5568);
        }
        .btn-secondary:hover {
            box-shadow: 0 8px 20px rgba(113, 128, 150, 0.3);
        }
        
        .sondaggi-list {
            display: grid;
            gap: 20px;
        }
        .sondaggio-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            transition: all 0.3s ease;
        }
        .sondaggio-card:hover {
            border-color: #4299e1;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .sondaggio-title {
            color: #4a5568;
            margin: 0 0 10px 0;
            font-size: 1.3em;
            font-weight: 600;
        }
        .sondaggio-meta {
            color: #718096;
            font-size: 0.9em;
            margin-bottom: 15px;
        }
        .sondaggio-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            margin-right: 10px;
        }
        .status-attivo {
            background: #c6f6d5;
            color: #22543d;
        }
        .status-scaduto {
            background: #fed7d7;
            color: #742a2a;
        }
        .status-disattivo {
            background: #e2e8f0;
            color: #4a5568;
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
        
        @media (max-width: 768px) {
            .container {
                padding: 30px 15px;
            }
            .section {
                padding: 25px 20px;
            }
            .option-input {
                flex-direction: column;
                align-items: stretch;
            }
            .remove-option {
                align-self: flex-end;
                margin-top: 10px;
            }
        }
        /* Footer */
        .footer {
            background: rgba(26, 32, 44, 0.9);
            color: white;
            text-align: center;
            padding: 40px 20px;
            backdrop-filter: blur(10px);
        }
        .tipo-selector {
            margin-top: 10px;
        }
        
        .tipo-selector summary {
            cursor: pointer;
            font-size: 0.9em;
        }
        
        .inline-form {
            margin-top: 10px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        
        .inline-form select {
            width: auto;
            margin: 0;
        }
        
        .help-text {
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
        
        .help-multipla {
            color: #2196F3;
        }
        
        .help-singola {
            color: #4CAF50;
        }
        
        .sondaggio-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .btn-tertiary {
            background-color: #6c757d;
            color: white;
            font-size: 0.85em;
            padding: 5px 10px;
        }
        
        .btn-tertiary:hover {
            background-color: #5a6268;
        }
    </style>