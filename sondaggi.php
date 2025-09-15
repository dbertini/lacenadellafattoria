<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondaggi - GeoTriangulator</title>
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
        .option-item input[type="radio"] {
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
            border-radius: 50%;
            background: white;
            transition: all 0.3s ease;
        }
        .option-item.selected .option-text::before {
            border-color: #4299e1;
            background: #4299e1;
            box-shadow: inset 0 0 0 4px white;
        }
        
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
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="logo">🗳️ GeoTriangulator Sondaggi</div>
            <ul class="nav-links">
                <li><a href="index.php">🏠 Home</a></li>
                <li><a href="risultati.php">📈 Risultati</a></li>
                <li><a href="admin.php">🛠️ Admin</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="header">
            <h1>📊 Sondaggi Attivi</h1>
            <p>Partecipa ai sondaggi della community e fai sentire la tua voce!</p>
        </div>

        <?php
        require_once 'config.php';
        
        $pdo = getDBConnection();
        $message = '';
        $messageType = '';

        // Gestione invio voto
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_vote'])) {
            try {
                $sondaggio_id = (int)$_POST['sondaggio_id'];
                $opzione_id = (int)$_POST['opzione_id'];
                $nome = sanitize($_POST['nome']);
                $email = !empty($_POST['email']) ? sanitize($_POST['email']) : null;
                
                if (empty($nome) || empty($opzione_id)) {
                    throw new Exception("Nome e selezione dell'opzione sono obbligatori.");
                }
                
                // Verifica se l'utente ha già votato
                if (hasUserVoted($pdo, $sondaggio_id, $nome, $email)) {
                    throw new Exception("Hai già partecipato a questo sondaggio.");
                }
                
                // Verifica che il sondaggio sia ancora attivo
                $stmt = $pdo->prepare("SELECT * FROM sondaggi WHERE id = ?");
                $stmt->execute([$sondaggio_id]);
                $sondaggio = $stmt->fetch();
                
                if (!$sondaggio || !isSondaggioAttivo($sondaggio)) {
                    throw new Exception("Il sondaggio non è più attivo.");
                }
                
                // Inserisci il voto
                $stmt = $pdo->prepare("INSERT INTO voti (sondaggio_id, opzione_id, nome_votante, email_votante, ip_address) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$sondaggio_id, $opzione_id, $nome, $email, getClientIP()]);
                
                $message = "🎉 Grazie per aver partecipato! Il tuo voto è stato registrato.";
                $messageType = 'success';
                
            } catch (Exception $e) {
                $message = "❌ " . $e->getMessage();
                $messageType = 'error';
            }
        }

        if ($message): ?>
            <div class="alert alert-<?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php
        // Ottieni tutti i sondaggi attivi
        $stmt = $pdo->query("
            SELECT s.*, 
                   COUNT(v.id) as totale_voti,
                   (SELECT COUNT(*) FROM opzioni_sondaggio WHERE sondaggio_id = s.id) as totale_opzioni
            FROM sondaggi s 
            LEFT JOIN voti v ON s.id = v.sondaggio_id 
            WHERE s.attivo = 1 
            GROUP BY s.id 
            ORDER BY s.data_creazione DESC
        ");
        
        $sondaggi = $stmt->fetchAll();
        
        if (empty($sondaggi)): ?>
            <div class="sondaggio-card no-sondaggi">
                <h3>🤔 Nessun sondaggio attivo</h3>
                <p>Al momento non ci sono sondaggi disponibili. Torna più tardi!</p>
            </div>
        <?php else: ?>
            <?php foreach ($sondaggi as $sondaggio): 
                $isAttivo = isSondaggioAttivo($sondaggio);
                if (!$isAttivo) continue;
            ?>
                <div class="sondaggio-card">
                    <h2 class="sondaggio-title"><?php echo htmlspecialchars($sondaggio['titolo']); ?></h2>
                    
                    <?php if ($sondaggio['descrizione']): ?>
                        <p class="sondaggio-description"><?php echo nl2br(htmlspecialchars($sondaggio['descrizione'])); ?></p>
                    <?php endif; ?>
                    
                    <div class="sondaggio-meta">
                        <div class="meta-item">
                            <span>📅</span>
                            <span>Creato il <?php echo formatDate($sondaggio['data_creazione']); ?></span>
                        </div>
                        <?php if ($sondaggio['data_scadenza']): ?>
                            <div class="meta-item">
                                <span>⏰</span>
                                <span>Scade il <?php echo formatDate($sondaggio['data_scadenza']); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="meta-item">
                            <span>👥</span>
                            <span><?php echo $sondaggio['totale_voti']; ?> voti ricevuti</span>
                        </div>
                        <span class="status-badge status-attivo">🟢 Attivo</span>
                    </div>

                    <?php
                    // Verifica se l'utente ha già votato (controllo base)
                    $hasVoted = false;
                    if (isset($_SESSION['voted_surveys'])) {
                        $hasVoted = in_array($sondaggio['id'], $_SESSION['voted_surveys']);
                    }
                    ?>

                    <?php if ($hasVoted): ?>
                        <div class="alert alert-warning">
                            ℹ️ Hai già partecipato a questo sondaggio. <a href="risultati.php?id=<?php echo $sondaggio['id']; ?>">Vedi i risultati</a>
                        </div>
                    <?php else: ?>
                        <form method="post" class="vote-form" id="form-<?php echo $sondaggio['id']; ?>">
                            <input type="hidden" name="sondaggio_id" value="<?php echo $sondaggio['id']; ?>">
                            
                            <div class="form-section">
                                <h3>👤 I tuoi dati</h3>
                                <div class="user-info">
                                    <div class="form-group">
                                        <label for="nome-<?php echo $sondaggio['id']; ?>">Nome *</label>
                                        <input type="text" id="nome-<?php echo $sondaggio['id']; ?>" name="nome" required placeholder="Il tuo nome">
                                    </div>
                                    <div class="form-group">
                                        <label for="email-<?php echo $sondaggio['id']; ?>">Email (opzionale)</label>
                                        <input type="email" id="email-<?php echo $sondaggio['id']; ?>" name="email" placeholder="La tua email">
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h3>🗳️ Scegli la tua opzione</h3>
                                <div class="options-grid">
                                    <?php
                                    $stmt_options = $pdo->prepare("SELECT * FROM opzioni_sondaggio WHERE sondaggio_id = ? ORDER BY ordine_visualizzazione");
                                    $stmt_options->execute([$sondaggio['id']]);
                                    $opzioni = $stmt_options->fetchAll();
                                    
                                    foreach ($opzioni as $opzione): ?>
                                        <label class="option-item" onclick="selectOption(this)">
                                            <input type="radio" name="opzione_id" value="<?php echo $opzione['id']; ?>" required>
                                            <div class="option-text"><?php echo htmlspecialchars($opzione['testo_opzione']); ?></div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <button type="submit" name="submit_vote" class="btn">🚀 Invia il mio voto</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        function selectOption(label) {
            // Rimuovi la selezione da tutte le opzioni dello stesso form
            const form = label.closest('form');
            const allOptions = form.querySelectorAll('.option-item');
            allOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Aggiungi la selezione all'opzione cliccata
            label.classList.add('selected');
            
            // Seleziona il radio button
            const radio = label.querySelector('input[type="radio"]');
            radio.checked = true;
        }

        // Gestione invio form con conferma
        document.querySelectorAll('form[id^="form-"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const selectedOption = this.querySelector('input[name="opzione_id"]:checked');
                const nome = this.querySelector('input[name="nome"]').value;
                
                if (!selectedOption || !nome.trim()) {
                    e.preventDefault();
                    alert('⚠️ Completa tutti i campi obbligatori prima di procedere!');
                    return;
                }
                
                const optionText = selectedOption.closest('.option-item').querySelector('.option-text').textContent;
                const confirmMessage = `🗳️ Confermi di voler votare per: "${optionText}"?\n\n⚠️ Non potrai modificare il tuo voto successivamente.`;
                
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            });
        });

        // Salva i sondaggi votati in sessione (lato client)
        if (localStorage.getItem('votedSurveys')) {
            const votedSurveys = JSON.parse(localStorage.getItem('votedSurveys'));
            // Nascondi i form per i sondaggi già votati
            votedSurveys.forEach(surveyId => {
                const form = document.querySelector(`#form-${surveyId}`);
                if (form) {
                    form.style.display = 'none';
                    const warning = document.createElement('div');
                    warning.className = 'alert alert-warning';
                    warning.innerHTML = 'ℹ️ Hai già partecipato a questo sondaggio. <a href="risultati.php?id=' + surveyId + '">Vedi i risultati</a>';
                    form.parentNode.insertBefore(warning, form);
                }
            });
        }
    </script>
</body>
</html>