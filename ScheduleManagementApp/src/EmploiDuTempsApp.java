import javax.swing.*;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import java.awt.*;
import java.io.*;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

public class EmploiDuTempsApp extends JFrame {
    private DefaultTableModel modelTableEvenements;
    private JTable tableEvenements;
    private List<Evenement> evenements;
    private JTable calendrierTable;
    private int moisActuel;
    private int anneeActuelle;
    private JLabel moisAnneeLabel;
    private JLabel decompteLabel;
    private Timer timer;

    public EmploiDuTempsApp() {
        evenements = new ArrayList<>();
        String[] colonnes = {"Nom", "Date", "Heure de début", "Heure de fin"};
        modelTableEvenements = new DefaultTableModel(colonnes, 0);
        tableEvenements = new JTable(modelTableEvenements);
        tableEvenements.setFillsViewportHeight(true);

        setTitle("Gestionnaire d'Emploi du Temps");
        setSize(1000, 600);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setLayout(new BorderLayout());

        JMenuBar menuBar = new JMenuBar();
        JMenu fichierMenu = new JMenu("Fichier");
        JMenu editionMenu = new JMenu("Édition");
        JMenu aideMenu = new JMenu("Aide");

        JMenuItem sauvegarderItem = new JMenuItem("Sauvegarder");
        JMenuItem chargerItem = new JMenuItem("Charger");

        sauvegarderItem.addActionListener(e -> sauvegarderEvenements());
        chargerItem.addActionListener(e -> chargerEvenements());

        fichierMenu.add(sauvegarderItem);
        fichierMenu.add(chargerItem);
        menuBar.add(fichierMenu);
        menuBar.add(editionMenu);
        menuBar.add(aideMenu);
        setJMenuBar(menuBar);

        JPanel leftPanel = new JPanel(new BorderLayout());
        leftPanel.setBorder(BorderFactory.createTitledBorder("Liste des événements"));
        leftPanel.add(new JScrollPane(tableEvenements), BorderLayout.CENTER);

        leftPanel.setPreferredSize(new Dimension(400, 600));

        JPanel buttonPanel = new JPanel(new FlowLayout());
        JButton ajouterButton = new JButton("Ajouter un événement");
        JButton modifierButton = new JButton("Modifier l'événement");
        JButton supprimerButton = new JButton("Supprimer l'événement");

        ajouterButton.addActionListener(e -> ajouterEvenement());
        modifierButton.addActionListener(e -> modifierEvenement());
        supprimerButton.addActionListener(e -> supprimerEvenement());

        buttonPanel.add(ajouterButton);
        buttonPanel.add(modifierButton);
        buttonPanel.add(supprimerButton);
        leftPanel.add(buttonPanel, BorderLayout.SOUTH);

        JPanel rightPanel = new JPanel(new BorderLayout());
        rightPanel.setBorder(BorderFactory.createTitledBorder("Calendrier visuel"));

        JButton moisPrecedentButton = new JButton("Mois précédent");
        JButton moisSuivantButton = new JButton("Mois suivant");

        moisPrecedentButton.addActionListener(e -> changerMois(-1));
        moisSuivantButton.addActionListener(e -> changerMois(1));

        moisAnneeLabel = new JLabel();
        moisAnneeLabel.setHorizontalAlignment(SwingConstants.CENTER);
        moisAnneeLabel.setFont(new Font("Serif", Font.BOLD, 18));

        decompteLabel = new JLabel("Décompte : ");
        decompteLabel.setHorizontalAlignment(SwingConstants.CENTER);
        decompteLabel.setFont(new Font("Serif", Font.BOLD, 16));

        JPanel navigationPanel = new JPanel(new BorderLayout());
        navigationPanel.add(moisPrecedentButton, BorderLayout.WEST);
        navigationPanel.add(moisAnneeLabel, BorderLayout.CENTER);
        navigationPanel.add(moisSuivantButton, BorderLayout.EAST);

        rightPanel.add(navigationPanel, BorderLayout.NORTH);

        String[] joursSemaine = {"Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"};
        Object[][] donneesCalendrier = new Object[6][7];
        calendrierTable = new JTable(donneesCalendrier, joursSemaine);
        calendrierTable.setRowHeight(50);
        calendrierTable.setEnabled(false);

        calendrierTable.setDefaultRenderer(Object.class, new CalendarCellRenderer());

        java.util.Calendar cal = java.util.Calendar.getInstance();
        moisActuel = cal.get(java.util.Calendar.MONTH) + 1;
        anneeActuelle = cal.get(java.util.Calendar.YEAR);

        mettreAJourMoisAnneeLabel();

        remplirCalendrier(moisActuel, anneeActuelle);

        rightPanel.add(new JScrollPane(calendrierTable), BorderLayout.CENTER);

        JTextArea eventsOfTheDay = new JTextArea();
        eventsOfTheDay.setEditable(false);
        rightPanel.add(new JScrollPane(eventsOfTheDay), BorderLayout.SOUTH);

        rightPanel.add(decompteLabel, BorderLayout.SOUTH);

        calendrierTable.getSelectionModel().addListSelectionListener(e -> {
            if (!e.getValueIsAdjusting()) {
                int ligne = calendrierTable.getSelectedRow();
                int colonne = calendrierTable.getSelectedColumn();
                Object valeur = calendrierTable.getValueAt(ligne, colonne);
                if (valeur != null && !valeur.toString().isEmpty()) {
                    int jour = Integer.parseInt(valeur.toString().replace("*", ""));
                    afficherEvenementsDuJour(jour, eventsOfTheDay);
                    lancerDecompte(jour);
                }
            }
        });

        add(leftPanel, BorderLayout.WEST);
        add(rightPanel, BorderLayout.CENTER);

        setLocationRelativeTo(null);
        toFront();
        setVisible(true);
    }

