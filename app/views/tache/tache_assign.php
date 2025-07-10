<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h4>Assigner une tâche</h4>
            </div>
            
            <?php if (!isset($id_employe)): ?>
            <div class="basic-form">
                <form method="post" action="<?= BASE_URL ?>/tache/assign">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Employé:</label>
                        <div class="col-sm-9">
                            <select name="id_employe" class="form-control" required>
                                <?php foreach ($employes as $emp): ?>
                                    <option value="<?= $emp['id_employe'] ?>">
                                        <?= htmlspecialchars($emp['nom_employe'].' '.$emp['prenom_employe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" name="continue" value="1" class="btn btn-primary">Continuer</button>
                        </div>
                    </div>
                </form>
            </div>
            <?php else: ?>
            
            <div class="basic-form">
                <form method="post" action="<?= BASE_URL ?>/tache/assign/save">
                    <input type="hidden" name="id_employe" value="<?= $id_employe ?>">
                    <input type="hidden" name="date_attribution" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="statut" value="en cours">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Employé:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?= htmlspecialchars($employe_nom) ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tâche:</label>
                        <div class="col-sm-9">
                            <select name="id_tache" class="form-control" required>
                                <?php foreach ($taches as $tache): ?>
                                    <option value="<?= $tache['id_tache'] ?>">
                                        <?= htmlspecialchars($tache['nom_tache']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Précision:</label>
                        <div class="col-sm-9">
                            <input type="text" name="precision" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Date d'échéance:</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <select id="monthSelect" class="form-control">
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
                                </div>
                                <div class="col-md-6 mb-2">
                                    <select id="yearSelect" class="form-control">
                                        <option value="">Année</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="calendar mt-3" id="calendar" style="display:none;">
                                <div class="card">
                                    <div class="card-header bg-primary text-white" id="calendarHeader">
                                        Sélectionnez un jour
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col text-center font-weight-bold">Lun</div>
                                            <div class="col text-center font-weight-bold">Mar</div>
                                            <div class="col text-center font-weight-bold">Mer</div>
                                            <div class="col text-center font-weight-bold">Jeu</div>
                                            <div class="col text-center font-weight-bold">Ven</div>
                                            <div class="col text-center font-weight-bold">Sam</div>
                                            <div class="col text-center font-weight-bold">Dim</div>
                                        </div>
                                        <div class="row" id="calendarGrid"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3" id="selectedDate" style="display:none;">
                                <strong>Date sélectionnée :</strong> <span id="selectedDateText"></span>
                                <input type="hidden" id="hiddenDateInput" name="date_echeance">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>Valider</button>
                            <a href="<?= BASE_URL ?>/tache/assign" class="btn btn-light">Annuler</a>
                        </div>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
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