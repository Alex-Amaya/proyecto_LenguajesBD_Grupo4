import java.sql.*;

public class ConexionDB {
    private static final String URL = "jdbc:oracle:thin:@localhost:1521:orcl"; // Cambia según tu configuración
    private static final String USUARIO = "JuanP";
    private static final String PASSWORD = "Fide123";

    public static Connection conectar() throws SQLException {
        return DriverManager.getConnection(URL, USUARIO, PASSWORD);
    }

    public static boolean validarUsuario(String user, String pass) {
        String query = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
        try (Connection conn = conectar();
             PreparedStatement stmt = conn.prepareStatement(query)) {

            stmt.setString(1, user);
            stmt.setString(2, pass);

            ResultSet rs = stmt.executeQuery();
            return rs.next(); 
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }
}
