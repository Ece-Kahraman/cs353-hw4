import java.sql.*;

/*
    Ece Kahraman
    21801879
    CS353-001
    Java file to create owns, account, and customer tables and to populate them.
 */

public class Main {
    public static void main(String[] args) throws ClassNotFoundException, SQLException {


        Class.forName("org.mariadb.jdbc.Driver");
        Connection dbConnection = null;

        try {


            String url = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr:3306/ece_kahraman";
            String user = "ece.kahraman";
            String pwd = "lysYQe1I";

            dbConnection = DriverManager.getConnection(url, user, pwd);

            if (dbConnection != null) {
                System.out.println("Successfully connected to MySQL database test");
            }

        } catch (SQLException ex) {
            System.out.println("An error occurred while connecting MySQL database");
            ex.printStackTrace();
        }
        Statement statement = dbConnection.createStatement();
        statement.executeUpdate("DROP TABLE IF EXISTS owns");
        statement.executeUpdate("DROP TABLE IF EXISTS account");
        statement.executeUpdate("DROP TABLE IF EXISTS customer");

        statement.executeUpdate("CREATE TABLE customer(" +
                "cid CHAR(5)," +
                "name VARCHAR(30)," +
                "bdate DATE," +
                "address VARCHAR(30)," +
                "city VARCHAR(20)," +
                "nationality VARCHAR(20)," +
                "PRIMARY KEY(cid) ) ENGINE=InnoDB;");

        statement.executeUpdate("CREATE TABLE account(" +
                "aid CHAR(8)," +
                "branch VARCHAR(20)," +
                "balance FLOAT," +
                "openDate DATE," +
                "PRIMARY KEY(aid) ) ENGINE=InnoDB;");

        statement.executeUpdate("CREATE TABLE owns(" +
                "cid CHAR(5)," +
                "aid CHAR(8)," +
                "PRIMARY KEY(cid, aid)," +
                "FOREIGN KEY (cid) REFERENCES customer(cid)," +
                "FOREIGN KEY (aid) REFERENCES account(aid) ) ENGINE=InnoDB;");

        statement.executeUpdate("INSERT INTO customer VALUES " +
                "(10001, 'Ayse', '1990-09-08', 'Bilkent', 'Ankara', 'TC')," +
                "(10002, 'Ali', '1985-10-16', 'Sariyer', 'Istanbul', 'TC')," +
                "(10003, 'Ahmet', '1997-02-15', 'Karsiyaka', 'Izmir', 'TC')," +
                "(10004, 'John', '2003-04-16', 'Stretford', 'Manchester', 'UK')");


        statement.executeUpdate("INSERT INTO account VALUES " +
                "('A0000001', 'Kizilay', 5000.00, '2019-11-01')," +
                "('A0000002', 'Bilkent', 228000.00, '2011-01-05')," +
                "('A0000003', 'Cankaya', 432000.00, '2021-05-14')," +
                "('A0000004', 'Sincan', 10500.00, '2012-06-01')," +
                "('A0000005', 'Tandogan', 77800.00, '2013-03-20')," +
                "('A0000006', 'Eryaman', 25000.00, '2022-01-22')," +
                "('A0000007', 'Umitkoy', 25000.00, '2017-04-21');");

        statement.executeUpdate("INSERT INTO owns VALUES " +
                "(10001, 'A0000001')," +
                "(10001, 'A0000002')," +
                "(10001, 'A0000003')," +
                "(10001, 'A0000004')," +
                "(10002, 'A0000002')," +
                "(10002, 'A0000003')," +
                "(10002, 'A0000005')," +
                "(10003, 'A0000006')," +
                "(10003, 'A0000007')," +
                "(10004, 'A0000006');");
        dbConnection.close();
    }
}
