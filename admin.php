<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - GeoTriangulator Sondaggi</title>
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
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="logo">🗳️ Admin Sondaggi</div>
            <ul class="nav-links">
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="sondaggi.php">📊 Sondaggi</a></li>
                <li><a href="risultati.php">📈 Risultati</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="admin-header">
            <h1>🛠️ Pannello Amministrativo</h1>
            <p>Gestisci i sondaggi e visualizza i risultati</p>
        </div>

        <?php
        require_once 'config.php';
        
        $pdo = getDBConnection();
        $message = '';
        $messageType = '';

        // Gestione creazione nuovo sondaggio
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_sondaggio'])) {
            try {
                $titolo = sanitize($_POST['titolo']);
                $descrizione = sanitize($_POST['descrizione']);
                $data_scadenza = !empty($_POST['data_scadenza']) ? $_POST['data_scadenza'] : null;
                $opzioni = array_filter($_POST['opzioni'], function($opt) { return !empty(trim($opt)); });
                
                if (empty($titolo) || count($opzioni) < 2) {
                    throw new Exception("Il titolo è obbligatorio e servono almeno 2 opzioni.");
                }
                
                $pdo->beginTransaction();
                
                // Inserisci sondaggio
                $stmt = $pdo->prepare("INSERT INTO sondaggi (titolo, descrizione, data_scadenza) VALUES (?, ?, ?)");
                $stmt->execute([$titolo, $descrizione, $data_scadenza]);
                $sondaggio_id = $pdo->lastInsertId();
                
                // Inserisci opzioni
                $stmt = $pdo->prepare("INSERT INTO opzioni_sondaggio (sondaggio_id, testo_opzione, ordine_visualizzazione) VALUES (?, ?, ?)");
                foreach ($opzioni as $i => $opzione) {
                    if (!empty(trim($opzione))) {
                        $stmt->execute([$sondaggio_id, sanitize($opzione), $i + 1]);
                    }
                }
                
                $pdo->commit();
                $message = "Sondaggio creato con successo!";
                $messageType = 'success';
                
            } catch (Exception $e) {
                $pdo->rollBack();
                $message = "Errore: " . $e->getMessage();
                $messageType = 'error';
            }
        }

        // Gestione toggle attivazione sondaggio
        if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
            try {
                $stmt = $pdo->prepare("UPDATE sondaggi SET attivo = NOT attivo WHERE id = ?");
                $stmt->execute([$_GET['toggle']]);
                $message = "Stato sondaggio aggiornato!";
                $messageType = 'success';
            } catch (Exception $e) {
                $message = "Errore nell'aggiornamento: " . $e->getMessage();
                $messageType = 'error';
            }
        }

        if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <!-- Form creazione sondaggio -->
        <div class="section">
            <h2>➕ Crea Nuovo Sondaggio</h2>
            <form method="post">
                <div class="form-group">
                    <label for="titolo">Titolo Sondaggio *</label>
                    <input type="text" id="titolo" name="titolo" required placeholder="Inserisci il titolo del sondaggio">
                </div>
                
                <div class="form-group">
                    <label for="descrizione">Descrizione</label>
                    <textarea id="descrizione" name="descrizione" placeholder="Descrizione opzionale del sondaggio"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="data_scadenza">Data Scadenza (opzionale)</label>
                    <input type="datetime-local" id="data_scadenza" name="data_scadenza">
                </div>
                
                <div class="form-group">
                    <label>Opzioni di Risposta *</label>
                    <div class="options-container" id="optionsContainer">
                        <div class="option-input">
                            <input type="text" name="opzioni[]" placeholder="Opzione 1" required>
                        </div>
                        <div class="option-input">
                            <input type="text" name="opzioni[]" placeholder="Opzione 2" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addOption()">➕ Aggiungi Opzione</button>
                </div>
                
                <button type="submit" name="create_sondaggio" class="btn btn-success">🚀 Crea Sondaggio</button>
            </form>
        </div>

        <!-- Lista sondaggi esistenti -->
        <div class="section">
            <h2>📋 Sondaggi Esistenti</h2>
            <div class="sondaggi-list">
                <?php
                $stmt = $pdo->query("
                    SELECT s.*, 
                           COUNT(v.id) as totale_voti,
                           (SELECT COUNT(*) FROM opzioni_sondaggio WHERE sondaggio_id = s.id) as totale_opzioni
                    FROM sondaggi s 
                    LEFT JOIN voti v ON s.id = v.sondaggio_id 
                    GROUP BY s.id 
                    ORDER BY s.data_creazione DESC
                ");
                
                while ($sondaggio = $stmt->fetch()): 
                    $isAttivo = isSondaggioAttivo($sondaggio);
                    $statusClass = $isAttivo ? 'status-attivo' : ($sondaggio['attivo'] ? 'status-scaduto' : 'status-disattivo');
                    $statusText = $isAttivo ? 'Attivo' : ($sondaggio['attivo'] ? 'Scaduto' : 'Disattivato');
                ?>
                    <div class="sondaggio-card">
                        <h3 class="sondaggio-title"><?php echo htmlspecialchars($sondaggio['titolo']); ?></h3>
                        <div class="sondaggio-meta">
                            Creato il <?php echo formatDate($sondaggio['data_creazione']); ?>
                            <?php if ($sondaggio['data_scadenza']): ?>
                                • Scade il <?php echo formatDate($sondaggio['data_scadenza']); ?>
                            <?php endif; ?>
                        </div>
                        
                        <span class="sondaggio-status <?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </span>
                        
                        <p><strong><?php echo $sondaggio['totale_voti']; ?></strong> voti ricevuti su <strong><?php echo $sondaggio['totale_opzioni']; ?></strong> opzioni</p>
                        
                        <a href="risultati.php?id=<?php echo $sondaggio['id']; ?>" class="btn">📊 Vedi Risultati</a>
                        <a href="?toggle=<?php echo $sondaggio['id']; ?>" class="btn btn-secondary">
                            <?php echo $sondaggio['attivo'] ? '🔒 Disattiva' : '🔓 Attiva'; ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script>
        let optionCount = 2;

        function addOption() {
            optionCount++;
            const container = document.getElementById('optionsContainer');
            const div = document.createElement('div');
            div.className = 'option-input';
            div.innerHTML = `
                <input type="text" name="opzioni[]" placeholder="Opzione ${optionCount}">
                <button type="button" class="remove-option" onclick="removeOption(this)">✕</button>
            `;
            container.appendChild(div);
        }

        function removeOption(button) {
            const optionInputs = document.querySelectorAll('.option-input');
            if (optionInputs.length > 2) {
                button.parentElement.remove();
            } else {
                alert('Servono almeno 2 opzioni per il sondaggio!');
            }
        }

        // Auto-resize textarea
        document.getElementById('descrizione').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    </script>
</body>
</html>