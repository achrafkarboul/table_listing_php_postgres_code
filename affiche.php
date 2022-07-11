
<?php
include("connection.php");
class pdch {
    protected $conn;
    protected $data = array();
    function __construct() {

                    $db = new dbObj();
                    $connString =  $db->getConnstring();
                    $this->conn = $connString;
    } // fonction de connectuion à la base de données
   
    public function getpdchs() {
                    $sql = "SELECT * FROM pdch"; //requete
                    $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data"); // execution ou erreur
                    $data = pg_fetch_all($queryRecords); // retour de la requete sous forme tableau
                    return $data; //resultat
    } // fn qui exécute  une requête de select pour afficher la table pdch
    public function getId() {
        $a=$_GET['idB'];
        $sql = "select count(*) as resultat from pdch where id_pdch like '$a' ";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        $condition=pg_fetch_result($queryRecords,0,0);
        if($condition==false) {
            $sqll = "insert into pdch values('$a','stc001',' type_x','FR',0); ";
            $queryRecords = pg_query($this->conn, $sqll) or die("error to fetch pdchs data");
        }
        return $data;
    } // fn pour verifier si la pdch existe , sinon elle l'ajoute
    }

?>
