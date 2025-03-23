
import javax.swing.*;

public class TestApp extends JFrame {
    public TestApp() {
        setTitle("Test Application");
        setSize(400, 300);
        setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        setVisible(true);
    }

    public static void main(String[] args) {
        SwingUtilities.invokeLater(() -> new TestApp());
    }
}