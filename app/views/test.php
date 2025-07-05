<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier Medical</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .calendar {
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #4285f4;
            color: white;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }

        .calendar-header button {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            cursor: pointer;
            padding: 5px 10px;
        }

        .calendar-header button:hover {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .calendar-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            background: #f1f1f1;
            text-align: center;
            font-weight: bold;
        }

        .calendar-weekdays div {
            padding: 10px;
        }

        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-gap: 1px;
            background: #e0e0e0;
        }

        .calendar-days div {
            padding: 10px;
            min-height: 50px;
            background: white;
            text-align: right;
        }

        .calendar-days div.today {
            background: #e6f2ff;
            font-weight: bold;
        }

        .calendar-days div.other-month {
            color: #aaa;
        }

        .calendar-days div:hover {
            background: #f5f5f5;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-button:hover {
            color: #000;
        }
    </style>
</head>

<body>
    <div>
        <ul>
            <li><a href="diagnostic">Gestion maladie</a></li>
            <li><a href="typeevenement">Liste type evenement</a></li>
            <li><a href="evenement/add">Ajouter evenement</a></li>
            <li><a href="deces">Gestion décès</a></li>
        </ul>
    </div>
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