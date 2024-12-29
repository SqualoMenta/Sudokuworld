-- *********************************************
-- * SQL MySQL generation                      
-- *--------------------------------------------
-- * DB-MAIN version: 11.0.2              
-- * Generator date: Sep 20 2021              
-- * Generation date: Sat Dec 28 15:12:08 2024 
-- * LUN file: /home/davide/Desktop/unibo/web/Sudokuworld/Sudokuworld.lun 
-- * Schema: SUDOKUWORLD/1-1 
-- ********************************************* 
-- Database Section
-- ________________ 
drop database if exists SUDOKUWORLD;
create database SUDOKUWORLD;
use SUDOKUWORLD;
-- Tables Section
-- _____________ 
create table CART (
    id_product int not null,
    email varchar(64) not null,
    constraint ID_CART_ID primary key (id_product, email)
);
create table CATEGORY (
    tag varchar(32) not null,
    constraint ID_CATEGORY_ID primary key (tag)
);
create table COLOR (
    color varchar(32) not null,
    constraint ID_COLOR_ID primary key (color)
);
create table CREDIT_CARD (
    email varchar(64) not null,
    number varchar(16) not null,
    propretary_name varchar(32) not null,
    propertary_surname varchar(32) not null,
    expiration date not null,
    constraint ID_CREDIT_CARD_ID primary key (email, number)
);
create table DAY (
    day date not null,
    constraint ID_DAY_ID primary key (day)
);
create table DIMESION (
    id_product int not null,
    tag varchar(8) not null,
    constraint ID_DIMESION_ID primary key (id_product, tag)
);
create table DISCOUNT (
    percentage int not null,
    id_discount int not null auto_increment,
    constraint ID_DISCOUNT_ID primary key (id_discount)
);
create table DISCOUNTS (
    id_discount int not null,
    id_product int not null,
    constraint ID_DISCOUNTS_ID primary key (id_product, id_discount)
);
create table IS_CATEGORY (
    tag varchar(32) not null,
    id_product int not null,
    constraint ID_IS_CATEGORY_ID primary key (tag, id_product)
);
create table IS_COLOR (
    color varchar(32) not null,
    id_product int not null,
    constraint ID_IS_COLOR_ID primary key (color, id_product)
);
create table LIVES (
    cap char(1) not null,
    street char(1) not null,
    civic char(1) not null,
    email varchar(64) not null,
    constraint ID_LIVES_ID primary key (cap, street, civic, email)
);
create table NOTIFY (
    id_notify int not null,
    title varchar(32) not null,
    day date not null,
    seen char not null,
    description varchar(1024) not null,
    email varchar(64) not null,
    constraint ID_NOTIFY_ID primary key (id_notify)
);
create table ORDERS (
    id_order int not null auto_increment,
    day char(1) not null,
    cap char(1) not null,
    street char(1) not null,
    civic char(1) not null,
    email varchar(64) not null,
    constraint ID_ORDERS_ID primary key (id_order)
);
create table ORDERS_ITEM (
    id_order int not null,
    id_product int not null,
    constraint ID_ORDERS_ITEM_ID primary key (id_order, id_product)
);
create table PLACE (
    cap char(1) not null,
    city char(1) not null,
    street char(1) not null,
    civic char(1) not null,
    constraint ID_PLACE_ID primary key (cap, street, civic)
);
create table PRODUCT (
    id_product int not null auto_increment,
    name varchar(128) not null,
    description varchar(1024) not null,
    price int not null,
    Image varchar(128) not null,
    email varchar(64) not null,
    constraint ID_PRODUCT_ID primary key (id_product)
);
create table SIZE (
    tag varchar(8) not null,
    constraint ID_SIZE_ID primary key (tag)
);
create table SUDOKU (
    id_sudoku int not null auto_increment,
    day date not null,
    grid varchar(128) not null,
    solution varchar(128) not null,
    constraint ID_SUDOKU_ID primary key (id_sudoku),
    constraint FKLINKED_ID unique (day)
);
create table USER (
    name varchar(32) not null,
    email varchar(64) not null,
    password varchar(256) not null,
    seller boolean not null,
    constraint ID_USER_ID primary key (email)
);
create table WINS (
    day date not null,
    email varchar(64) not null,
    constraint ID_WINS_ID primary key (day, email)
);
create table WISHES (
    id_product int not null,
    email varchar(64) not null,
    constraint ID_WISHES_ID primary key (id_product, email)
);
-- Constraints Section
-- ___________________ 
alter table CART
add constraint FKCAR_USE_FK foreign key (email) references USER (email);
alter table CART
add constraint FKCAR_PRO foreign key (id_product) references PRODUCT (id_product);
alter table CREDIT_CARD
add constraint FKOWNS foreign key (email) references USER (email);
-- Not implemented
-- alter table DAY add constraint ID_DAY_CHK
--     check(exists(select * from SUDOKU
--                  where SUDOKU.day = day)); 
alter table DIMESION
add constraint FKDIM_SIZ_FK foreign key (tag) references SIZE (tag);
alter table DIMESION
add constraint FKDIM_PRO foreign key (id_product) references PRODUCT (id_product);
alter table DISCOUNTS
add constraint FKDIS_PRO foreign key (id_product) references PRODUCT (id_product);
alter table DISCOUNTS
add constraint FKDIS_DIS_FK foreign key (id_discount) references DISCOUNT (id_discount);
alter table IS_CATEGORY
add constraint FKIS__PRO_1_FK foreign key (id_product) references PRODUCT (id_product);
alter table IS_CATEGORY
add constraint FKIS__CAT foreign key (tag) references CATEGORY (tag);
alter table IS_COLOR
add constraint FKIS__PRO_FK foreign key (id_product) references PRODUCT (id_product);
alter table IS_COLOR
add constraint FKIS__COL foreign key (color) references COLOR (color);
alter table LIVES
add constraint FKLIV_USE_FK foreign key (email) references USER (email);
alter table LIVES
add constraint FKLIV_PLA foreign key (cap, street, civic) references PLACE (cap, street, civic);
alter table NOTIFY
add constraint FKHAS_FK foreign key (email) references USER (email);
-- Not implemented
-- alter table ORDERS add constraint ID_ORDERS_CHK
--     check(exists(select * from ORDERS_ITEM
--                  where ORDERS_ITEM.id_order = id_order)); 
alter table ORDERS
add constraint FKSHIPPED_FK foreign key (cap, street, civic) references PLACE (cap, street, civic);
alter table ORDERS
add constraint FKORDERS_FK foreign key (email) references USER (email);
alter table ORDERS_ITEM
add constraint FKORD_PRO_FK foreign key (id_product) references PRODUCT (id_product);
alter table ORDERS_ITEM
add constraint FKORD_ORD foreign key (id_order) references ORDERS (id_order);
-- Not implemented
-- alter table PRODUCT add constraint ID_PRODUCT_CHK
--     check(exists(select * from IS_CATEGORY
--                  where IS_CATEGORY.id_product = id_product)); 
alter table PRODUCT
add constraint FKSELLS_FK foreign key (email) references USER (email);
alter table SUDOKU
add constraint FKLINKED_FK foreign key (day) references DAY (day);
alter table WINS
add constraint FKWIN_USE_FK foreign key (email) references USER (email);
alter table WINS
add constraint FKWIN_DAY foreign key (day) references DAY (day);
alter table WISHES
add constraint FKWIS_USE_FK foreign key (email) references USER (email);
alter table WISHES
add constraint FKWIS_PRO foreign key (id_product) references PRODUCT (id_product);
-- Index Section
-- _____________ 
create unique index ID_CART_IND on CART (id_product, email);
create index FKCAR_USE_IND on CART (email);
create unique index ID_CATEGORY_IND on CATEGORY (tag);
create unique index ID_COLOR_IND on COLOR (color);
create unique index ID_CREDIT_CARD_IND on CREDIT_CARD (email, number);
create unique index ID_DAY_IND on DAY (day);
create unique index ID_DIMESION_IND on DIMESION (id_product, tag);
create index FKDIM_SIZ_IND on DIMESION (tag);
create unique index ID_DISCOUNT_IND on DISCOUNT (id_discount);
create unique index ID_DISCOUNTS_IND on DISCOUNTS (id_product, id_discount);
create index FKDIS_DIS_IND on DISCOUNTS (id_discount);
create unique index ID_IS_CATEGORY_IND on IS_CATEGORY (tag, id_product);
create index FKIS__PRO_1_IND on IS_CATEGORY (id_product);
create unique index ID_IS_COLOR_IND on IS_COLOR (color, id_product);
create index FKIS__PRO_IND on IS_COLOR (id_product);
create unique index ID_LIVES_IND on LIVES (cap, street, civic, email);
create index FKLIV_USE_IND on LIVES (email);
create unique index ID_NOTIFY_IND on NOTIFY (id_notify);
create index FKHAS_IND on NOTIFY (email);
create unique index ID_ORDERS_IND on ORDERS (id_order);
create index FKSHIPPED_IND on ORDERS (cap, street, civic);
create index FKORDERS_IND on ORDERS (email);
create unique index ID_ORDERS_ITEM_IND on ORDERS_ITEM (id_order, id_product);
create index FKORD_PRO_IND on ORDERS_ITEM (id_product);
create unique index ID_PLACE_IND on PLACE (cap, street, civic);
create unique index ID_PRODUCT_IND on PRODUCT (id_product);
create index FKSELLS_IND on PRODUCT (email);
create unique index ID_SIZE_IND on SIZE (tag);
create unique index ID_SUDOKU_IND on SUDOKU (id_sudoku);
create unique index FKLINKED_IND on SUDOKU (day);
create unique index ID_USER_IND on USER (email);
create unique index ID_WINS_IND on WINS (day, email);
create index FKWIN_USE_IND on WINS (email);
create unique index ID_WISHES_IND on WISHES (id_product, email);
create index FKWIS_USE_IND on WISHES (email);