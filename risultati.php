<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati Sondaggi - GeoTriangulator</title>
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
        
        .section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .sondaggio-header {
            border-bottom: 3px solid #4299e1;
            padding-bottom: 25px;
            margin-bottom: 35px;
        }
        .sondaggio-title {
            color: #4a5568;
            font-size: 2.2em;
            margin: 0 0 15px 0;
            font-weight: 600;
        }
        .sondaggio-description {
            color: #718096;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .sondaggio-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            font-size: 0.95em;
            color: #718096;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .results-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .summary-card {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(66, 153, 225, 0.3);
        }
        .summary-number {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }
        .summary-label {
            font-size: 1em;
            opacity: 0.9;
        }
        
        .results-list {
            display: grid;
            gap: 20px;
        }
        .result-item {
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .result-item.winner {
            border-color: #48bb78;
            background: linear-gradient(135deg, #f0fff4, #c6f6d5);
        }
        .result-item.winner::before {
            content: '👑';
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 1.5em;
        }
        
        .option-header {
            display: flex;
            justify-content: between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .option-name {
            color: #4a5568;
            font-size: 1.3em;
            font-weight: 600;
            flex: 1;
        }
        .option-stats {
            text-align: right;
        }
        .vote-count {
            color: #4299e1;
            font-size: 1.8em;
            font-weight: bold;
            display: block;
        }
        .percentage {
            color: #718096;
            font-size: 1.1em;
        }
        
        .progress-bar {
            height: 12px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 15px;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #4299e1, #3182ce);
            border-radius: 10px;
            transition: width 1s ease;
            position: relative;
        }
        .result-item.winner .progress-fill {
            background: linear-gradient(135deg, #48bb78, #38a169);
        }
        
        .voters-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .voters-title {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .voters-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .voter-badge {
            background: #e2e8f0;
            color: #4a5568;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 500;
        }
        .result-item.winner .voter-badge {
            background: #c6f6d5;
            color: #22543d;
        }
        
        .sondaggi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        .sondaggio-card {
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            background: white;
        }
        .sondaggio-card:hover {
            border-color: #4299e1;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            color: #4a5568;
            font-size: 1.4em;
            font-weight: 600;
            margin: 0 0 10px 0;
        }
        .card-description {
            color: #718096;
            font-size: 0.95em;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        .card-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 0.9em;
            color: #718096;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }
        .status-attivo { background: #c6f6d5; color: #22543d; }
        .status-scaduto { background: #fed7d7; color: #742a2a; }
        .status-disattivo { background: #e2e8f0; color: #4a5568; }
        
        .winner-highlight {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            font-size: 1.1em;
        }
        
        .btn {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(66, 153, 225, 0.3);
        }
        
        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }
        .no-results h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 30px 15px;
            }
            .section {
                padding: 25px 20px;
            }
            .sondaggio-meta {
                flex-direction: column;
                gap: 10px;
            }
            .results-summary {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            .option-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            .option-stats {
                text-align: left;
            }
            .sondaggi-grid {
                grid-template-columns: 1fr;
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
    </style>
</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="container">
        <?php
        require_once 'config.php';
        $pdo = getDBConnection();
        
        // Se è specificato un ID sondaggio, mostra i risultati dettagliati
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $sondaggio_id = (int)$_GET['id'];
            
            // Ottieni i dati del sondaggio
            $stmt = $pdo->prepare("
                SELECT s.*, COUNT(v.id) as totale_voti 
                FROM sondaggi s 
                LEFT JOIN voti v ON s.id = v.sondaggio_id 
                WHERE s.id = ? 
                GROUP BY s.id
            ");
            $stmt->execute([$sondaggio_id]);
            $sondaggio = $stmt->fetch();
            
            if (!$sondaggio) {
                echo '<div class="section no-results"><h3>❌ Sondaggio non trovato</h3><p>Il sondaggio richiesto non esiste.</p></div>';
                exit;
            }
            
            // Ottieni i risultati dettagliati
            $stmt = $pdo->prepare("
                SELECT 
                    os.id,
                    os.testo_opzione,
                    COUNT(v.id) as numero_voti,
                    CASE 
                        WHEN (SELECT COUNT(*) FROM voti WHERE sondaggio_id = ?) = 0 THEN 0 
                        ELSE ROUND((COUNT(v.id) * 100.0 / (SELECT COUNT(*) FROM voti WHERE sondaggio_id = ?)), 1) 
                    END as percentuale
                FROM opzioni_sondaggio os
                LEFT JOIN voti v ON os.id = v.opzione_id
                WHERE os.sondaggio_id = ?
                GROUP BY os.id, os.testo_opzione
                ORDER BY numero_voti DESC, os.ordine_visualizzazione
            ");
            $stmt->execute([$sondaggio_id, $sondaggio_id, $sondaggio_id]);
            $risultati = $stmt->fetchAll();
            
            $isAttivo = isSondaggioAttivo($sondaggio);
            $statusClass = $isAttivo ? 'status-attivo' : ($sondaggio['attivo'] ? 'status-scaduto' : 'status-disattivo');
            $statusText = $isAttivo ? 'Attivo' : ($sondaggio['attivo'] ? 'Scaduto' : 'Disattivato');
        ?>
            
            <div class="header">
                <h1>📈 Risultati Dettagliati</h1>
                <p>Analisi completa dei voti ricevuti</p>
            </div>

            <div class="section">
                <div class="sondaggio-header">
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
                        <span class="status-badge <?php echo $statusClass; ?>">
                            <?php echo $statusText; ?>
                        </span>
                    </div>
                </div>

                <div class="results-summary">
                    <div class="summary-card">
                        <span class="summary-number"><?php echo $sondaggio['totale_voti']; ?></span>
                        <span class="summary-label">Voti Totali</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number"><?php echo count($risultati); ?></span>
                        <span class="summary-label">Opzioni</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number"><?php echo $risultati[0]['numero_voti'] ?? 0; ?></span>
                        <span class="summary-label">Voti Massimi</span>
                    </div>
                    <div class="summary-card">
                        <span class="summary-number"><?php echo $risultati[0]['percentuale'] ?? 0; ?>%</span>
                        <span class="summary-label">Percentuale Max</span>
                    </div>
                </div>

                <?php if ($sondaggio['totale_voti'] > 0 && !empty($risultati)): ?>
                    <div class="winner-highlight">
                        🏆 L'opzione vincente è: "<strong><?php echo htmlspecialchars($risultati[0]['testo_opzione']); ?></strong>" 
                        con <?php echo $risultati[0]['numero_voti']; ?> voti (<?php echo $risultati[0]['percentuale']; ?>%)
                    </div>
                <?php endif; ?>

                <div class="results-list">
                    <?php foreach ($risultati as $index => $risultato): ?>
                        <div class="result-item <?php echo $index === 0 && $risultato['numero_voti'] > 0 ? 'winner' : ''; ?>">
                            <div class="option-header">
                                <div class="option-name"><?php echo htmlspecialchars($risultato['testo_opzione']); ?></div>
                                <div class="option-stats">
                                    <span class="vote-count"><?php echo $risultato['numero_voti']; ?></span>
                                    <span class="percentage"><?php echo $risultato['percentuale']; ?>%</span>
                                </div>
                            </div>
                            
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $risultato['percentuale']; ?>%"></div>
                            </div>

                            <?php if ($risultato['numero_voti'] > 0): ?>
                                <?php
                                // Ottieni i nomi dei votanti per questa opzione
                                $stmt_voters = $pdo->prepare("SELECT nome_votante FROM voti WHERE opzione_id = ? ORDER BY data_voto");
                                $stmt_voters->execute([$risultato['id']]);
                                $voters = $stmt_voters->fetchAll();
                                ?>
                                
                                <div class="voters-section">
                                    <div class="voters-title">Hanno votato <?php echo count($voters); ?> partecipanti</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <a href="risultati.php" class="btn">⬅️ Torna ai Risultati</a>
                    <?php if ($isAttivo): ?>
                        <a href="sondaggi.php" class="btn">🗳️ Partecipa anche tu</a>
                    <?php endif; ?>
                </div>
            </div>

        <?php } else { ?>
            <!-- Lista di tutti i sondaggi con risultato più alto visibile -->
            <div class="header">
                <h1>📊 Risultati Sondaggi</h1>
                <p>Scopri i risultati di tutti i sondaggi con il vincitore di ciascuno</p>
            </div>

            <?php
            // Ottieni tutti i sondaggi con il risultato vincente
            $stmt = $pdo->query("
                SELECT 
                    s.id,
                    s.titolo,
                    s.descrizione,
                    s.data_creazione,
                    s.data_scadenza,
                    s.attivo,
                    COUNT(distinct v.id) as totale_voti,
                    MAX(risultati.numero_voti) as voti_massimi,
                    MAX(risultati.percentuale) as percentuale_massima,
                    (SELECT os.testo_opzione 
                     FROM opzioni_sondaggio os 
                     LEFT JOIN voti v2 ON os.id = v2.opzione_id 
                     WHERE os.sondaggio_id = s.id 
                     GROUP BY os.id 
                     ORDER BY COUNT(v2.id) DESC 
                     LIMIT 1) as opzione_vincente
                FROM sondaggi s 
                LEFT JOIN voti v ON s.id = v.sondaggio_id
                LEFT JOIN (
                    SELECT 
                        os.sondaggio_id,
                        COUNT(v.id) as numero_voti,
                        CASE 
                            WHEN (SELECT COUNT(*) FROM voti WHERE sondaggio_id = os.sondaggio_id) = 0 THEN 0 
                            ELSE ROUND((COUNT(v.id) * 100.0 / (SELECT COUNT(*) FROM voti WHERE sondaggio_id = os.sondaggio_id)), 1) 
                        END as percentuale
                    FROM opzioni_sondaggio os
                    LEFT JOIN voti v ON os.id = v.opzione_id
                    GROUP BY os.sondaggio_id, os.id
                ) risultati ON s.id = risultati.sondaggio_id
                GROUP BY s.id 
                ORDER BY s.data_creazione DESC
            ");
            
            $sondaggi = $stmt->fetchAll();
            ?>

            <?php if (empty($sondaggi)): ?>
                <div class="section no-results">
                    <h3>🤔 Nessun sondaggio disponibile</h3>
                    <p>Non sono ancora stati creati sondaggi.</p>
                    <a href="admin.php" class="btn">➕ Crea il primo sondaggio</a>
                </div>
            <?php else: ?>
                <div class="section">
                    <div class="sondaggi-grid">
                        <?php foreach ($sondaggi as $sondaggio): 
                            $isAttivo = isSondaggioAttivo($sondaggio);
                            $statusClass = $isAttivo ? 'status-attivo' : ($sondaggio['attivo'] ? 'status-scaduto' : 'status-disattivo');
                            $statusText = $isAttivo ? 'Attivo' : ($sondaggio['attivo'] ? 'Scaduto' : 'Disattivato');
                        ?>
                            <div class="sondaggio-card">
                                <h3 class="card-title"><?php echo htmlspecialchars($sondaggio['titolo']); ?></h3>
                                
                                <?php if ($sondaggio['descrizione']): ?>
                                    <p class="card-description"><?php echo htmlspecialchars(substr($sondaggio['descrizione'], 0, 100)) . (strlen($sondaggio['descrizione']) > 100 ? '...' : ''); ?></p>
                                <?php endif; ?>
                                
                                <div class="card-stats">
                                    <span>📅 <?php echo date('d/m/Y', strtotime($sondaggio['data_creazione'])); ?></span>
                                    <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                </div>

                                <?php if ($sondaggio['totale_voti'] > 0): ?>
                                    <div style="background: #f7fafc; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <strong style="color: #4a5568;">🏆 Vincitore attuale:</strong>
                                            <span style="color: #4299e1; font-weight: bold;"><?php echo $sondaggio['voti_massimi']; ?> voti</span>
                                        </div>
                                        <div style="color: #48bb78; font-weight: 600; font-size: 1.1em;">
                                            "<?php echo htmlspecialchars($sondaggio['opzione_vincente'] ?? 'N/A'); ?>"
                                        </div>
                                        <div style="color: #718096; margin-top: 5px;">
                                            <?php echo $sondaggio['percentuale_massima']; ?>% dei voti • <?php echo $sondaggio['totale_voti']; ?> voti totali
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div style="background: #fef5e7; padding: 15px; border-radius: 12px; margin-bottom: 20px; text-align: center; color: #744210;">
                                        📭 Nessun voto ricevuto ancora
                                    </div>
                                <?php endif; ?>

                                <div style="display: flex; gap: 10px;">
                                    <a href="risultati.php?id=<?php echo $sondaggio['id']; ?>" class="btn" style="flex: 1; text-align: center; font-size: 0.9em; padding: 10px 15px;">
                                        📈 Dettagli
                                    </a>
                                    <?php if ($isAttivo): ?>
                                        <a href="sondaggi.php#sondaggio-<?php echo $sondaggio['id']; ?>" class="btn" style="flex: 1; text-align: center; font-size: 0.9em; padding: 10px 15px; background: linear-gradient(135deg, #48bb78, #38a169);">
                                            🗳️ Vota
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php } ?>
    </div>
<?php require 'footer.php'; ?>
    <script>
        // Animazione delle barre di progresso
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Aggiorna i risultati ogni 30 secondi se è una pagina di dettaglio
        <?php if (isset($_GET['id'])): ?>
            setInterval(function() {
                // Solo se la pagina è visibile
                if (!document.hidden) {
                    location.reload();
                }
            }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>