    private void lancerDecompte(int jour) {
        if (timer != null) {
            timer.stop();
        }

        timer = new Timer(1000, e -> {
            for (Evenement evenement : evenements) {
                java.util.Calendar eventDate = convertirEnCalendar(evenement.getDate());
                if (eventDate.get(java.util.Calendar.DAY_OF_MONTH) == jour &&
                    eventDate.get(java.util.Calendar.MONTH) + 1 == moisActuel &&
                    eventDate.get(java.util.Calendar.YEAR) == anneeActuelle) {
                    String dateHeureEvenement = evenement.getDate() + " " + evenement.getHeureDebut();
                    SimpleDateFormat format = new SimpleDateFormat("dd/MM/yyyy HH:mm");
                    try {
                        Date dateEvenement = format.parse(dateHeureEvenement);
                        Date maintenant = new Date();
                        long difference = dateEvenement.getTime() - maintenant.getTime();

                        long secondes = difference / 1000;
                        long minutes = secondes / 60;
                        long heures = minutes / 60;
                        long jours = heures / 24;

                        secondes %= 60;
                        minutes %= 60;
                        heures %= 24;

                        decompteLabel.setText("Décompte : " + jours + "j " + heures + "h " + minutes + "m " + secondes + "s");
                    } catch (ParseException ex) {
                        ex.printStackTrace();
                    }
                }
            }
        });
        timer.start();
    }

    private void mettreAJourMoisAnneeLabel() {
        String[] nomsMois = {"Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"};
        moisAnneeLabel.setText(nomsMois[moisActuel - 1] + " " + anneeActuelle);
    }

    private void remplirCalendrier(int mois, int annee) {
        for (int i = 0; i < 6; i++) {
            for (int j = 0; j < 7; j++) {
                calendrierTable.setValueAt("", i, j);
            }
        }

        java.util.Calendar cal = java.util.Calendar.getInstance();
        cal.set(annee, mois - 1, 1);
        int premierJour = cal.get(java.util.Calendar.DAY_OF_WEEK) - 1;

        int joursDansMois = cal.getActualMaximum(java.util.Calendar.DAY_OF_MONTH);
        int ligne = 0;
        int colonne = premierJour - 1;

        for (int jour = 1; jour <= joursDansMois; jour++) {
            if (hasEvenements(jour, mois, annee)) {
                calendrierTable.setValueAt("*" + jour, ligne, colonne);
            } else {
                calendrierTable.setValueAt(jour, ligne, colonne);
            }
            colonne++;
            if (colonne > 6) {
                colonne = 0;
                ligne++;
            }
        }
    }

