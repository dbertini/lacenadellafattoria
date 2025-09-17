<style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
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
        .nav-links a.active {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.3);
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255,255,255,0.95);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-top: 100px;
            margin-bottom: 20px;
        }
        h1 {
            text-align: center;
            color: #4a5568;
            margin-bottom: 30px;
            font-size: 2.5em;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        /* Sezione aggiunta indirizzi */
        .add-location-section {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .add-location-section h2 {
            margin: 0 0 20px 0;
            font-size: 1.5em;
        }
        .input-group {
            display: grid;
            grid-template-columns: 2fr 2fr 1fr auto;
            gap: 15px;
            margin-bottom: 15px;
            align-items: end;
        }
        .input-field {
            display: flex;
            flex-direction: column;
        }
        .input-field label {
            font-size: 0.9em;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        .input-field input {
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            background: rgba(255,255,255,0.9);
            transition: background 0.3s ease;
        }
        .input-field input:focus {
            outline: none;
            background: white;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }
        
        .locations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .location-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #4299e1;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        .location-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .location-title {
            font-weight: bold;
            color: #2d3748;
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        .location-address {
            color: #718096;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .location-coords {
            color: #2b6cb0;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }
        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e53e3e;
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 0.8em;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }
        .delete-btn:hover {
            background: #c53030;
        }
        
        .triangulation-result {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .triangulation-result h2 {
            margin: 0 0 15px 0;
            font-size: 1.8em;
        }
        .center-coords {
            font-family: 'Courier New', monospace;
            font-size: 1.2em;
            background: rgba(255,255,255,0.2);
            padding: 10px;
            border-radius: 8px;
            display: inline-block;
            margin: 10px;
        }
        
        /* Sezione ristoranti */
        .restaurants-section {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .restaurants-section h2 {
            margin: 0 0 20px 0;
            font-size: 1.8em;
            text-align: center;
        }
        .restaurants-controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .radius-selector {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .radius-selector:focus {
            outline: none;
            background: rgba(255,255,255,0.3);
        }
        .radius-selector option {
            color: #333;
        }
        
        .map-container {
            width: 100%;
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin-top: 20px;
        }
        #map {
            width: 100%;
            height: 100%;
        }
        .controls {
            margin: 20px 0;
            text-align: center;
        }
        .btn {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            margin: 0 10px 10px 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        .btn.success {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }
        .btn.warning {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
        }
        .btn.danger {
            background: linear-gradient(135deg, #e53e3e, #c53030);
        }
        
        .loading {
            display: inline-block;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .status-message {
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }
        .status-success {
            background: rgba(72, 187, 120, 0.2);
            color: #2f855a;
            border: 2px solid #68d391;
        }
        .status-error {
            background: rgba(229, 62, 62, 0.2);
            color: #c53030;
            border: 2px solid #fc8181;
        }
        .status-info {
            background: rgba(66, 153, 225, 0.2);
            color: #2b6cb0;
            border: 2px solid #90cdf4;
        }
        
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 20px;
                padding: 0 20px;
            }
            .nav-links {
                gap: 15px;
            }
            .container {
                margin-top: 120px;
                padding: 20px;
            }
            .input-group {
                grid-template-columns: 1fr;
            }
            .restaurants-controls {
                flex-direction: column;
                align-items: center;
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

        /* Alberghi */
        .alberghi-section {
            background: linear-gradient(135deg, #79ed36ff, #20dd95ff);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin: 30px 0;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .alberghi-section h2 {
            margin: 0 0 20px 0;
            font-size: 1.8em;
            text-align: center;
        }

        .alberghi-controls {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
    </style>