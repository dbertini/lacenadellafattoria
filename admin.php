<?php
// Controllo autenticazione - AGGIUNTO ALL'INIZIO
session_start();
require_once 'config.php';

// Funzione per verificare se l'utente è loggato
function checkAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: login.php');
        exit();
    }
    
    // Aggiorna ultimo accesso
    if (isset($_SESSION['admin_user_id'])) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE admin_users SET ultimo_accesso = NOW() WHERE id = ?");
        $stmt->execute([$_SESSION['admin_user_id']]);
    }
}

// Verifica autenticazione
checkAuth();

// Gestione logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - GeoTriangulator Sondaggi</title>
    <?php require 'styles/style_admin.php'; ?>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="container">
        <div class="admin-header">
            <h1>🛠️ Pannello Amministrativo</h1>
            <p>Gestisci i sondaggi e visualizza i risultati</p>
            <!-- AGGIUNTO: Info utente e logout -->
            <div class="user-info">
                Benvenuto, <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></strong>
                <a href="?logout=1" class="btn btn-secondary btn-small">🚪 Logout</a>
            </div>
        </div>

        <?php
        $pdo = getDBConnection();
        $message = '';
        $messageType = '';

        // Gestione creazione nuovo sondaggio
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_sondaggio'])) {
            try {
                $titolo = sanitize($_POST['titolo']);
                $descrizione = sanitize($_POST['descrizione']);
                $data_scadenza = !empty($_POST['data_scadenza']) ? $_POST['data_scadenza'] : null;
                $tipo_selezione = sanitize($_POST['tipo_selezione'] ?? 'singola'); // NUOVO CAMPO
                $opzioni = array_filter($_POST['opzioni'], function($opt) { return !empty(trim($opt)); });
                
                if (empty($titolo) || count($opzioni) < 2) {
                    throw new Exception("Il titolo è obbligatorio e servono almeno 2 opzioni.");
                }
                
                // Validazione tipo selezione
                if (!in_array($tipo_selezione, ['singola', 'multipla'])) {
                    throw new Exception("Tipo di selezione non valido.");
                }
                
                $pdo->beginTransaction();
                
                // Inserisci sondaggio con tipo_selezione
                $stmt = $pdo->prepare("INSERT INTO sondaggi (titolo, descrizione, data_scadenza, tipo_selezione) VALUES (?, ?, ?, ?)");
                $stmt->execute([$titolo, $descrizione, $data_scadenza, $tipo_selezione]);
                $sondaggio_id = $pdo->lastInsertId();
                
                // Inserisci opzioni
                $stmt = $pdo->prepare("INSERT INTO opzioni_sondaggio (sondaggio_id, testo_opzione, ordine_visualizzazione) VALUES (?, ?, ?)");
                foreach ($opzioni as $i => $opzione) {
                    if (!empty(trim($opzione))) {
                        $stmt->execute([$sondaggio_id, sanitize($opzione), $i + 1]);
                    }
                }
                
                $pdo->commit();
                
                $tipo_text = $tipo_selezione === 'multipla' ? 'a scelta multipla' : 'a scelta singola';
                $message = "Sondaggio $tipo_text creato con successo!";
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

        // Gestione modifica tipo selezione
        if (isset($_POST['update_tipo']) && isset($_POST['sondaggio_id']) && isset($_POST['nuovo_tipo'])) {
            try {
                $sondaggio_id = (int)$_POST['sondaggio_id'];
                $nuovo_tipo = sanitize($_POST['nuovo_tipo']);
                
                if (!in_array($nuovo_tipo, ['singola', 'multipla'])) {
                    throw new Exception("Tipo di selezione non valido.");
                }
                
                $stmt = $pdo->prepare("UPDATE sondaggi SET tipo_selezione = ? WHERE id = ?");
                $stmt->execute([$nuovo_tipo, $sondaggio_id]);
                
                $tipo_text = $nuovo_tipo === 'multipla' ? 'scelta multipla' : 'scelta singola';
                $message = "Tipo di selezione aggiornato a: $tipo_text";
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
                
                <!-- NUOVO CAMPO: Tipo di Selezione -->
                <div class="form-group">
                    <label for="tipo_selezione">Tipo di Selezione *</label>
                    <select id="tipo_selezione" name="tipo_selezione" required onchange="updateSelectionInfo()">
                        <option value="singola">🔘 Scelta Singola</option>
                        <option value="multipla">☑️ Scelta Multipla</option>
                    </select>
                    <div class="help-text" id="selection-help">
                        Gli utenti potranno selezionare una sola opzione.
                    </div>
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
                           COUNT(DISTINCT v.nome_votante, v.email_votante) as totale_partecipanti,
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
                    $tipoIcon = $sondaggio['tipo_selezione'] === 'multipla' ? '☑️' : '🔘';
                    $tipoText = $sondaggio['tipo_selezione'] === 'multipla' ? 'Multipla' : 'Singola';
                ?>
                    <div class="sondaggio-card">
                        <h3 class="sondaggio-title"><?php echo htmlspecialchars($sondaggio['titolo']); ?></h3>
                        <div class="sondaggio-meta">
                            Creato il <?php echo formatDate($sondaggio['data_creazione']); ?>
                            <?php if ($sondaggio['data_scadenza']): ?>
                                • Scade il <?php echo formatDate($sondaggio['data_scadenza']); ?>
                            <?php endif; ?>
                            <br>
                            <strong><?php echo $tipoIcon; ?> Selezione <?php echo $tipoText; ?></strong>
                        </div>
                        
                        <span class="sondaggio-status <?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </span>
                        
                        <p>
                            <strong><?php echo $sondaggio['totale_partecipanti']; ?></strong> partecipanti 
                            • <strong><?php echo $sondaggio['totale_voti']; ?></strong> voti totali
                            • <strong><?php echo $sondaggio['totale_opzioni']; ?></strong> opzioni
                        </p>
                        
                        <div class="sondaggio-actions">
                            <a href="risultati_admin.php?id=<?php echo $sondaggio['id']; ?>" class="btn">📊 Vedi Risultati</a>
                            <a href="?toggle=<?php echo $sondaggio['id']; ?>" class="btn btn-secondary">
                                <?php echo $sondaggio['attivo'] ? '🔒 Disattiva' : '🔓 Attiva'; ?>
                            </a>
                            
                            <!-- Form per cambiare tipo selezione -->
                            <?php if ($sondaggio['totale_voti'] == 0): ?>
                                <details class="tipo-selector">
                                    <summary class="btn btn-tertiary">⚙️ Cambia Tipo</summary>
                                    <form method="post" class="inline-form">
                                        <input type="hidden" name="sondaggio_id" value="<?php echo $sondaggio['id']; ?>">
                                        <select name="nuovo_tipo" onchange="this.form.submit()">
                                            <option value="singola" <?php echo $sondaggio['tipo_selezione'] === 'singola' ? 'selected' : ''; ?>>🔘 Singola</option>
                                            <option value="multipla" <?php echo $sondaggio['tipo_selezione'] === 'multipla' ? 'selected' : ''; ?>>☑️ Multipla</option>
                                        </select>
                                        <input type="hidden" name="update_tipo" value="1">
                                    </form>
                                </details>
                            <?php else: ?>
                                <span class="help-text">⚠️ Non modificabile (ha già ricevuto voti)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php require 'footer.php'; ?>
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

        // Aggiorna testo di aiuto per il tipo di selezione
        function updateSelectionInfo() {
            const select = document.getElementById('tipo_selezione');
            const helpText = document.getElementById('selection-help');
            
            if (select.value === 'multipla') {
                helpText.textContent = 'Gli utenti potranno selezionare più opzioni contemporaneamente.';
                helpText.className = 'help-text help-multipla';
            } else {
                helpText.textContent = 'Gli utenti potranno selezionare una sola opzione.';
                helpText.className = 'help-text help-singola';
            }
        }

        // Auto-resize textarea
        document.getElementById('descrizione').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });

        // Inizializza il testo di aiuto al caricamento della pagina
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectionInfo();
        });
    </script>


</body>
</html>