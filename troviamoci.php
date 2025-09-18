<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require 'titolo.php'; ?>
    <?php require 'styles/style_troviamoci.php'; ?>

</head>
<body>
    <?php require 'menu.php'; ?>

    <div class="container">
        <h1>🗺️ Triangolazione Coordinate Avanzata</h1>
        
        <!-- Sezione per aggiungere nuove location -->
        <div class="add-location-section">
            <h2>➕ Aggiungi Nuova Location</h2>
            <div class="input-group">
                <div class="input-field">
                    <label>Indirizzo</label>
                    <input type="text" id="new-address" placeholder="es. Via Roma, 123">
                </div>
                <div class="input-field">
                    <label>Città</label>
                    <input type="text" id="new-city" placeholder="es. Milano">
                </div>
                <div class="input-field">
                    <label>CAP</label>
                    <input type="text" id="new-cap" placeholder="es. 20121">
                </div>
                <button class="btn success" onclick="addNewLocation()">
                    <span id="add-btn-text">🔍 Cerca e Aggiungi</span>
                </button>
            </div>
            <div id="add-status"></div>
        </div>
        
        <div class="locations-grid" id="locations-grid">
            <!-- Le location verranno inserite qui via JavaScript -->
        </div>

        <div class="triangulation-result">
            <div style="font-size: 3em; margin-bottom: 10px;">🗺️</div>
            <h2>📍 Punto Centrale Triangolato</h2>
            <div class="center-coords" id="center-coords">
                Calcolo in corso...
            </div>
            <div id="center-description"></div>
        </div>
        <div class="controls">
            <button class="btn" onclick="recalculateCenter()">🔄 Ricalcola Centro</button>
            <button class="btn" onclick="showOnGoogleMaps()">🗺️ Centro su Google Maps</button>
            <button class="btn" onclick="copyCoordinates()">📋 Copia Coordinate</button>
            <button class="btn danger" onclick="clearAllLocations()">🗑️ Elimina Tutto</button>
        </div>
        <!-- Sezione ristoranti -->
        <div class="restaurants-section">
            <h2>🍽️ Ristoranti nella Zona</h2>
            <div class="restaurants-controls">
                <select class="radius-selector" id="radius-selector">
                    <option value="1000">Entro 1 km</option>
                    <option value="2000" selected>Entro 2 km</option>
                    <option value="5000">Entro 5 km</option>
                    <option value="10000">Entro 10 km</option>
                    <option value="20000">Entro 20 km</option>
                </select>
                <button class="btn warning" onclick="searchRestaurants()">
                    🔍 Cerca Ristoranti
                </button>
                <button class="btn warning" onclick="showRestaurantsOnMap()">
                    🗺️ Visualizza su Mappa
                </button>
            </div>
            <div id="restaurants-results"></div>
        </div>

        <!-- Sezione alberghi -->
        <div class="alberghi-section">
            <h2>🍽️ Alberghi nella Zona</h2>
            <div class="alberghi-controls">
                <select class="radius-selector" id="radius-selector-alberghi">
                    <option value="1000">Entro 1 km</option>
                    <option value="2000" selected>Entro 2 km</option>
                    <option value="5000">Entro 5 km</option>
                    <option value="10000">Entro 10 km</option>
                    <option value="20000">Entro 20 km</option>
                </select>
                <button class="btn success" onclick="searchAlberghi()">
                    🔍 Cerca Alberghi
                </button>
                <button class="btn success" onclick="showAlberghiOnMap()">
                    🗺️ Visualizza Alberghi su Mappa
                </button>
            </div>
            <div id="alberghi-results"></div>
        </div>
       

        
    </div>
