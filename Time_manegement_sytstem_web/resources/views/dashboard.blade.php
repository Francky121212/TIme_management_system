<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    <link rel="stylesheet" href="{{ asset('static/dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Ajout de la bibliothèque html-to-image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.9.0/html-to-image.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Tableau de Bord</h2>
            <nav>
                <ul>
                    <li><a href="#" aria-label="Messages"><i class='bx bx-message'></i> Messages</a></li>
                    <li><a href="#" aria-label="Envoi de Notification"><i class='bx bx-bell'></i> Notifications</a></li>
                    <li><a href="#" aria-label="Notes"><i class='bx bx-note'></i> Notes</a></li>
                </ul>
            </nav>
            <button class="logout" aria-label="Déconnexion">Déconnexion</button>
        </aside>

        <!-- Contenu principal -->
        <main>
            <!-- Sélection des utilisateurs -->
            <section class="user-selection">
                <div class="user-selection__item" onclick="toggleOnlineList('admin')">
                    <a href="#" aria-label="Admin"><i class='bx bx-user'></i> Admin</a>
                </div>
                <div class="user-selection__item" onclick="toggleOnlineList('professeur')">
                    <a href="#" aria-label="Professeurs"><i class='bx bxs-user-circle'></i> Professeurs</a>
                </div>
                <div class="user-selection__item" onclick="toggleOnlineList('etudiant')">
                    <a href="#" aria-label="Étudiants"><i class='bx bxs-user-account'></i> Étudiants</a>
                </div>
            </section>
            
            <div id="online-list" class="online-list" aria-live="polite"></div>

            <!-- Section d'exportation -->
            <section class="export-section">
                <label for="exporter">Exporter :</label>
                <select name="exporter" id="exporter" required>
                    <option value="">Sélectionnez un format</option>
                    <option value="pdf">Format PDF</option>
                    <option value="jpeg">Format JPEG</option>
                    <option value="excel">Format Excel</option>
                </select>
                <!-- Boutons d'exportation -->
                <div>
                    <a href="{{ route('schedules.pdf') }}" class="btn btn--export">Exporter en PDF</a>
                    <a href="{{ route('schedules.excel') }}" class="btn btn--export">Exporter en Excel</a>
                    <button id="export-jpeg" class="btn btn--export">Exporter en JPEG</button>
                </div>
            </section>

            <!-- Tableau de l'emploi du temps -->
            <section class="schedule">
                <form id="schedule-form" action="{{ route('schedules.store') }}" method="POST">
                    @csrf
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">Heures</th>
                                <th scope="col">Lundi</th>
                                <th scope="col">Mardi</th>
                                <th scope="col">Mercredi</th>
                                <th scope="col">Jeudi</th>
                                <th scope="col">Vendredi</th>
                                <th scope="col">Samedi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <script>
                                const matieres = ["", "Java", "Python", "Programmation Logique", "Théorie des langages de compilation", "C++", "Anglais", "Japonais", "Entreprenariat au BF", "Finance et Compta"];
                                for (let heure = 8; heure < 18; heure++) {
                                    document.write("<tr>");
                                    document.write(`<th scope="row">${heure}h - ${heure + 1}h</th>`);
                                    for (let jour = 1; jour <= 6; jour++) {
                                        document.write("<td>");
                                        document.write(`<select name="schedule[${heure}][${jour}]" aria-label='Sélectionnez une matière'>`);
                                        matieres.forEach(matiere => {
                                            document.write(`<option value='${matiere}'>${matiere}</option>`);
                                        });
                                        document.write("</select>");
                                        document.write("</td>");
                                    }
                                    document.write("</tr>");
                                }
                            </script>
                        </tbody>
                    </table>
                    <!-- Bouton Enregistrer -->
                    <button type="submit" class="btn btn--save" aria-label="Enregistrer">Enregistrer</button>
                </form>
            </section>

            <!-- Actions -->
            <section class="actions">
                <!-- Boutons Modifier pour chaque emploi du temps -->
                @if(isset($schedules) && !$schedules->isEmpty())
                    @foreach ($schedules as $schedule)
                        <button type="submit" class="btn btn--edit" aria-label="Modifier">
                            <a href="{{ route('schedules.edit', $schedule->id) }}">Modifier</a>
                        </button>
                    @endforeach
                @else
                    <p>Aucun emploi du temps disponible.</p>
                @endif
            </section>
        </main>

        <!-- Script pour exporter en JPEG -->
        <script>
            document.getElementById('export-jpeg').addEventListener('click', function () {
                const table = document.querySelector('.schedule table'); // Sélectionne le tableau
                if (table) {
                    htmlToImage.toJpeg(table, { quality: 0.95 }) // Convertit le tableau en JPEG
                        .then(function (dataUrl) {
                            const link = document.createElement('a');
                            link.href = dataUrl;
                            link.download = 'emploi_du_temps.jpeg'; // Nom du fichier
                            link.click();
                        })
                        .catch(function (error) {
                            console.error('Erreur lors de la génération de l\'image :', error);
                        });
                } else {
                    alert('Le tableau n\'a pas été trouvé.');
                }
            });
        </script>
    </div>
</body>
</html>