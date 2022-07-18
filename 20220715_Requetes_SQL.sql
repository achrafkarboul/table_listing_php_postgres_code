-- Enregistrement
Select plc.plc_free_duration as free_duration,
		plc.plc_max_duration as Max_Duration,
		plc.plc_Nb_Chrg_Day as Nb_Chrg_Day
From chp_charging_point chp
		Inner Join stc_charging_station stc On stc.stc_id = chp.stc_id
		Inner Join plc_policies plc On plc.csi_id = stc.csi_id
Where chp.chp_id = 'pdch008';

-- Textes pour les messages
Select msg_code as Code, msg_label as Label
From msg_app_msgs
Where msg_language=(Select chp_language From chp_charging_point where chp_id = "ID passé en paramètre");


-- Mise à jour du statut vers disponible
Update chp_charging_point Set chp_free=1 Where chp_id = 'ID passé en paramètre';

-- Mise à jour du statut vers indisponible
Update chp_charging_point Set chp_free=0 Where chp_id = 'ID passé en paramètre';

-- Renvoi du prochain client et temps avant la prochaine charge
Select cli_id as ID_Client, extract(epoch from (chg_start_date - Now())) As Start_Into
From chg_charges
Where chp_id = 'ID point de charge passé en paramètre'
And chg_start_date > Now()
And chg_reservation = 1
Order by chg_start_date Asc  LIMIT 1;

-- Vérifie si le client existe
Select 1 from cli_client where cli_id = 'ID passé en paramètre';

-- Vérifie si le client peut charger : la requette ci-dessous ne doit renvoyer aucune ligne
Select chg.cli_id, count(*) As Nb_Charges
From chg_charges chg
		Inner Join chp_charging_point chp On chp.chp_id = chg.chp_id
		Inner Join stc_charging_station stc On stc.stc_id = chp.stc_id
		Inner Join plc_policies plc On plc.csi_id = stc.csi_id
Where chg.cli_id = 'ID client passé en paramètre'
And chg.chp_id =' "ID borne passé en paramètre"'
And DATE_PART('day', Now() - chg.chg_start_date) = 0
And chg_reservation = 0
Group By chg.cli_id, plc.plc_Nb_Chrg_day
Having Count(*)>= plc.plc_Nb_Chrg_day;

--Vérifie la dispo d'autres bornes du même site et en renvoie deux
Select  chp.chp_code As Code, chp.chp_id As Numero
From chp_charging_point chp
		Inner Join stc_charging_station stc On stc.stc_id = chp.stc_id
		Inner Join stc_charging_station OtherStc On OtherStc.csi_id = stc.csi_id 
		Inner Join chp_charging_point chpavlb On chpavlb.stc_id = OtherStc.stc_id
Where chp.chp_id = 'ID borne passé en paramètre'
And OtherStc.stc_id <> stc.stc_id
And chpavlb.chp_free = 1
limit 2 ;

