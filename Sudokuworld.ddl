-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 20 2021              
-- * Generation date: Fri Jan 10 15:23:59 2025 
-- * LUN file: /home/davide/Desktop/unibo/web/Sudokuworld/Sudokuworld.lun 
-- * Schema: SUDOKUWORLD/1-1 
-- ********************************************* 


-- Database Section
-- ________________ 

create database SUDOKUWORLD;
use SUDOKUWORLD;


-- Tables Section
-- _____________ 

create table CART (
     id_product int not null,
     email varchar(64) not null,
     constraint ID_CART_ID primary key (id_product, email));

create table CATEGORY (
     category_tag varchar(32) not null,
     constraint ID_CATEGORY_ID primary key (category_tag));

create table CREDIT_CARD (
     email varchar(64) not null,
     number varchar(16) not null,
     name varchar(32) not null,
     surname varchar(32) not null,
     expiration date not null,
     constraint ID_CREDIT_CARD_ID primary key (email, number));

create table NOTIFICATION (
     id_notification int not null auto_increment,
     title varchar(32) not null,
     day date not null,
     seen char not null,
     description varchar(1024) not null,
     email varchar(64) not null,
     constraint ID_NOTIFICATION_ID primary key (id_notification));

create table ORDERS (
     id_order int not null auto_increment,
     day date not null,
     price int not null,
     email varchar(64) not null,
     constraint ID_ORDERS_ID primary key (id_order));

create table PRODUCT (
     id_product int not null auto_increment,
     name varchar(128) not null,
     description varchar(1024) not null,
     price int not null,
     image varchar(128) not null,
     discount int not null,
     availability int not null,
     removed char not null,
     email varchar(64) not null,
     category_tag varchar(32) not null,
     constraint ID_PRODUCT_ID primary key (id_product));

create table SUDOKU (
     day date not null,
     grid varchar(128) not null,
     solution varchar(128) not null,
     constraint ID_SUDOKU_ID primary key (day));

create table ORDERS_ITEM (
     id_order int not null,
     id_product int not null,
     quantity char(1) not null,
     constraint ID_ORDERS_ITEM_ID primary key (id_order, id_product));

create table USER (
     name varchar(32) not null,
     email varchar(64) not null,
     password varchar(256) not null,
     seller char not null,
     constraint ID_USER_ID primary key (email));

create table WINS (
     day date not null,
     email varchar(64) not null,
     constraint ID_WINS_ID primary key (day, email));

create table WISHES (
     id_product int not null,
     email varchar(64) not null,
     constraint ID_WISHES_ID primary key (id_product, email));


-- Constraints Section
-- ___________________ 

alter table CART add constraint FKCAR_USE_FK
     foreign key (email)
     references USER (email);

alter table CART add constraint FKCAR_PRO
     foreign key (id_product)
     references PRODUCT (id_product);

alter table CREDIT_CARD add constraint FKOWNS
     foreign key (email)
     references USER (email);

alter table NOTIFICATION add constraint FKHAS_FK
     foreign key (email)
     references USER (email);

-- Not implemented
-- alter table ORDERS add constraint ID_ORDERS_CHK
--     check(exists(select * from ORDERS_ITEM
--                  where ORDERS_ITEM.id_order = id_order)); 

alter table ORDERS add constraint FKORDERS_FK
     foreign key (email)
     references USER (email);

alter table PRODUCT add constraint FKSELLS_FK
     foreign key (email)
     references USER (email);

alter table PRODUCT add constraint FKIS_CATEGORY_FK
     foreign key (category_tag)
     references CATEGORY (category_tag);

alter table ORDERS_ITEM add constraint FKORD_PRO_FK
     foreign key (id_product)
     references PRODUCT (id_product);

alter table ORDERS_ITEM add constraint FKORD_ORD
     foreign key (id_order)
     references ORDERS (id_order);

alter table WINS add constraint FKWIN_USE_FK
     foreign key (email)
     references USER (email);

alter table WINS add constraint FKWIN_SUD
     foreign key (day)
     references SUDOKU (day);

alter table WISHES add constraint FKWIS_USE_FK
     foreign key (email)
     references USER (email);

alter table WISHES add constraint FKWIS_PRO
     foreign key (id_product)
     references PRODUCT (id_product);


-- Index Section
-- _____________ 

create unique index ID_CART_IND
     on CART (id_product, email);

create index FKCAR_USE_IND
     on CART (email);

create unique index ID_CATEGORY_IND
     on CATEGORY (category_tag);

create unique index ID_CREDIT_CARD_IND
     on CREDIT_CARD (email, number);

create unique index ID_NOTIFICATION_IND
     on NOTIFICATION (id_notification);

create index FKHAS_IND
     on NOTIFICATION (email);

create unique index ID_ORDERS_IND
     on ORDERS (id_order);

create index FKORDERS_IND
     on ORDERS (email);

create unique index ID_PRODUCT_IND
     on PRODUCT (id_product);

create index FKSELLS_IND
     on PRODUCT (email);

create index FKIS_CATEGORY_IND
     on PRODUCT (category_tag);

create unique index ID_SUDOKU_IND
     on SUDOKU (day);

create unique index ID_ORDERS_ITEM_IND
     on ORDERS_ITEM (id_order, id_product);

create index FKORD_PRO_IND
     on ORDERS_ITEM (id_product);

create unique index ID_USER_IND
     on USER (email);

create unique index ID_WINS_IND
     on WINS (day, email);

create index FKWIN_USE_IND
     on WINS (email);

create unique index ID_WISHES_IND
     on WISHES (id_product, email);

create index FKWIS_USE_IND
     on WISHES (email);

