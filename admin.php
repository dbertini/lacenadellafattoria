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
                        
                        <a href="risultati_admin.php?id=<?php echo $sondaggio['id']; ?>" class="btn">📊 Vedi Risultati</a>
                        <a href="?toggle=<?php echo $sondaggio['id']; ?>" class="btn btn-secondary">
                            <?php echo $sondaggio['attivo'] ? '🔒 Disattiva' : '🔓 Attiva'; ?>
                        </a>
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

        // Auto-resize textarea
        document.getElementById('descrizione').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    </script>
</body>
</html>