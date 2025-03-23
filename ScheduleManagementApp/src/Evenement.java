
public class Evenement {
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
    public void setNom(String nom) { this.nom = nom; }

    public String getDate() { return date; }
    public void setDate(String date) { this.date = date; }

    public String getHeureDebut() { return heureDebut; }
    public void setHeureDebut(String heureDebut) { this.heureDebut = heureDebut; }

    public String getHeureFin() { return heureFin; }
    public void setHeureFin(String heureFin) { this.heureFin = heureFin; }

    public String getDescription() { return description; }
    public void setDescription(String description) { this.description = description; }

    @Override
    public String toString() {
        return nom + " - " + date + " - " + heureDebut;
    }
}
