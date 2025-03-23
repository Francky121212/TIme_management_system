<!DOCTYPE html>
<html>
<head>
    <title>Emploi du Temps</title>
    <style>
        /* Styles globaux */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        thead {
            background-color: #2c3e50;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #d1e7fd;
        }

        /* Style spécifique pour les jours */
        .day-cell {
            font-weight: bold;
            color: #e74c3c; /* Rouge pour attirer l'attention sur les jours */
        }

        /* Style pour les heures */
        .time-cell {
            font-family: monospace;
            color: #27ae60; /* Vert pour les heures */
        }

        /* Style pour les matières */
        .subject-cell {
            font-style: italic;
            color: #34495e; /* Bleu-gris pour les matières */
        }
    </style>
</head>
<body>
    <h1>Emploi du Temps</h1>
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Matière</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td class="day-cell">{{ $schedule->day_name }}</td>
                <td class="time-cell">{{ $schedule->start_time }}</td>
                <td class="time-cell">{{ $schedule->end_time }}</td>
                <td class="subject-cell">{{ $schedule->subject }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>