<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    <link rel="stylesheet" href="{{ asset('static/dashboard.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
       
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
        
      
        <main>
           
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

            <section class="export-section">
                <label for="exporter">Exporter :</label>
                <select name="exporter" id="exporter" required>
                    <option value="">Sélectionnez un format</option>
                    <option value="pdf">Format PDF</option>
                    <option value="jpeg">Format JPEG</option>
                    <option value="excel">Format Excel</option>
                </select>
            </section>

           
          
            <section class="schedule">
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
                                    document.write("<select aria-label='Sélectionnez une matière'>");
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
            </section>

           
            <section class="actions">
                <button type="submit" class="btn btn--save" aria-label="Enregistrer"  ><a href="http:{{ url('register') }}"></a>
                    Enregistrer</button>
                <button type="submit" class="btn btn--edit" aria-label="Modifier">Modifier</button>
            </section>

           
</body>
</html>