select count(*) > 0
from chg_charges
where not exists(select * from chg_charges where chp_id = 'pdch006')
   or ((chp_id like 'pdch006')
    and ((chg_end_date is not null)
        or ((chg_start_date - current_timestamp) > interval '20 minute') and chg_reservation = 1));

select *
from chg_charges
;



select chp.chp_id as pdch
from chp_charging_point chp,
     (select stc.stc_id
      from chp_charging_point chp,
           stc_charging_station stc
      where chp_id = 'pdch008'
        and chp.stc_id = stc.stc_id) as result
where chp.stc_id = result.stc_id;

select final.pdch
from chg_charges chg,
     (select chp.chp_id as pdch
      from chp_charging_point chp,
           (select stc.stc_id
            from chp_charging_point chp,
                 stc_charging_station stc
            where chp_id = 'pdch008'
              and chp.stc_id = stc.stc_id) as result
      where chp.stc_id = result.stc_id) as final
where not exists(select * from chg_charges where chp_id = final.pdch)
   or ((chp_id = final.pdch)
    and ((chg_end_date is not null)
        or ((chg_start_date - current_timestamp) > interval '20 minute') and chg_reservation = 1))
group by final.pdch;


select current_timestamp, chg_start_date, chg_start_date - current_timestamp
from chg_charges
where chp_id = 'pdch008';


select count(*) > 0
from chg_charges
where not exists(select * from chg_charges where chp_id = 'pdch008')
   or ((chp_id like 'pdch008')
    and ((chg_end_date is not null)
        or ((chg_start_date - current_timestamp) > interval '20 minute') and chg_reservation = 1));