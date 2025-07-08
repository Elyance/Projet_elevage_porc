<?php // Fallback to query parameter if route param is missing
    use app\models\TacheModel;
        $id_employe = $_SESSION['user_id'];

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $currentMonth = date('m');
        $currentYear = date('Y');
        $tasks = TacheModel::getTachesEmploye($id_employe);

        $calendar = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $firstDay = new DateTime("$currentYear-$currentMonth-01");
        $dayOfWeek = $firstDay->format('w');

        for ($i = 0; $i < ($dayOfWeek + $daysInMonth); $i++) {
            $day = $i - $dayOfWeek + 1;
            $dateKey = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            $calendar[$i] = [
                'day' => $day > 0 && $day <= $daysInMonth ? $day : '',
                'tasks' => array_filter($tasks, fn($t) => $t['date_echeance'] === $dateKey) ?: []
            ];
        }

        Flight::render('tache/employee_landing', [
            'calendar' => $calendar,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
            'id_employe' => $id_employe,
            'flash' => $flash,
            'daysInMonth' => $daysInMonth,
            'dayOfWeek' => $dayOfWeek,
            'tasks' => $tasks
        ]);