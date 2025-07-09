<!-- views/enclos/list_with_portees.php -->
<div class="container mt-4">

    <!-- Boutons en haut -->
    <div class="mb-4 text-end">
        <a href="<?= BASE_URL ?>/enclos/move" class="btn btn-warning me-2">Déplacer une portée</a>
        <a href="<?= BASE_URL ?>/enclos/convert-females" class="btn btn-success">Convertir truie</a>
    </div>

    <h1 class="mb-4">Liste des Enclos (Visualisation Graphique)</h1>

    <div class="row" id="enclos-canvas-zone">
        <?php foreach ($enclosData as $index => $enclos): ?>
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Enclos ID: <?= htmlspecialchars($enclos['id_enclos']) ?> - <?= htmlspecialchars($enclos['nom_type']) ?> (<?= htmlspecialchars($enclos['surface']) ?> m²)
                    </div>
                    <div class="card-body p-2">
                        <canvas 
                            class="enclos-canvas" 
                            width="500" 
                            height="350"
                            data-portees='<?= htmlspecialchars(json_encode($enclos['portees']), ENT_QUOTES, 'UTF-8') ?>'>
                        </canvas>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    /* Optionnel: Ajoute un curseur "pointer" pour indiquer que les icônes sont interactives */
    .enclos-canvas {
        cursor: default;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvases = document.querySelectorAll('.enclos-canvas');

    canvases.forEach(canvas => {
        const ctx = canvas.getContext('2d');
        const portees = JSON.parse(canvas.dataset.portees);

        // --- Paramètres de dessin ---
        const enclosPadding = 15;
        const enclosRect = {
            x: enclosPadding,
            y: enclosPadding,
            width: canvas.width - enclosPadding * 2,
            height: canvas.height - enclosPadding * 2
        };

        const iconSize = 32; // Taille de l'icône en pixels
        const iconPadding = 15; // Espace entre les icônes
        const iconFont = `${iconSize}px Arial`;
        const iconChar = '🐖'; // Emoji de cochon comme icône

        let positions = []; // Pour stocker les coordonnées de chaque icône
        let hoveredPortee = null; // Pour savoir quelle portée est survolée

        // --- 1. Calculer les positions des icônes ---
        function calculatePositions() {
            positions = [];
            const iconsPerRow = Math.floor(enclosRect.width / (iconSize + iconPadding));
            
            portees.forEach((portee, index) => {
                const col = index % iconsPerRow;
                const row = Math.floor(index / iconsPerRow);

                const posX = enclosRect.x + iconPadding + col * (iconSize + iconPadding);
                const posY = enclosRect.y + iconPadding + row * (iconSize + iconPadding) + iconSize; // +iconSize pour aligner le bas de l'emoji

                positions.push({ x: posX, y: posY, portee: portee });
            });
        }

        // --- 2. Fonction principale de dessin ---
        function draw() {
            // Effacer tout le canvas
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Dessiner le grand rectangle de l'enclos
            ctx.fillStyle = '#f9f9f9';
            ctx.strokeStyle = '#a0a0a0';
            ctx.lineWidth = 2;
            ctx.fillRect(enclosRect.x, enclosRect.y, enclosRect.width, enclosRect.height);
            ctx.strokeRect(enclosRect.x, enclosRect.y, enclosRect.width, enclosRect.height);

            // Gérer le cas où l'enclos est vide
            if (portees.length === 0) {
                ctx.fillStyle = 'gray';
                ctx.font = '18px Arial';
                ctx.textAlign = 'center';
                ctx.fillText("Enclos Vide", canvas.width / 2, canvas.height / 2);
                return;
            }

            // Dessiner chaque icône de portée
            ctx.font = iconFont;
            ctx.textAlign = 'left';
            positions.forEach(pos => {
                ctx.fillText(iconChar, pos.x, pos.y);
            });

            // Dessiner l'info-bulle si une portée est survolée
            if (hoveredPortee) {
                drawTooltip(hoveredPortee);
            }
        }
        
        // --- 3. Dessiner l'info-bulle (Tooltip) ---
        function drawTooltip(pos) {
            const portee = pos.portee;
            const textLines = [
                `Portée ID: ${portee.id_portee ?? 'N/A'}`,
                `Truie: ${portee.id_truie ?? 'N/A'} | Race: ${portee.id_race ?? 'N/A'}`,
                `Naissance: ${portee.date_naissance ?? 'N/A'}`,
                `Jours écoulés: ${portee.nombre_jour_ecoule ?? 'N/A'}`
            ];

            const tooltipWidth = 250;
            const tooltipHeight = 90;
            const tooltipX = pos.x + iconSize / 2;
            const tooltipY = pos.y - iconSize - tooltipHeight;
            
            ctx.fillStyle = 'rgba(0, 0, 0, 0.75)';
            ctx.strokeStyle = 'white';
            ctx.lineWidth = 1;
            ctx.fillRect(tooltipX, tooltipY, tooltipWidth, tooltipHeight);
            ctx.strokeRect(tooltipX, tooltipY, tooltipWidth, tooltipHeight);

            ctx.fillStyle = 'white';
            ctx.font = '14px Arial';
            textLines.forEach((line, i) => {
                ctx.fillText(line, tooltipX + 10, tooltipY + 20 + i * 20);
            });
        }

        // --- 4. Gérer les événements de la souris ---
        canvas.addEventListener('mousemove', function(event) {
            const rect = canvas.getBoundingClientRect();
            const mouseX = event.clientX - rect.left;
            const mouseY = event.clientY - rect.top;

            let isHovering = false;
            for (const pos of positions) {
                // Zone de "hit" de l'icône
                if (mouseX > pos.x && mouseX < pos.x + iconSize && 
                    mouseY > pos.y - iconSize && mouseY < pos.y) {
                    
                    if (hoveredPortee !== pos) {
                        hoveredPortee = pos;
                        draw(); // Redessiner pour afficher le tooltip
                    }
                    isHovering = true;
                    canvas.style.cursor = 'pointer'; // Change le curseur
                    break;
                }
            }
            
            if (!isHovering) {
                if (hoveredPortee !== null) {
                    hoveredPortee = null;
                    draw(); // Redessiner pour enlever le tooltip
                }
                canvas.style.cursor = 'default'; // Remet le curseur par défaut
            }
        });
        
        canvas.addEventListener('mouseleave', function() {
             if (hoveredPortee !== null) {
                hoveredPortee = null;
                draw(); // Redessiner pour enlever le tooltip
            }
            canvas.style.cursor = 'default';
        });

        // --- Lancement initial ---
        calculatePositions();
        draw();
    });
});
</script>