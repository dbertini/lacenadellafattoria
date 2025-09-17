<?php
// Controllo autenticazione - AGGIUNTO ALL'INIZIO
session_start();
require_once 'config.php';

// Funzione per verificare se l'utente è loggato
function checkAuth() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: risultati_admin.php');
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

$pdo = getDBConnection();
$sondaggio_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Verifica che il sondaggio esista
$stmt = $pdo->prepare("SELECT * FROM sondaggi WHERE id = ?");
$stmt->execute([$sondaggio_id]);
$sondaggio = $stmt->fetch();



// Recupera i risultati del sondaggio
$stmt = $pdo->prepare("
    SELECT 
        os.id,
        os.testo_opzione,
        os.ordine_visualizzazione,
        COUNT(v.id) as numero_voti
    FROM opzioni_sondaggio os
    LEFT JOIN voti v ON os.id = v.opzione_id
    WHERE os.sondaggio_id = ?
    GROUP BY os.id, os.testo_opzione, os.ordine_visualizzazione
    ORDER BY os.ordine_visualizzazione ASC
");
$stmt->execute([$sondaggio_id]);
$risultati = $stmt->fetchAll();

// Calcola totale voti e trova l'opzione vincente
$totale_voti = array_sum(array_column($risultati, 'numero_voti'));
$voti_max = max(array_column($risultati, 'numero_voti'));

// Recupera la lista dei votanti (senza mostrare cosa hanno votato)
$stmt = $pdo->prepare("
    SELECT DISTINCT
        v.nome_votante,
        v.data_voto
    FROM voti v
    WHERE v.sondaggio_id = ?
    ORDER BY v.data_voto DESC
");
$stmt->execute([$sondaggio_id]);
$votanti = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati - <?php echo htmlspecialchars($sondaggio['titolo']); ?></title>
    <?php require 'styles/style_admin.php'; ?>
    <style>
        .risultato-opzione {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            overflow: hidden;
        }
        
        .risultato-opzione.vincente {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-color: #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        }
        
        .risultato-opzione.vincente::before {
            content: "🏆";
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 24px;
        }
        
        .opzione-testo {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        
        .risultato-opzione.vincente .opzione-testo {
            color: #155724;
        }
        
        .voti-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .numero-voti {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        
        .risultato-opzione.vincente .numero-voti {
            color: #155724;
        }
        
        .percentuale {
            font-size: 18px;
            color: #6c757d;
        }
        
        .risultato-opzione.vincente .percentuale {
            color: #155724;
            font-weight: bold;
        }
        
        .barra-progresso {
            width: 100%;
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .barra-riempimento {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #0056b3);
            border-radius: 10px;
            transition: width 0.5s ease-in-out;
        }
        
        .risultato-opzione.vincente .barra-riempimento {
            background: linear-gradient(90deg, #28a745, #1e7e34);
        }
        
        .totale-voti {
            background: #fff;
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .totale-numero {
            font-size: 48px;
            font-weight: bold;
            color: #007bff;
            line-height: 1;
        }
        
        .votanti-list {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .votante-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .votante-item:last-child {
            border-bottom: none;
        }
        
        .votante-nome {
            font-weight: bold;
            color: #333;
        }
        
        .votante-data {
            color: #6c757d;
            font-size: 14px;
        }
        
        .nessun-voto {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 40px;
        }
        
        .back-link {
            margin-bottom: 20px;
        }
        
        .sondaggio-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .sondaggio-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-attivo {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-scaduto {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-disattivo {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="container">
        <div class="back-link">
            <a href="admin.php" class="btn btn-secondary">← Torna al Pannello Admin</a>
        </div>
        
        <div class="admin-header">
            <h1>📊 Risultati Sondaggio</h1>
            <!-- AGGIUNTO: Info utente e logout -->
            <div class="user-info">
                Benvenuto, <strong><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></strong>
                <a href="?logout=1" class="btn btn-secondary btn-small">🚪 Logout</a>
            </div>
        </div>

        <!-- Info sondaggio -->
        <div class="sondaggio-info">
            <h2><?php echo htmlspecialchars($sondaggio['titolo']); ?></h2>
            <?php if ($sondaggio['descrizione']): ?>
                <p><?php echo htmlspecialchars($sondaggio['descrizione']); ?></p>
            <?php endif; ?>
            <div class="sondaggio-meta">
                Creato il <?php echo formatDate($sondaggio['data_creazione']); ?>
                <?php if ($sondaggio['data_scadenza']): ?>
                    • Scade il <?php echo formatDate($sondaggio['data_scadenza']); ?>
                <?php endif; ?>
                
                <?php 
                $isAttivo = isSondaggioAttivo($sondaggio);
                $statusClass = $isAttivo ? 'status-attivo' : ($sondaggio['attivo'] ? 'status-scaduto' : 'status-disattivo');
                $statusText = $isAttivo ? 'Attivo' : ($sondaggio['attivo'] ? 'Scaduto' : 'Disattivato');
                ?>
                <span class="sondaggio-status <?php echo $statusClass; ?>">
                    <?php echo $statusText; ?>
                </span>
            </div>
        </div>

        <!-- Totale voti -->
        <div class="totale-voti">
            <div class="totale-numero"><?php echo $totale_voti; ?></div>
            <h3>Voti Totali Ricevuti</h3>
        </div>

        <!-- Risultati per opzione -->
        <div class="section">
            <h2>🎯 Risultati per Opzione</h2>
            
            <?php if (empty($risultati) || $totale_voti == 0): ?>
                <div class="nessun-voto">
                    <h3>📭 Nessun voto ricevuto ancora</h3>
                    <p>Quando gli utenti inizieranno a votare, i risultati appariranno qui.</p>
                </div>
            <?php else: ?>
                <?php foreach ($risultati as $risultato): 
                    $percentuale = $totale_voti > 0 ? round(($risultato['numero_voti'] / $totale_voti) * 100, 1) : 0;
                    $isVincente = $risultato['numero_voti'] == $voti_max && $voti_max > 0;
                ?>
                    <div class="risultato-opzione <?php echo $isVincente ? 'vincente' : ''; ?>">
                        <div class="opzione-testo">
                            <?php echo htmlspecialchars($risultato['testo_opzione']); ?>
                        </div>
                        
                        <div class="voti-info">
                            <span class="numero-voti"><?php echo $risultato['numero_voti']; ?> voti</span>
                            <span class="percentuale"><?php echo $percentuale; ?>%</span>
                        </div>
                        
                        <div class="barra-progresso">
                            <div class="barra-riempimento" style="width: <?php echo $percentuale; ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Lista votanti -->
        <div class="section">
            <h2>👥 Elenco Votanti (<?php echo count($votanti); ?>)</h2>
            
            <?php if (empty($votanti)): ?>
                <div class="nessun-voto">
                    <h3>👤 Nessun votante ancora</h3>
                    <p>L'elenco dei votanti apparirà qui quando qualcuno voterà.</p>
                </div>
            <?php else: ?>
                <div class="votanti-list">
                    <?php foreach ($votanti as $votante): ?>
                        <div class="votante-item">
                            <span class="votante-nome">
                                <?php echo htmlspecialchars($votante['nome_votante']); ?>
                            </span>
                            <span class="votante-data">
                                <?php echo formatDate($votante['data_voto']); ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require 'footer.php'; ?>

    <script>
        // Animazione delle barre di progresso
        document.addEventListener('DOMContentLoaded', function() {
            const barre = document.querySelectorAll('.barra-riempimento');
            barre.forEach(barra => {
                const larghezza = barra.style.width;
                barra.style.width = '0%';
                setTimeout(() => {
                    barra.style.width = larghezza;
                }, 100);
            });
        });

        // Evidenziazione automatica dell'opzione vincente
        const opzioniVincenti = document.querySelectorAll('.risultato-opzione.vincente');
        if (opzioniVincenti.length > 0) {
            setTimeout(() => {
                opzioniVincenti.forEach(opzione => {
                    opzione.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        opzione.style.transform = 'scale(1)';
                    }, 200);
                });
            }, 800);
        }
    </script>
</body>
</html>