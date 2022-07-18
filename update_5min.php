<?php
include("connection.php");

set_time_limit(0); // tourne à vie
while (true) {
    $data = array();
    $db = new dbObj();
    $connString = $db->getConnstring();
    $conn = $connString;
    $is_charging = array(); // tableau qui contient les
    $CHP_Availabile = " UPDATE chp_charging_point
                        SET chp_free = 1
                        WHERE  chp_free=0 
                            and chp_id in ( select chp_id
                                            from chg_charges
                                            where current_timestamp - chg_start_date < interval '5 minute';)"
                        ;
    $CHP_Non_Availabile = " UPDATE chp_charging_point
                            SET chp_free = 0
                            WHERE  chp_free=1 and chp_id in (select chp_id from chg_charges where current_timestamp-chg_end_date < interval '5 minute' )";
    $arduino_read = $_GET['courant'];
    $arduino_chg_id = $_GET['arduino'];
    $CHG_Consumption = "UPDATE chg_charges
SET chg_provided_energy=((chg_provided_energy*1000) + ($arduino_read*2000/60))/1000
WHERE chg_reservation = 0
  and chg_end_date is  NULL;
and chp_id=$arduino_chg_id";
    $a = pg_query($conn, $CHP_Non_Availabile);
    $b = pg_query($conn, $CHP_Availabile);

    sleep(300); // repot tt les 5 min
}
// resultat : excution tt les 5 min
?>