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
                        WHERE  chp_free=0 and chp_id in (select chp_id from chg_charges where current_timestamp-chg_start_date < interval '5 minute' )";
    $CHP_Non_Availabile = " UPDATE chp_charging_point
                            SET chp_free = 0
                            WHERE  chp_charging_point=0 and chp_id in (select chp_id from chg_charge where current_timestamp-chg_end_date < interval '5 minute' )";
    $a = pg_query($conn, $CHP_Non_Availabile);
    $b = pg_query($conn, $CHP_Availabile);

    sleep(300); // repot tt les 5 min
}
// resultat : excution tt les 5 min
?>