create table owr_owner
(
    owr_id   varchar(20) not null
        constraint borne_pkey
            primary key,
    owr_name varchar(20)
);

create table csi_charging_site
(
    csi_id   varchar(20) not null
        constraint station_pkey
            primary key,
    owr_id   varchar(20) not null
        constraint fk_site_client_prop
            references owr_owner,
    csi_name varchar(50) not null
);


create table stc_charging_station
(
    stc_id        varchar(20) not null
        constraint stc_pkey
            primary key,
    csi_id        varchar(20) not null
        constraint fk_station_site_client
            references csi_charging_site,
    constructeur  varchar(20) not null,
    stc_max_power integer     not null,
    stc_location  varchar(50)
);



create table log_logs
(
    log_id   integer default nextval(''logs_id_logs_seq''::regclass) not null
        constraint logs_pkey
            primary key,
    stc_id   varchar(20)                                             not null
        constraint fk_logs_stc
            references stc_charging_station,
    lod_date date    default CURRENT_TIMESTAMP(3),
    log_msg  text
);



create table cli_client
(
    cli_id            varchar(20) not null
        constraint client_pkey
            primary key,
    cli_last_name     varchar(50),
    cli_first_name    varchar(50),
    cli_id_vehicle    varchar(20),
    cli_vehicle_model varchar(20),
    cli_bat_capacity  integer,
    cli_nominal_range integer
);



create table cnt_country
(
    cnt_id       varchar(4) not null
        constraint fk_policies
            primary key,
    cnt_label    varchar(20),
    cnt_prefixe  varchar(4),
    cnt_language varchar(3)
);



create table chp_charging_point
(
    chp_id         varchar(20) not null
        constraint pdch_pkey
            primary key,
    stc_id         varchar(20) default NULL:: character varying
        constraint fk_pdch_stc
        references stc_charging_station,
    chp_plug_type  varchar,
    cnt_id         varchar(4)  default NULL:: character varying
        constraint fk_pays_pdch
        references cnt_country,
    chp_nb_cars_id integer
);



create table chg_charges
(
    cli_id              varchar(20)              not null
        constraint fk_client_charges
            references cli_client,
    chp_id              varchar(20)              not null
        constraint fk_charges_pdch
            references chp_charging_point,
    chg_start_date      timestamp with time zone not null,
    chg_end_date        timestamp with time zone,
    chg_provided_energy integer                  not null,
    chg_reservation     integer
        constraint chk_binaire
            check (chg_reservation = ANY (ARRAY[0, 1])),
    constraint charges_pkey
        primary key (cli_id, chp_id, chg_start_date)
);



create table plc_policies
(
    plc_id            varchar(20) not null
        constraint pk_policies
            primary key,
    csi_id            varchar(20) not null
        constraint fk_site_client_policies
            references csi_charging_site,
    plc_free_duration integer,
    plc_max_duration  integer     not null,
    plc_nb_chrg_day   integer     not null,
    plc_cost_kwh      integer     not null,
    plc_label         varchar(20),
    plc_start_date    timestamp,
    plc_end_date      timestamp,
    plc_top_default   integer
        constraint chk_binaire
            check (plc_top_default = ANY (ARRAY[0, 1]))
);



create table crd_card
(
    crd_id varchar(20) not null
        constraint pk_carte
            primary key,
    plc_id varchar(20)
        constraint fk_carte_policies
            references plc_policies,
    cli_id varchar(20)
        constraint fk_carte_client
            references cli_client
);
alter table owr_owner
    owner to akuvitpostgresql;
alter table csi_charging_site
    owner to akuvitpostgresql;
alter table stc_charging_station
    owner to akuvitpostgresql;
alter table log_logs
    owner to akuvitpostgresql;
alter sequence logs_id_logs_seq owned by log_logs.log_id;
alter table cli_client
    owner to akuvitpostgresql;
alter table cnt_country
    owner to akuvitpostgresql;
alter table chp_charging_point
    owner to akuvitpostgresql;
alter table chg_charges
    owner to akuvitpostgresql;
alter table plc_policies
    owner to akuvitpostgresql;
alter table crd_card
    owner to akuvitpostgresql;

