<?php

/* Database connection start */

$servername = "akuvitpostgresql.postgres.database.azure.com";
$username = "akuvitpostgresql@akuvitpostgresql";
$password = "Achrafkarboul123456";
$dbname = "akuvitBD";
$port = "5432";

//connexion  à la " Database " 
$con = pg_connect("host=" . $servername . " port=" . $port . " dbname=" . $dbname . " user=" . $username . " password=" . $password . "") or die("Connection failed=> " . pg_last_error());


// vérification de la connexion 
if (pg_last_error()) {
    printf("Connect failed=> %s\n", pg_last_error());
    exit();
} else {
    printf("connection ok ");
}


//get the id send by arduino 
$para = 'pdch001';


// image sur la page verification : 
//echo "<br>";
//echo $para; 
//echo "<br>";


//verifier si l'id excite ou non 
$a = pg_query("SELECT chp_id , stc_id   FROM chp_charging_point WHERE chp_id= '$para'");
$row = pg_fetch_array($a);
//echo "<br>";
$chp_id = $row[0]; // id de la carte arduino
$stc_id = $row[1]; // id de la site de recharge qui convient


//printf ($chp_id);
//echo "<br>";

//vérification de l'existence de l'id 

if ($chp_id != "") { //echo " exicte" ;
    //variable  
    $b = pg_query("SELECT csi_id FROM stc_charging_station WHERE stc_id='$stc_id' ");
    $bb = pg_fetch_array($b);

    $csi_id = $bb[0];
    // echo "<br>";
    //printf ($csi_id ) ;
    //echo "<br>";

    //echo "Test de récupération de données à envoyer" ;


    $bbb = pg_query("SELECT  plc_free_duration ,plc_max_duration ,plc_Nb_Chrg_day FROM plc_policies  WHERE csi_id= '$csi_id'");

    $row1 = pg_fetch_array($bbb);

    $plc_free_duration = $row1[0];
    $plc_max_duration = $row1[1];
    $plc_Nb_Chrg_day = $row1[2];

    // messages selon la lang

    $data0 = array("msg_code" => "RQT_Available", "value" => "Libellé du message pour la langue de l’indicatif \n");
    $data1 = array("msg_code" => "RQT_Notify", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data2 = array("msg_code" => "RQT_change", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data3 = array("msg_code" => "RQT_Status", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data4 = array("msg_code" => "RQT_Stop", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data5 = array("msg_code" => "RQT_thanks", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data6 = array("msg_code" => "RQT_Help", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data7 = array("msg_code" => "ASWR_Help", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data8 = array("msg_code" => "ASWR_Hello", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data9 = array("msg_code" => "ASWR_Welcome", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data10 = array("msg_code" => "ASWR_AskFORCharge", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data11 = array("msg_code" => "ASWR_StationUnavailable", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data12 = array("msg_code" => "ASWR_StationAvaible", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data13 = array("msg_code" => "ASWR_UserBotCharging", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data14 = array("msg_code" => "ASWR_UserProposeNotification", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data15 = array("msg_code" => "ASWR_UserCharging", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data16 = array("msg_code" => "ASWR_TryLater", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data17 = array("msg_code" => "ASWR_BadContent", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data18 = array("msg_code" => "ASWR_RequestCode", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data19 = array("msg_code" => "ASWR_DelayExpiredToConfirm", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data20 = array("msg_code" => "ASWR_ConfirmCharge", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data21 = array("msg_code" => "ASWR_ConfirmStopCharge", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data22 = array("msg_code" => "ASWR_EndOfCharge", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data23 = array("msg_code" => "ASWR_ConfirmRequestNotification", "value" => "Libellé du message pour la langue de l’indicatif\n");
    $data24 = array("msg_code" => "TooManyToNotify", "value" => "Libellé du message pour la langue de l’indicatif\n");


    // data

    $data = array("chp_code" => $chp_id, "plc_free_duration" => $plc_free_duration, "plc_max_duration" => $plc_max_duration, "plc_Nb_Chrg_day" => $plc_Nb_Chrg_day, "msgs" => [$data0, $data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9, $data10, $data11, $data12, $data13, $data14, $data15, $data16, $data17, $data18, $data19, $data20, $data21, $data22, $data23, $data24]);


    // encode json

    header("Content-Type=> application/json");
    echo json_encode($data);
    exit();

} else {
    echo "not exicte";
    // Étude de cas en cours
}
?>