<?php require 'footer.php'; ?>
    <script>
        // Coordinate iniziali
        let locations = [
            {
                id: 1,
                name: "Bagno a Ripoli",
                address: "Via Antonio Meucci, 17/19/21, 50012",
                lat: 43.7505,
                lng: 11.3426,
                color: "#e53e3e"
            },
            {
                id: 2,
                name: "Roma",
                address: "Viale dell'Oceano Indiano 13/c, 00144 Roma",
                lat: 41.8057,
                lng: 12.4678,
                color: "#dd6b20"
            },
            {
                id: 3,
                name: "Milano",
                address: "Via Esterle, 9/11, 20130 Milano",
                lat: 45.4773,
                lng: 9.2267,
                color: "#38a169"
            },
            {
                id: 4,
                name: "Treviglio",
                address: "Via Abate Crippa 1, 24047 Treviglio (BG)",
                lat: 45.5225,
                lng: 9.5959,
                color: "#3182ce"
            },
            {
                id: 5,
                name: "Fornacette",
                address: "Via Tosco Romagnola n. 101 A- 56012 Calcinaia (PI)",
                lat: 43.6839,
                lng: 10.6242,
                color: "#805ad5"
            }
        ];

        let centerCoords = { lat: 0, lng: 0 };
        let nextLocationId = 6;
        const colors = ["#e53e3e", "#dd6b20", "#38a169", "#3182ce", "#805ad5", "#d69e2e", "#00b3d7", "#9f7aea"];



		async function geocodeAddress(address, city, cap) {
			const full = `${address}, ${cap || ''} ${city}, Italia`.trim();
		  const url = `https://nominatim.openstreetmap.org/search?format=json&limit=5&q=${encodeURIComponent(full)}&countrycodes=it&addressdetails=1&accept-language=it`;

		  const res = await fetch(url, {
			headers: { 'User-Agent': 'LaTuaApp/1.0 (tuo.email@esempio.com)' } // richiesto da OSM
		  });
		  const data = await res.json();
		  if (!data.length) throw new Error('Nessun risultato');

		  // Preferisci risultati con country_code 'it'
		  const pick = data.find(r => r.address && r.address.country_code === 'it') || data[0];

		  return { lat: parseFloat(pick.lat), lng: parseFloat(pick.lon), raw: pick };
		}

        // Aggiungi nuova location
        async function addNewLocation() {
            const address = document.getElementById('new-address').value.trim();
            const city = document.getElementById('new-city').value.trim();
            const cap = document.getElementById('new-cap').value.trim();
            const statusDiv = document.getElementById('add-status');
            const btnText = document.getElementById('add-btn-text');
            
            if (!address || !city || !cap) {
                showStatus('Compila tutti i campi per aggiungere una location', 'error');
                return;
            }
            
            // Mostra loading
            btnText.innerHTML = '<span class="loading">🔍</span> Ricerca in corso...';
            showStatus('Ricerca coordinate in corso...', 'info');
            
            try {
                const coords = await geocodeAddress(address, city, cap);
                
                const newLocation = {
                    id: nextLocationId++,
                    name: city,
                    address: `${address}, ${cap} ${city}`,
                    lat: coords.lat,
                    lng: coords.lng,
                    color: colors[(nextLocationId - 2) % colors.length]
                };
                
                locations.push(newLocation);
                
                // Pulisci i campi
                document.getElementById('new-address').value = '';
                document.getElementById('new-city').value = '';
                document.getElementById('new-cap').value = '';
                
                // Aggiorna la visualizzazione
                populateLocationsGrid();
                updateTriangulationResult();
                initMap();
                
                showStatus(`✅ Location "${city}" aggiunta con successo!`, 'success');
                btnText.innerHTML = '🔍 Cerca e Aggiungi';
                
            } catch (error) {
                showStatus('❌ Errore durante la ricerca delle coordinate', 'error');
                btnText.innerHTML = '🔍 Cerca e Aggiungi';
            }
        }

        // Mostra messaggi di stato
        function showStatus(message, type) {
            const statusDiv = document.getElementById('add-status');
            statusDiv.className = `status-message status-${type}`;
            statusDiv.textContent = message;
            
            if (type === 'success') {
                setTimeout(() => {
                    statusDiv.textContent = '';
                    statusDiv.className = '';
                }, 5000);
            }
        }

        // Elimina una location
        function deleteLocation(id) {
            if (locations.length <= 1) {
                alert('Non puoi eliminare l\'ultima location rimasta!');
                return;
            }
            
            if (confirm('Sei sicuro di voler eliminare questa location?')) {
                locations = locations.filter(loc => loc.id !== id);
                populateLocationsGrid();
                updateTriangulationResult();
                initMap();
            }
        }

        // Elimina tutte le location
        function clearAllLocations() {
            if (confirm('Sei sicuro di voler eliminare TUTTE le location? Questa azione non può essere annullata.')) {
                locations = [];
                populateLocationsGrid();
                updateTriangulationResult();
                initMap();
            }
        }

        // Calcola il centro geometrico
        function calculateCenter() {
            if (locations.length === 0) {
                return { lat: 41.9028, lng: 12.4964 }; // Roma di default
            }
            
            let sumLat = 0;
            let sumLng = 0;
            
            locations.forEach(location => {
                sumLat += location.lat;
                sumLng += location.lng;
            });
            
            centerCoords = {
                lat: sumLat / locations.length,
                lng: sumLng / locations.length
            };
            
            return centerCoords;
        }