    private void afficherEvenementsDuJour(int jour, JTextArea eventsOfTheDay) {
        StringBuilder sb = new StringBuilder();
        for (Evenement evenement : evenements) {
            java.util.Calendar eventDate = convertirEnCalendar(evenement.getDate());
            if (eventDate.get(java.util.Calendar.DAY_OF_MONTH) == jour &&
                eventDate.get(java.util.Calendar.MONTH) + 1 == moisActuel &&
                eventDate.get(java.util.Calendar.YEAR) == anneeActuelle) {
                sb.append(evenement.getNom()).append(" - ").append(evenement.getHeureDebut()).append(" à ").append(evenement.getHeureFin()).append("\n");
            }
        }
        eventsOfTheDay.setText(sb.toString());
    }

    private boolean hasEvenements(int jour, int mois, int annee) {
        for (Evenement evenement : evenements) {
            java.util.Calendar eventDate = convertirEnCalendar(evenement.getDate());
            if (eventDate.get(java.util.Calendar.DAY_OF_MONTH) == jour &&
                eventDate.get(java.util.Calendar.MONTH) + 1 == mois &&
                eventDate.get(java.util.Calendar.YEAR) == annee) {
                return true;
            }
        }
        return false;
    }

    private java.util.Calendar convertirEnCalendar(String dateStr) {
        java.util.Calendar calendar = java.util.Calendar.getInstance();
        try {
            String[] parts = dateStr.split("/");
            int day = Integer.parseInt(parts[0]);
            int month = Integer.parseInt(parts[1]) - 1;
            int year = Integer.parseInt(parts[2]);
            calendar.set(year, month, day);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return calendar;
    }

    private void ajouterEvenement() {
        JTextField nomField = new JTextField();
        JTextField dateField = new JTextField();
        JTextField heureDebutField = new JTextField();
        JTextField heureFinField = new JTextField();
        JTextArea descriptionArea = new JTextArea(5, 20);

        JPanel panel = new JPanel(new GridLayout(0, 1));
        panel.add(new JLabel("Nom :"));
        panel.add(nomField);
        panel.add(new JLabel("Date (jj/mm/aaaa) :"));
        panel.add(dateField);
        panel.add(new JLabel("Heure de début (hh:mm) :"));
        panel.add(heureDebutField);
        panel.add(new JLabel("Heure de fin (hh:mm) :"));
        panel.add(heureFinField);
        panel.add(new JLabel("Description :"));
        panel.add(new JScrollPane(descriptionArea));

        int result = JOptionPane.showConfirmDialog(this, panel, "Ajouter un événement", JOptionPane.OK_CANCEL_OPTION);
        if (result == JOptionPane.OK_OPTION) {
            Evenement evenement = new Evenement(
                nomField.getText(),
                dateField.getText(),
                heureDebutField.getText(),
                heureFinField.getText(),
                descriptionArea.getText()
            );
            evenements.add(evenement);

            modelTableEvenements.addRow(new Object[]{
                evenement.getNom(),
                evenement.getDate(),
                evenement.getHeureDebut(),
                evenement.getHeureFin()
            });

            remplirCalendrier(moisActuel, anneeActuelle);
        }
    }

    private void modifierEvenement() {
        int index = tableEvenements.getSelectedRow();
        if (index == -1) {
            JOptionPane.showMessageDialog(this, "Veuillez sélectionner un événement à modifier.", "Erreur", JOptionPane.ERROR_MESSAGE);
            return;
        }

        Evenement evenement = evenements.get(index);
        JTextField nomField = new JTextField(evenement.getNom());
        JTextField dateField = new JTextField(evenement.getDate());
        JTextField heureDebutField = new JTextField(evenement.getHeureDebut());
        JTextField heureFinField = new JTextField(evenement.getHeureFin());
        JTextArea descriptionArea = new JTextArea(evenement.getDescription(), 5, 20);

        JPanel panel = new JPanel(new GridLayout(0, 1));
        panel.add(new JLabel("Nom :"));
        panel.add(nomField);
        panel.add(new JLabel("Date (jj/mm/aaaa) :"));
        panel.add(dateField);
        panel.add(new JLabel("Heure de début (hh:mm) :"));
        panel.add(heureDebutField);
        panel.add(new JLabel("Heure de fin (hh:mm) :"));
        panel.add(heureFinField);
        panel.add(new JLabel("Description :"));
        panel.add(new JScrollPane(descriptionArea));

        int result = JOptionPane.showConfirmDialog(this, panel, "Modifier l'événement", JOptionPane.OK_CANCEL_OPTION);
        if (result == JOptionPane.OK_OPTION) {
            evenement.setNom(nomField.getText());
            evenement.setDate(dateField.getText());
            evenement.setHeureDebut(heureDebutField.getText());
            evenement.setHeureFin(heureFinField.getText());
            evenement.setDescription(descriptionArea.getText());

            modelTableEvenements.setValueAt(evenement.getNom(), index, 0);
            modelTableEvenements.setValueAt(evenement.getDate(), index, 1);
            modelTableEvenements.setValueAt(evenement.getHeureDebut(), index, 2);
            modelTableEvenements.setValueAt(evenement.getHeureFin(), index, 3);

            remplirCalendrier(moisActuel, anneeActuelle);
        }
    }

    private void supprimerEvenement() {
        int index = tableEvenements.getSelectedRow();
        if (index == -1) {
            JOptionPane.showMessageDialog(this, "Veuillez sélectionner un événement à supprimer.", "Erreur", JOptionPane.ERROR_MESSAGE);
            return;
        }
        evenements.remove(index);
        modelTableEvenements.removeRow(index);

        remplirCalendrier(moisActuel, anneeActuelle);

        JOptionPane.showMessageDialog(this, "Événement supprimé avec succès !", "Suppression", JOptionPane.INFORMATION_MESSAGE);
    }

    private void changerMois(int delta) {
        moisActuel += delta;
        if (moisActuel < 1) {
            moisActuel = 12;
            anneeActuelle--;
        } else if (moisActuel > 12) {
            moisActuel = 1;
            anneeActuelle++;
        }

        mettreAJourMoisAnneeLabel();

        remplirCalendrier(moisActuel, anneeActuelle);
    }

    private void sauvegarderEvenements() {
        try (ObjectOutputStream oos = new ObjectOutputStream(new FileOutputStream("evenements.dat"))) {
            oos.writeObject(evenements);
            JOptionPane.showMessageDialog(this, "Événements sauvegardés avec succès !", "Sauvegarde", JOptionPane.INFORMATION_MESSAGE);
        } catch (IOException e) {
            JOptionPane.showMessageDialog(this, "Erreur lors de la sauvegarde des événements.", "Erreur", JOptionPane.ERROR_MESSAGE);
        }
    }

    private void chargerEvenements() {
        try (ObjectInputStream ois = new ObjectInputStream(new FileInputStream("evenements.dat"))) {
            evenements = (List<Evenement>) ois.readObject();
            modelTableEvenements.setRowCount(0);
            for (Evenement evenement : evenements) {
                modelTableEvenements.addRow(new Object[]{
                    evenement.getNom(),
                    evenement.getDate(),
                    evenement.getHeureDebut(),
                    evenement.getHeureFin()
                });
            }
            JOptionPane.showMessageDialog(this, "Événements chargés avec succès !", "Chargement", JOptionPane.INFORMATION_MESSAGE);
        } catch (IOException | ClassNotFoundException e) {
            JOptionPane.showMessageDialog(this, "Erreur lors du chargement des événements.", "Erreur", JOptionPane.ERROR_MESSAGE);
        }
    }

    public static class Evenement implements Serializable {
        private String nom;
        private String date;
        private String heureDebut;
        private String heureFin;
        private String description;

        public Evenement(String nom, String date, String heureDebut, String heureFin, String description) {
            this.nom = nom;
            this.date = date;
            this.heureDebut = heureDebut;
            this.heureFin = heureFin;
            this.description = description;
        }

        public String getNom() { return nom; }
        public String getDate() { return date; }
        public String getHeureDebut() { return heureDebut; }
        public String getHeureFin() { return heureFin; }
        public String getDescription() { return description; }

        public void setNom(String nom) { this.nom = nom; }
        public void setDate(String date) { this.date = date; }
        public void setHeureDebut(String heureDebut) { this.heureDebut = heureDebut; }
        public void setHeureFin(String heureFin) { this.heureFin = heureFin; }
        public void setDescription(String description) { this.description = description; }
    }

    private static class CalendarCellRenderer extends DefaultTableCellRenderer {
        @Override
        public Component getTableCellRendererComponent(JTable table, Object value, boolean isSelected, boolean hasFocus, int row, int column) {
            Component c = super.getTableCellRendererComponent(table, value, isSelected, hasFocus, row, column);
            if (value != null && value.toString().startsWith("*")) {
                c.setBackground(Color.YELLOW);
            } else {
                c.setBackground(Color.WHITE);
            }
            return c;
        }
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> new EmploiDuTempsApp());
    }
}