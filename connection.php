<?php

class dbObj
{
    /* Database connection start */
    var $servername = "dj859422-001.eu.clouddb.ovh.net";
    var $username = "rchrgme_rwd";
    var $password = "Pwd2DbSvc4Actions";
    var $dbname = "rpwr_dev";
    var $port = "35882";
    var $conn;

    function getConnstring()
    {
        $con = pg_connect("host=" . $this->servername . " port=" . $this->port . " dbname=" . $this->dbname . " user=" . $this->username . " password=" . $this->password . "") or die("Connection failed: " . pg_last_error());

        /* check connection */
        if (pg_last_error()) {
            printf("Connect failed: %s\n", pg_last_error());
            exit();
        } else {
            $this->conn = $con;
        }
        return $this->conn;
    }
}

?>