// Cerca ristoranti (e locali simili) reali nella zona usando Overpass API
async function searchRestaurants() {
    // --- Leggi il valore in METRI dal selettore ---
    const radiusMeters = parseFloat(document.getElementById('radius-selector').value);
    const radiusKm = radiusMeters / 1000; // solo per visualizzazione

    const resultsDiv = document.getElementById('restaurants-results');
    const center = calculateCenter(); // { lat, lng }

    resultsDiv.innerHTML = `
        <div style="text-align: center; margin: 20px 0;">
            <div class="loading" style="font-size: 2em; margin-bottom: 10px;">🔍</div>
            <div>Ricerca locali in corso...</div>
        </div>
    `;

    try {
        // Query Overpass:
        // - include node, way, relation
        // - cerca più tipologie di locali
        const query = `
                [out:json];
                (
                node["amenity"~"restaurant|cafe|fast_food|food_court|pub|bar"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                way["amenity"~"restaurant|cafe|fast_food|food_court|pub|bar"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                relation["amenity"~"restaurant|cafe|fast_food|food_court|pub|bar"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                );
                out center;
        `;

        const response = await fetch("https://overpass-api.de/api/interpreter", {
            method: "POST",
            body: query,
            headers: { "Content-Type": "text/plain" }
        });

        const data = await response.json();
        const elements = data.elements || [];

        if (!elements.length) {
            resultsDiv.innerHTML = `
                <div style="padding:15px; background:rgba(255,255,255,0.2); border-radius:10px;">
                    Nessun locale trovato entro ${radiusKm} km.<br>
                    📍 Coordinate centro: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
                </div>`;
            return;
        }

        const iconByAmenity = {
		  fast_food: "🍕",
		  food_court: "🍝",
		  restaurant: "🍴",
		  bar: "🥐",
		  pub: "🍻",
		  cafe: "☕"
		};

		const listHtml = elements
		  .filter(el => el.tags?.name) // scarta i "Locale senza nome"
		  .map(el => {
			const type = el.tags?.amenity || "sconosciuto";
			const icon = iconByAmenity[type] || "🍽️"; // icona di fallback
			const name = el.tags.name;
			return `
			  <div style="background: rgba(255,255,255,0.1); padding: 8px; border-radius: 5px; text-align: center;">
				${icon} ${name} <span style="font-size:0.8em;opacity:0.7;">(${type})</span>
			  </div>`;
		  })
		  .join("");
        resultsDiv.innerHTML = `
            <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px;">
                <h3 style="margin: 0 0 10px 0;">
                    Trovati ${elements.length} locali entro ${radiusKm} km:
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    ${listHtml}
                </div>
                <div style="margin-top: 15px; font-size: 0.9em; opacity: 0.9;">
                    📍 Coordinate centro: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
                </div>
            </div>
        `;
    } catch (err) {
        console.error(err);
        resultsDiv.innerHTML = `<div style="color:red;">Errore durante la ricerca: ${err.message}</div>`;
    }
}

