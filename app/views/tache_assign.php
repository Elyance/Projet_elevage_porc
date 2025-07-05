<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Date avec Calendrier</title>
    <style>
        .date-picker-container {
            max-width: 400px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
        }
        
        .month-year-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .month-year-selector select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .calendar {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: none;
        }
        
        .calendar.show {
            display: block;
        }
        
        .calendar-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #f0f0f0;
            padding: 10px;
        }
        
        .calendar-day-header {
            background: #e9ecef;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }
        
        .calendar-day {
            background: white;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border: 1px solid transparent;
            min-height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .calendar-day:hover {
            background: #e3f2fd;
            border-color: #2196f3;
        }
        
        .calendar-day.selected {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        
        .calendar-day.disabled {
            color: #ccc;
            cursor: not-allowed;
            background: #f8f9fa;
        }
        
        .calendar-day.disabled:hover {
            background: #f8f9fa;
            border-color: transparent;
        }
        
        .selected-date {
            margin-top: 15px;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f8f9fa;
        }
        
        .demo-form {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        button[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        
        button[type="submit"]:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        
        button[type="submit"]:hover:not(:disabled) {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="date-picker-container">
        <h2>Assigner une tâche</h2>
        
        <!-- Première étape : sélection de l'employé -->
        <?php if (!isset($id_employe)): ?>
        <form method="post" action="<?= BASE_URL ?>/tache/assign">
            <div class="form-group">
                <label>Sélectionner un employé :</label>
                <select name="id_employe" required>
                    <?php foreach ($employes as $emp): ?>
                        <option value="<?= $emp['id_employe'] ?>"> <?= htmlspecialchars($emp['nom_employe'].' '.$emp['prenom_employe']) ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="continue" value="1">CONTINUE</button>
        </form>
        <?php else: ?>
        
        <!-- Deuxième étape : assignation de la tâche avec calendrier -->
        
        <form method="post" action="<?= BASE_URL ?>/tache/assign/save">
            <input type="hidden" name="id_employe" value="<?= $id_employe ?>">
            
            <div class="form-group">
                <label>Pour employé :</label>
                <input type="text" value="<?= htmlspecialchars($employe_nom) ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Sélection de la tâche :</label>
                <select name="id_tache" required>
                    <?php foreach ($taches as $tache): ?>
                        <option value="<?= $tache['id_tache'] ?>"> <?= htmlspecialchars($tache['nom_tache']) ?> </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date d'échéance :</label>
                <div class="month-year-selector">
                    <select id="monthSelect">
                        <option value="">Mois</option>
                        <option value="0">Janvier</option>
                        <option value="1">Février</option>
                        <option value="2">Mars</option>
                        <option value="3">Avril</option>
                        <option value="4">Mai</option>
                        <option value="5">Juin</option>
                        <option value="6">Juillet</option>
                        <option value="7">Août</option>
                        <option value="8">Septembre</option>
                        <option value="9">Octobre</option>
                        <option value="10">Novembre</option>
                        <option value="11">Décembre</option>
                    </select>
                    <select id="yearSelect">
                        <option value="">Année</option>
                    </select>
                </div>
                
                <div class="calendar" id="calendar">
                    <div class="calendar-header" id="calendarHeader">
                        Sélectionnez un jour
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <div class="calendar-day-header">Lun</div>
                        <div class="calendar-day-header">Mar</div>
                        <div class="calendar-day-header">Mer</div>
                        <div class="calendar-day-header">Jeu</div>
                        <div class="calendar-day-header">Ven</div>
                        <div class="calendar-day-header">Sam</div>
                        <div class="calendar-day-header">Dim</div>
                    </div>
                </div>
                
                <div class="selected-date" id="selectedDate" style="display: none;">
                    <strong>Date sélectionnée :</strong> <span id="selectedDateText"></span>
                    <input type="hidden" id="hiddenDateInput" name="date_echeance">
                </div>
            </div>
            
            <button type="submit" id="submitBtn" disabled>Valider</button>
        </form>
        <?php endif; ?>
    </div>

    <script>
        class DatePicker {
            constructor() {
                this.monthSelect = document.getElementById('monthSelect');
                this.yearSelect = document.getElementById('yearSelect');
                this.calendar = document.getElementById('calendar');
                this.calendarHeader = document.getElementById('calendarHeader');
                this.calendarGrid = document.getElementById('calendarGrid');
                this.selectedDate = document.getElementById('selectedDate');
                this.selectedDateText = document.getElementById('selectedDateText');
                this.hiddenDateInput = document.getElementById('hiddenDateInput');
                this.submitBtn = document.getElementById('submitBtn');
                
                this.selectedDay = null;
                this.currentMonth = null;
                this.currentYear = null;
                
                this.init();
            }
            
            init() {
                this.populateYears();
                this.bindEvents();
            }
            
            populateYears() {
                const currentYear = new Date().getFullYear();
                for (let year = currentYear; year <= currentYear + 5; year++) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    this.yearSelect.appendChild(option);
                }
            }
            
            bindEvents() {
                this.monthSelect.addEventListener('change', () => this.showCalendar());
                this.yearSelect.addEventListener('change', () => this.showCalendar());
            }
            
            showCalendar() {
                const month = parseInt(this.monthSelect.value);
                const year = parseInt(this.yearSelect.value);
                
                if (isNaN(month) || isNaN(year)) {
                    this.calendar.classList.remove('show');
                    return;
                }
                
                this.currentMonth = month;
                this.currentYear = year;
                
                this.generateCalendar(month, year);
                this.calendar.classList.add('show');
            }
            
            generateCalendar(month, year) {
                const monthNames = [
                    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                ];
                
                this.calendarHeader.textContent = `${monthNames[month]} ${year}`;
                
                // Effacer les jours précédents
                const existingDays = this.calendarGrid.querySelectorAll('.calendar-day');
                existingDays.forEach(day => day.remove());
                
                // Calculer le premier jour du mois (0 = dimanche, 1 = lundi, etc.)
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                
                // Ajuster pour que lundi soit le premier jour (0)
                let startDay = firstDay.getDay();
                startDay = startDay === 0 ? 6 : startDay - 1;
                
                // Ajouter les jours vides au début
                for (let i = 0; i < startDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day disabled';
                    this.calendarGrid.appendChild(emptyDay);
                }
                
                // Ajouter les jours du mois
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'calendar-day';
                    dayElement.textContent = day;
                    dayElement.addEventListener('click', () => this.selectDay(day));
                    this.calendarGrid.appendChild(dayElement);
                }
            }
            
            selectDay(day) {
                // Retirer la sélection précédente
                const previousSelected = this.calendarGrid.querySelector('.calendar-day.selected');
                if (previousSelected) {
                    previousSelected.classList.remove('selected');
                }
                
                // Sélectionner le nouveau jour
                const dayElements = this.calendarGrid.querySelectorAll('.calendar-day');
                dayElements.forEach(el => {
                    if (el.textContent == day && !el.classList.contains('disabled')) {
                        el.classList.add('selected');
                    }
                });
                
                this.selectedDay = day;
                this.updateSelectedDate();
            }
            
            updateSelectedDate() {
                if (this.selectedDay && this.currentMonth !== null && this.currentYear) {
                    const selectedDate = new Date(this.currentYear, this.currentMonth, this.selectedDay);
                    const formattedDate = selectedDate.toLocaleDateString('fr-FR', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                    
                    // Format pour l'input hidden (YYYY-MM-DD)
                    const isoDate = selectedDate.toISOString().split('T')[0];
                    
                    this.selectedDateText.textContent = formattedDate;
                    this.hiddenDateInput.value = isoDate;
                    this.selectedDate.style.display = 'block';
                    this.submitBtn.disabled = false;
                } else {
                    this.selectedDate.style.display = 'none';
                    this.submitBtn.disabled = true;
                }
            }
        }
        
        // Initialiser le sélecteur de date
        document.addEventListener('DOMContentLoaded', () => {
            new DatePicker();
        });
    </script>
</body>
</html>