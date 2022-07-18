<?php
include("connection.php");

class pdch
{
    protected $conn;
    protected $data = array();

    function __construct()
    {

        $db = new dbObj();
        $connString = $db->getConnstring();
        $this->conn = $connString;
    } // fonction de connectuion à la base de données

    public function getpdchs()
    {
        $sql = "SELECT * FROM chp_charging_point "; //requete
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data"); // execution ou erreur
        $data = pg_fetch_all($queryRecords); // retour de la requete sous forme tableau
        return $data; //resultat
    } // fn qui exécute  une requête de select pour afficher la table pdch

    public function getId()
    {
        $a = $_GET['idB'];
        $sql = "select count(*) as resultat from chp_charging_point where chp_id like '$a' ";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        $condition = pg_fetch_result($queryRecords, 0, 0);
        if ($condition == false) {
            $sqll = "insert into chp_charging_point values  ('$a',	3,	'BORNE FREE',	'T2',22,	1,	'33',	11,	'FR') ";
            $queryRecords = pg_query($this->conn, $sqll) or die("error to fetch pdchs data");
        }
        return $data;
    } // fn pour verifier si la pdch existe , sinon elle l'ajoute

    public function RQT_Available()  // retourne 0 si la borne est indisponible , >0 sinon ,
    {
        $chp = $_GET['idB'];
        $sql = "select count(*)>0
                    from chg_charges
                where not exists(select * from chg_charges where chp_id='pdch006' ) or
        ((chp_id like 'pdch006')
        and ((chg_end_date is not null )
        or ((chg_start_date - current_timestamp) > interval '20 minute')and chg_reservation = 1));";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        return $data;
    }

    public function RQT_Charge()
    {
        $client = $_GET['cli_id'];
        $chp = $_GET['idB'];
        $date = $_GET['date'];
        $currentDateTime = date('Y-m-d H:i:s');
        $select="select count(*) from chg_charges where cli_id=$client and chp_id=$chp and chg_start_date=$date and chg_reservation=1";
        $res = pg_query($this->conn, $select) or die("error to fetch pdchs data");
        if ( $res=1 )
        {
            $sql = "update chg_charges set chg_reservation=1, chg_start_date=$currentDateTime,chg_end_date=($date+interval(20 'minute')) where cli_id=$client and chp_id=$chp and chg_start_date=$date and chg_reservation=1 ";

        }
        else
            $sql = "INSERT INTO  chg_charges values('$client','$chp','$date',null,0,0) ; ";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        return $data;
    }

    public function isCharging()
    {
        $client = $_GET['cli_id'];
        $chp = $_GET['idB'];
        $date = $_GET['date'];
        $sql = "SELECT (DATE_PART('day', now() - chg_start_date) * 24 +
                        DATE_PART('hour', now() - chg_start_date)) * 3600 +
                        DATE_PART('minute', now() - chg_start_date) * 60 + DATE_PART('second', now() - chg_start_date)<30 as time
                from chg_charges
                where chp_id = '$chp'
                    and cli_id = '$client' 
                    and CONVERT(DATE, '$date') = CONVERT(DATE, getdate(); ";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        return $data;
    }

    public function UserProposeNotification()  // retourne 0 si la borne est indisponible , >0 sinon ,
    {
        $chp = $_GET['idB'];
        if (RQT_Available() == false)
            $sql = "select final.pdch
from chg_charges chg,
     (select chp.chp_id as pdch
      from chp_charging_point chp,
           (select stc.stc_id
            from chp_charging_point chp,
                 stc_charging_station stc
            where chp_id = 'pdch008'
              and chp.stc_id = stc.stc_id) as result
      where chp.stc_id = result.stc_id) as final
where   not exists(select * from chg_charges where chp_id=final.pdch ) or
    ((chp_id = final.pdch)
        and ((chg_end_date is not null )
            or ((chg_start_date - current_timestamp) > interval '20 minute')and chg_reservation = 1))
group by final.pdch";
        $queryRecords = pg_query($this->conn, $sql) or die("error to fetch pdchs data");
        $data = pg_fetch_all($queryRecords);
        return $data;
    }

}


?>