// Cerca alberghi reali nella zona usando Overpass API
async function searchAlberghi() {
    // --- Leggi il valore in METRI dal selettore ---
    const radiusMeters = parseFloat(document.getElementById('radius-selector-alberghi').value);
    const radiusKm = radiusMeters / 1000; // solo per visualizzazione

    const resultsDiv = document.getElementById('alberghi-results');
    const center = calculateCenter(); // { lat, lng }

    resultsDiv.innerHTML = `
        <div style="text-align: center; margin: 20px 0;">
            <div class="loading" style="font-size: 2em; margin-bottom: 10px;">🔍</div>
            <div>Ricerca Alberghi in corso...</div>
        </div>
    `;

    try {
        // Query Overpass:
        // - include node, way, relation
        // - cerca più tipologie di locali
        const query = `
                [out:json];
                (
                node["amenity"~"hotel|hostel|guest_house|motel"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                way["amenity"~"hotel|hostel|guest_house|motel"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                relation["amenity"~"hotel|hostel|guest_house|motel"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                    
                node["tourism"~"hotel|hostel|guest_house|resort"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                way["tourism"~"hotel|hostel|guest_house|resort"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                relation["tourism"~"hotel|hostel|guest_house|resort"]
                    (around:${radiusMeters},${center.lat},${center.lng});
                );
                out center;
        `;

        const response = await fetch("https://overpass-api.de/api/interpreter", {
            method: "POST",
            body: query,
            headers: { "Content-Type": "text/plain" }
        });

        const data = await response.json();
        const elements = data.elements || [];

        if (!elements.length) {
            resultsDiv.innerHTML = `
                <div style="padding:15px; background:rgba(255,255,255,0.2); border-radius:10px;">
                    Nessun albergo trovato entro ${radiusKm} km.<br>
                    📍 Coordinate centro: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
                </div>`;
            return;
        }

        const iconByAmenity = {
		  hotel: "🏨",
		  motel: "🏩",
		  resort: "🛎️",
		  guest_house: "🏠",
		  hostel: "🛌",
          fast_food: "🍕",
		  food_court: "🍝",
		  restaurant: "🍴",
		  bar: "🥐",
		  pub: "🍻",
		  cafe: "☕"
		};

		const listHtml = elements
		  .filter(el => el.tags?.name) // scarta i "Locale senza nome"
		  .map(el => {
			const type = el.tags?.amenity || "sconosciuto";
			const icon = iconByAmenity[type] || "🏨"; // icona di fallback
			const name = el.tags.name;
			return `
			  <div style="background: rgba(255,255,255,0.1); padding: 8px; border-radius: 5px; text-align: center;">
				${icon} ${name} <span style="font-size:0.8em;opacity:0.7;">(${type})</span>
			  </div>`;
		  })
		  .join("");
        resultsDiv.innerHTML = `
            <div style="background: rgba(255,255,255,0.2); padding: 15px; border-radius: 10px;">
                <h3 style="margin: 0 0 10px 0;">
                    Trovati ${elements.length} alberghi entro ${radiusKm} km:
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px;">
                    ${listHtml}
                </div>
                <div style="margin-top: 15px; font-size: 0.9em; opacity: 0.9;">
                    📍 Coordinate centro: ${center.lat.toFixed(4)}, ${center.lng.toFixed(4)}
                </div>
            </div>
        `;
    } catch (err) {
        console.error(err);
        resultsDiv.innerHTML = `<div style="color:red;">Errore durante la ricerca: ${err.message}</div>`;
    }
}

        

        // Mostra ristoranti su Google Maps
        function showRestaurantsOnMap() {
            const center = calculateCenter();
            const radius = document.getElementById('radius-selector').value;
            const radiusKm = parseInt(radius) / 1000;
            
            const query = encodeURIComponent(`ristoranti vicino ${center.lat},${center.lng}`);
            const url = `https://www.google.com/maps/search/${query}/@${center.lat},${center.lng},${Math.max(12, 16 - radiusKm)}z`;
            window.open(url, '_blank');
        }

        // Mostra Alberghi su Google Maps
        function showAlberghiOnMap() {
            const center = calculateCenter();
            const radius = document.getElementById('radius-selector').value;
            const radiusKm = parseInt(radius) / 1000;
            
            const query = encodeURIComponent(`alberghi vicino ${center.lat},${center.lng}`);
            const url = `https://www.google.com/maps/search/${query}/@${center.lat},${center.lng},${Math.max(12, 16 - radiusKm)}z`;
            window.open(url, '_blank');
        }

        // Calcola distanze tra punti
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng/2) * Math.sin(dLng/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Popola la griglia delle location
        function populateLocationsGrid() {
            const grid = document.getElementById('locations-grid');
            
            if (locations.length === 0) {
                grid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #718096; font-size: 1.2em;">
                        📍 Nessuna location presente<br>
                        <small>Aggiungi la tua prima location usando il modulo sopra</small>
                    </div>
                `;
                return;
            }
            
            grid.innerHTML = '';
            
            locations.forEach((location, index) => {
                const card = document.createElement('div');
                card.className = 'location-card';
                card.innerHTML = `
                    <button class="delete-btn" onclick="deleteLocation(${location.id})" title="Elimina location">×</button>
                    <div class="location-title" style="color: ${location.color};">${location.name}</div>
                    <div class="location-address">${location.address}</div>
                    <div class="location-coords">
                        📍 ${location.lat.toFixed(6)}, ${location.lng.toFixed(6)}
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Aggiorna il risultato della triangolazione
        function updateTriangulationResult() {
            const center = calculateCenter();
            const coordsElement = document.getElementById('center-coords');
            const descriptionElement = document.getElementById('center-description');
            
            if (locations.length === 0) {
                coordsElement.textContent = 'Nessuna coordinata disponibile';
                descriptionElement.innerHTML = '<p>Aggiungi almeno una location per calcolare il centro</p>';
                return;
            }
            
            coordsElement.textContent = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`;
            
            if (locations.length === 1) {
                descriptionElement.innerHTML = `
                    <p>Una sola location presente</p>
                    <small>Aggiungi più location per calcolare un centro triangolato</small>
                `;
                return;
            }
            
            // Calcola le distanze dal centro
            const distances = locations.map(location => {
                return {
                    name: location.name,
                    distance: calculateDistance(center.lat, center.lng, location.lat, location.lng)
                };
            });
            
            const avgDistance = distances.reduce((sum, d) => sum + d.distance, 0) / distances.length;
            const maxDistance = Math.max(...distances.map(d => d.distance));
            const minDistance = Math.min(...distances.map(d => d.distance));
            
            descriptionElement.innerHTML = `
                <p>📊 ${locations.length} location analizzate</p>
                <p>📏 Distanza media: ${avgDistance.toFixed(2)} km | Max: ${maxDistance.toFixed(2)} km | Min: ${minDistance.toFixed(2)} km</p>
                <small>Coordinate WGS84 - Sistema di riferimento globale</small>
            `;
        }

        // Inizializza la mappa
        function initMap() {
            const mapContainer = document.getElementById('map');
            const center = calculateCenter();
            
            if (locations.length === 0) {
                mapContainer.innerHTML = `
                    <div style="width: 100%; height: 100%; background: #f7fafc; display: flex; align-items: center; justify-content: center; font-size: 1.2em; color: #718096;">
                        <div style="text-align: center;">
                            <div style="font-size: 3em; margin-bottom: 10px;">📍</div>
                            <div>Aggiungi location per visualizzare la mappa</div>
                        </div>
                    </div>
                `;
                return;
            }
            
            mapContainer.innerHTML = `
                <div style="
                    width: 100%; 
                    height: 100%; 
                    background: linear-gradient(45deg, #e6f3ff, #b3d9ff);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.2em;
                    color: #2d3748;
                    text-align: center;
                    position: relative;
                ">
                    <div>
                        <div style="font-size: 3em; margin-bottom: 10px;">🗺️</div>
                        <div><strong>Centro Triangolato</strong></div>
                        <div style="font-family: monospace; margin: 10px 0;">
                            ${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}
                        </div>
                        <div style="font-size: 0.9em; opacity: 0.8;">
                            Punto medio di ${locations.length} location
                        </div>
                        <div style="position: absolute; top: 20px; left: 20px; background: rgba(255,255,255,0.9); padding: 10px; border-radius: 5px; font-size: 0.8em;">
                            📍 ${locations.length} punti analizzati
                        </div>
                        <div style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.9); padding: 10px; border-radius: 5px; font-size: 0.8em;">
                            🎯 Centro geografico
                        </div>
                    </div>
                </div>
            `;
        }

        // Funzioni per i bottoni
        function recalculateCenter() {
            updateTriangulationResult();
            initMap();
            if (locations.length > 0) {
                alert('Centro ricalcolato con successo!');
            } else {
                alert('Aggiungi almeno una location per calcolare il centro');
            }
        }

        function showOnGoogleMaps() {
            if (locations.length === 0) {
                alert('Aggiungi almeno una location prima di visualizzare la mappa');
                return;
            }
            const center = calculateCenter();
            const url = `https://www.google.com/maps?q=${center.lat},${center.lng}`;
            window.open(url, '_blank');
        }

        function copyCoordinates() {
            if (locations.length === 0) {
                alert('Nessuna coordinata da copiare');
                return;
            }
            
            const center = calculateCenter();
            const coords = `${center.lat.toFixed(6)}, ${center.lng.toFixed(6)}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(coords).then(() => {
                    alert('Coordinate copiate negli appunti!');
                });
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = coords;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                alert('Coordinate copiate negli appunti!');
            }
        }

        // Gestione eventi tastiera per i campi input
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = ['new-address', 'new-city', 'new-cap'];
            inputs.forEach(id => {
                document.getElementById(id).addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        addNewLocation();
                    }
                });
            });
        });

        // Inizializzazione
        document.addEventListener('DOMContentLoaded', function() {
            populateLocationsGrid();
            updateTriangulationResult();
            initMap();
            
            // Mostra messaggio di benvenuto
            setTimeout(() => {
                showStatus('Sistema di triangolazione pronto! Aggiungi nuove location o modifica quelle esistenti.', 'info');
            }, 500);
        });
    </script>
</body>
</html>