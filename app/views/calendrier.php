<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calendrier présence</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <style>
        body { font-family: Arial; margin: 40px; }
        #formulaire { margin-top: 30px; display: none; }
    </style>
</head>
<body>

<h2>📅 Calendrier de présence</h2>
<div id="calendar"></div>

<div id="formulaire">
    <h3>Absents pour <span id="selected-date"></span></h3>
    <form id="presence-form">
        <div id="employe-list"></div>
        <input type="hidden" name="date_presence" id="date_presence">
        <button type="submit">Confirmer</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        dateClick(info) {
            const selected = info.dateStr;
            document.getElementById('selected-date').textContent = selected;
            document.getElementById('date_presence').value = selected;
            document.getElementById('formulaire').style.display = 'block';

            fetch('/presence/employes')
            .then(res => res.json())
            .then(data => {
                let html = '';
                data.forEach(emp => {
                    html += `<label>
                        <input type="checkbox" name="absents[]" value="${emp.id_employe}">
                        ${emp.nom_employe} ${emp.prenom_employe}
                    </label>`;
                });
                document.getElementById('employe-list').innerHTML = html;
            });
        },
        events: {
            url: 'index.php?action=getDates'
        }
    });

    calendar.render();

    document.getElementById('presence-form').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('/presence/save', {
        method: 'POST',
        body: formData
        })
        .then(res => res.text())
        .then(msg => {
            alert(msg);
            calendar.refetchEvents();
            document.getElementById('formulaire').style.display = 'none';
        });
    });
});
</script>

</body>
</html>
