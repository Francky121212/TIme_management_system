
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>saved Schedules</title>
</head>
<body>
<style>
    
.saved-schedules {
    width: 80%;
    margin: 20px auto;
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.saved-schedules h2 {
    margin-bottom: 20px;
    color: #566ee8; 
    text-align: center; 
}

.saved-schedules table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.saved-schedules th, .saved-schedules td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center; 
}

.saved-schedules th {
    background-color: #566ee8; 
    color: white;
}

.saved-schedules td {
    background-color: #f9f9f9; 
}

.saved-schedules button {
    padding: 5px 10px;
    margin: 0 5px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.saved-schedules button:hover {
    opacity: 0.9;
}


.saved-schedules button:nth-child(1) {
    background-color: #28a745; 
    color: white;
}


.saved-schedules button:nth-child(2) {
    background-color: #dc3545; 
    color: white;
}
     </style>
 
     <section class="saved-schedules">
                <h2>Emplois du Temps Sauvegardés</h2>
                <table>
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Date de Sauvegarde</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="saved-schedules-list">
                       
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <script>
        
        const savedSchedules = [
            { name: "Emploi du Temps 1", date: "2023-10-01" },
            { name: "Emploi du Temps 2", date: "2023-10-05" },
            { name: "Emploi du Temps 3", date: "2023-10-10" }
        ];

        const savedSchedulesList = document.getElementById('saved-schedules-list');

        savedSchedules.forEach(schedule => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${schedule.name}</td>
                <td>${schedule.date}</td>
                <td>
                    <button onclick="loadSchedule('${schedule.name}')" aria-label="Charger">Charger</button>
                    <button onclick="deleteSchedule('${schedule.name}')" aria-label="Supprimer">Supprimer</button>
                </td>
            `;
            savedSchedulesList.appendChild(row);
        });

        function loadSchedule(name) {
            alert(`Chargement de l'emploi du temps : ${name}`);
            
        }

        function deleteSchedule(name) {
            alert(`Suppression de l'emploi du temps : ${name}`);
            
        }

    
        document.getElementById('filter-matiere').addEventListener('input', function (event) {
            const searchTerm = event.target.value.toLowerCase();
            const selects = document.querySelectorAll('select');

            selects.forEach(select => {
                const options = select.querySelectorAll('option');
                options.forEach(option => {
                    if (option.textContent.toLowerCase().includes(searchTerm)) {
                        option.style.display = '';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });
        });

       
        function checkForConflicts() {
            const selects = document.querySelectorAll('select');
            const selectedSlots = {};

            selects.forEach(select => {
                const selectedValue = select.value;
                if (selectedValue && selectedValue !== "") {
                    if (selectedSlots[selectedValue]) {
                        alert(`Conflit détecté pour la matière : ${selectedValue}`);
                    } else {
                        selectedSlots[selectedValue] = true;
                    }
                }
            });
        }

        document.querySelector('.btn--save').addEventListener('click', checkForConflicts);

       
        setInterval(() => {
            alert("Sauvegarde automatique en cours...");
          
        }, 300000); 

        
        document.getElementById('exporter').addEventListener('change', function (event) {
            const format = event.target.value;
            if (format) {
                alert(`Exportation en format ${format.toUpperCase()} en cours...`);
               
            }
        });
    </script>
</body>
</html>