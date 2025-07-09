<head>
    <link href="<?= STATIC_URL ?>/assets/css/sante-style.css    " rel="stylesheet">
</head>

<body>
    <?php require_once __DIR__ . '/sante/header.php'; ?>
    <div class="calendar">
        <h2>Calendrier</h2>
        <div class="calendar-header">
            <button id="prev-month">◀</button>
            <h2 id="month-year">Mois Année</h2>
            <button id="next-month">▶</button>
        </div>
        <div class="calendar-weekdays">
            <div>Lun</div>
            <div>Mar</div>
            <div>Mer</div>
            <div>Jeu</div>
            <div>Ven</div>  
            <div>Sam</div>
            <div>Dim</div>
        </div>
        <div class="calendar-days" id="calendar-days">
            <!-- Les jours seront ajoutés par JavaScript -->
        </div>
    </div>
    <div id="dayModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <div id="modalBody">
                <!-- Le contenu des détails sera injecté ici -->
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let events = JSON.parse(localStorage.getItem('calendarEvents')) || {};

        const monthYearElement = document.getElementById('month-year');
        const calendarDaysElement = document.getElementById('calendar-days');
        const prevMonthButton = document.getElementById('prev-month');
        const nextMonthButton = document.getElementById('next-month');

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth()+1;
        let currentYear = currentDate.getFullYear();

        const months = [
            'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
            'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
        ];

        function showDayDetails(day, month, year) {
            const dateKey = `${day}-${month}-${year}`;

            const modal = document.getElementById('dayModal');
            const modalBody = document.getElementById('modalBody');
            const closeBtn = document.querySelector('.close-button');

            // Nettoyage et ajout des événements
            modalBody.innerHTML = `<h3>Détails pour le ${day}/${month}/${year}</h3>`;

            fetch(`evenement?day=${day}&month=${month}&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        modalBody.innerHTML += `<h4>Événements :</h4>`;
                        data.forEach(flight => {
                            modalBody.innerHTML += `
                    <div style="margin-bottom: 10px;">
                        <p><strong>Enclos :</strong> ${flight.id_enclos}</p>
                        <p><strong>Type :</strong> ${flight.nom_type_evenement}</p>
                        <p><strong>Prix :</strong> ${flight.prix}</p>
                    </div>
                `;
                        });
                    } else {
                        modalBody.innerHTML += `<p>Aucun événement pour ce jour.</p>`;
                    }
                    modal.style.display = 'block';
                })
                .catch(err => {
                    console.error(err);
                    modalBody.innerHTML += `<p style="color:red;">Erreur lors du chargement des événements.</p>`;
                    modal.style.display = 'block';
                });

            // Fermer la modale
            closeBtn.onclick = () => {
                modal.style.display = 'none';
            };

            window.onclick = (event) => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            };
        }



        // Afficher le calendrier
        function renderCalendar() {
            // Mettre à jour le mois et l'année affichés
            monthYearElement.textContent = `${months[currentMonth-1]} ${currentYear}`;

            // Vider le calendrier
            calendarDaysElement.innerHTML = '';

            // Premier jour du mois
            const firstDay = new Date(currentYear, currentMonth, 1);
            const startingDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Ajustement pour Lundi=0

            // Dernier jour du mois
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const totalDays = lastDay.getDate();

            // Dernier jour du mois précédent
            const prevLastDay = new Date(currentYear, currentMonth, 0);
            const prevTotalDays = prevLastDay.getDate();

            // Jours du mois suivant
            const nextDays = 7 - ((startingDay + totalDays) % 7);

            // Ajouter les jours du mois précédent
            for (let i = startingDay; i > 0; i--) {
                const day = prevTotalDays - i + 1;
                const dayElement = document.createElement('div');
                dayElement.classList.add('other-month');
                dayElement.textContent = day;
                calendarDaysElement.appendChild(dayElement);
            }

            // Ajouter les jours du mois courant
            const today = new Date();
            for (let i = 1; i <= totalDays; i++) {
                const dayElement = document.createElement('div');
                dayElement.textContent = i;

                // Mettre en évidence le jour actuel
                if (i === today.getDate() &&
                    currentMonth === today.getMonth() &&
                    currentYear === today.getFullYear()) {
                    dayElement.classList.add('today');
                }

                dayElement.addEventListener('click', () => {
                    showDayDetails(i, currentMonth, currentYear);
                });


                calendarDaysElement.appendChild(dayElement);
            }

            // Ajouter les jours du mois suivant
            for (let i = 1; i <= nextDays; i++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('other-month');
                dayElement.textContent = i;
                calendarDaysElement.appendChild(dayElement);
            }
        }

        // Mois précédent
        prevMonthButton.addEventListener('click', function () {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });

        // Mois suivant
        nextMonthButton.addEventListener('click', function () {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });

        // Afficher le calendrier initial
        renderCalendar();
    });
</script>
</body>

</html>