<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sondaggi - GeoTriangulator</title>
    <?php require 'styles/style_sondaggi.php'; ?>
</head>
<body>
    <?php require 'menu.php'; ?>

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
                $nome = sanitize($_POST['nome']);
                $email = !empty($_POST['email']) ? sanitize($_POST['email']) : null;
                
                if (empty($nome)) {
                    throw new Exception("Il nome è obbligatorio.");
                }
                
                // Verifica se l'utente ha già votato
                if (hasUserVoted($pdo, $sondaggio_id, $nome, $email)) {
                    throw new Exception("Hai già partecipato a questo sondaggio.");
                }
                
                // Verifica che il sondaggio sia ancora attivo e ottieni il tipo
                $stmt = $pdo->prepare("SELECT * FROM sondaggi WHERE id = ?");
                $stmt->execute([$sondaggio_id]);
                $sondaggio = $stmt->fetch();
                
                if (!$sondaggio || !isSondaggioAttivo($sondaggio)) {
                    throw new Exception("Il sondaggio non è più attivo.");
                }
                
                // Gestione opzioni selezionate (singola o multipla)
                $opzioni_selezionate = [];
                
                if ($sondaggio['tipo_selezione'] === 'multipla') {
                    // Scelta multipla - checkbox
                    if (isset($_POST['opzioni_id']) && is_array($_POST['opzioni_id'])) {
                        $opzioni_selezionate = array_map('intval', $_POST['opzioni_id']);
                    }
                } else {
                    // Scelta singola - radio button
                    if (isset($_POST['opzione_id']) && !empty($_POST['opzione_id'])) {
                        $opzioni_selezionate = [(int)$_POST['opzione_id']];
                    }
                }
                
                if (empty($opzioni_selezionate)) {
                    throw new Exception("Devi selezionare almeno un'opzione.");
                }
                
                // Verifica che tutte le opzioni selezionate appartengano al sondaggio
                $placeholders = str_repeat('?,', count($opzioni_selezionate) - 1) . '?';
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM opzioni_sondaggio WHERE sondaggio_id = ? AND id IN ($placeholders)");
                $params = array_merge([$sondaggio_id], $opzioni_selezionate);
                $stmt->execute($params);
                
                if ($stmt->fetchColumn() != count($opzioni_selezionate)) {
                    throw new Exception("Una o più opzioni selezionate non sono valide.");
                }
                
                // Inizia transazione per inserire tutti i voti
                $pdo->beginTransaction();
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO voti (sondaggio_id, opzione_id, nome_votante, email_votante, ip_address) VALUES (?, ?, ?, ?, ?)");
                    
                    foreach ($opzioni_selezionate as $opzione_id) {
                        $stmt->execute([$sondaggio_id, $opzione_id, $nome, $email, getClientIP()]);
                    }
                    
                    $pdo->commit();
                    
                    $num_opzioni = count($opzioni_selezionate);
                    $message = $num_opzioni > 1 
                        ? "🎉 Grazie per aver partecipato! I tuoi $num_opzioni voti sono stati registrati."
                        : "🎉 Grazie per aver partecipato! Il tuo voto è stato registrato.";
                    $messageType = 'success';
                    
                    // Salva in sessione che l'utente ha votato
                    if (!isset($_SESSION['voted_surveys'])) {
                        $_SESSION['voted_surveys'] = [];
                    }
                    $_SESSION['voted_surveys'][] = $sondaggio_id;
                    
                } catch (Exception $e) {
                    $pdo->rollBack();
                    throw $e;
                }
                
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
                   COUNT(DISTINCT v.nome_votante, v.email_votante) as totale_partecipanti,
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
                            <span><?php echo $sondaggio['totale_partecipanti']; ?> partecipanti (<?php echo $sondaggio['totale_voti']; ?> voti totali)</span>
                        </div>
                        <div class="meta-item">
                            <?php if ($sondaggio['tipo_selezione'] === 'multipla'): ?>
                                <span>☑️</span>
                                <span>Scelta multipla consentita</span>
                            <?php else: ?>
                                <span>🔘</span>
                                <span>Scelta singola</span>
                            <?php endif; ?>
                        </div>
                        <span class="status-badge status-attivo">🟢 Attivo</span>
                    </div>

                    <?php
                    // Verifica se l'utente ha già votato
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
                                <h3>🗳️ Scegli la tua opzione<?php echo $sondaggio['tipo_selezione'] === 'multipla' ? ' (puoi selezionarne più di una)' : ''; ?></h3>
                                <div class="options-grid" data-tipo="<?php echo $sondaggio['tipo_selezione']; ?>">
                                    <?php
                                    $stmt_options = $pdo->prepare("SELECT * FROM opzioni_sondaggio WHERE sondaggio_id = ? ORDER BY ordine_visualizzazione");
                                    $stmt_options->execute([$sondaggio['id']]);
                                    $opzioni = $stmt_options->fetchAll();
                                    
                                    foreach ($opzioni as $opzione): ?>
                                        <label class="option-item" onclick="selectOption(this, '<?php echo $sondaggio['tipo_selezione']; ?>')">
                                            <?php if ($sondaggio['tipo_selezione'] === 'multipla'): ?>
                                                <input type="checkbox" name="opzioni_id[]" value="<?php echo $opzione['id']; ?>">
                                            <?php else: ?>
                                                <input type="radio" name="opzione_id" value="<?php echo $opzione['id']; ?>" required>
                                            <?php endif; ?>
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
<?php require 'footer.php'; ?>
    <script>
        function selectOption(label, tipo) {
            const input = label.querySelector('input');
            
            if (tipo === 'singola') {
                // Rimuovi la selezione da tutte le opzioni dello stesso form
                const form = label.closest('form');
                const allOptions = form.querySelectorAll('.option-item');
                allOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Aggiungi la selezione all'opzione cliccata
                label.classList.add('selected');
                input.checked = true;
            } else {
                // Scelta multipla - toggle selection
                if (input.checked) {
                    label.classList.remove('selected');
                    input.checked = false;
                } else {
                    label.classList.add('selected');
                    input.checked = true;
                }
            }
        }

        // Gestione invio form con conferma
        document.querySelectorAll('form[id^="form-"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const nome = this.querySelector('input[name="nome"]').value;
                const optionsGrid = this.querySelector('.options-grid');
                const tipo = optionsGrid.dataset.tipo;
                
                let selectedOptions = [];
                let selectedTexts = [];
                
                if (tipo === 'multipla') {
                    const checkboxes = this.querySelectorAll('input[name="opzioni_id[]"]:checked');
                    checkboxes.forEach(cb => {
                        selectedOptions.push(cb.value);
                        selectedTexts.push(cb.closest('.option-item').querySelector('.option-text').textContent);
                    });
                } else {
                    const radio = this.querySelector('input[name="opzione_id"]:checked');
                    if (radio) {
                        selectedOptions.push(radio.value);
                        selectedTexts.push(radio.closest('.option-item').querySelector('.option-text').textContent);
                    }
                }
                
                if (!nome.trim() || selectedOptions.length === 0) {
                    e.preventDefault();
                    alert('⚠️ Completa tutti i campi obbligatori prima di procedere!');
                    return;
                }
                
                let confirmMessage;
                if (selectedOptions.length > 1) {
                    confirmMessage = `🗳️ Confermi di voler votare per le seguenti ${selectedOptions.length} opzioni?\n\n"${selectedTexts.join('"\n"')}"\n\n⚠️ Non potrai modificare i tuoi voti successivamente.`;
                } else {
                    confirmMessage = `🗳️ Confermi di voler votare per: "${selectedTexts[0]}"?\n\n⚠️ Non potrai modificare il tuo voto successivamente.`;
                }
                
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

        // Inizializza lo stato delle opzioni già selezionate
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.option-item').forEach(item => {
                const input = item.querySelector('input');
                if (input && input.checked) {
                    item.classList.add('selected');
                }
            });
        });
    </script>
</body>
</html>