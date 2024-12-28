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
create table CATEGORY (
    Tag varchar(32) not null,
    constraint ID_CATEGORY_ID primary key (Tag)
);
create table COLOR (
    Color varchar(32) not null,
    constraint ID_COLOR_ID primary key (Color)
);
create table CREDIT_CARD (
    Email varchar(64) not null,
    Number varchar(16) not null,
    Propretary_Name varchar(32) not null,
    Propertary_Surname varchar(32) not null,
    Expiration date not null,
    constraint ID_CREDIT_CARD_ID primary key (Email, Number)
);
create table DAY (
    Day date not null,
    constraint ID_DAY_ID primary key (Day)
);
create table DIMESION (
    ID int not null,
    Tag varchar(8) not null,
    constraint ID_DIMESION_ID primary key (ID, Tag)
);
create table DISCOUNT (
    Percentage int not null,
    ID int not null,
    constraint ID_DISCOUNT_ID primary key (ID)
);
create table DISCOUNTS (
    D_D_ID int not null,
    ID int not null,
    constraint ID_DISCOUNTS_ID primary key (ID, D_D_ID)
);
create table IS_CATEGORY (
    Tag varchar(32) not null,
    ID int not null,
    constraint ID_IS_CATEGORY_ID primary key (Tag, ID)
);
create table IS_COLOR (
    Color varchar(32) not null,
    ID int not null,
    constraint ID_IS_COLOR_ID primary key (Color, ID)
);
create table PRODUCT (
    ID int not null AUTO_INCREMENT,
    Name varchar(128) not null,
    Description varchar(1024) not null,
    Price int not null,
    Image varchar(128) not null,
    SEL_ID char(1) not null,
    constraint ID_PRODUCT_ID primary key (ID)
);
create table LIVES (
    CAP char(1) not null,
    Street char(1) not null,
    Civic char(1) not null,
    Email varchar(64) not null,
    constraint ID_LIVES_ID primary key (CAP, Street, Civic, Email)
);
create table NOTIFY (
    ID int not null,
    Title varchar(32) not null,
    Day date not null,
    Seen char not null,
    Description varchar(1024) not null,
    Email varchar(64) not null,
    constraint ID_NOTIFY_ID primary key (ID)
);
create table ORDER (
    ID int not null,
    Day char(1) not null,
    CAP char(1) not null,
    Street char(1) not null,
    Civic char(1) not null,
    Email varchar(64) not null,
    constraint ID_ORDER_ID primary key (ID)
);
create table ORDER_PRODUCT (
    O_O_ID int not null,
    ID int not null,
    constraint ID_ORDER_PRODUCT_ID primary key (O_O_ID, ID)
);
create table PLACE (
    CAP char(1) not null,
    City char(1) not null,
    Street char(1) not null,
    Civic char(1) not null,
    constraint ID_PLACE_ID primary key (CAP, Street, Civic)
);
create table SELLER (
    ID char(1) not null,
    Name varchar(32) not null,
    Email varchar(64) not null,
    Password varchar(256) not null,
    constraint ID_SELLER_ID primary key (ID)
);
create table SIZE (
    Tag varchar(8) not null,
    constraint ID_SIZE_ID primary key (Tag)
);
create table SUDOKU (
    ID int not null,
    Day date not null,
    Grid varchar(128) not null,
    Solution varchar(128) not null,
    constraint ID_SUDOKU_ID primary key (ID),
    constraint FKLINKED_ID unique (Day)
);
create table USER (
    Name varchar(32) not null,
    Birthday date not null,
    Email varchar(64) not null,
    Password varchar(256) not null,
    ID int not null,
    constraint ID_USER_ID primary key (Email)
);
create table WINS (
    Day date not null,
    Email varchar(64) not null,
    constraint ID_WINS_ID primary key (Day, Email)
);
create table WISHES (
    ID int not null,
    Email varchar(64) not null,
    constraint ID_WISHES_ID primary key (ID, Email)
);
-- Constraints Section
-- ___________________ 
alter table CREDIT_CARD
add constraint FKOWNS foreign key (Email) references USER (Email);
-- Not implemented
-- alter table DAY add constraint ID_DAY_CHK
--     check(exists(select * from SUDOKU
--                  where SUDOKU.Day = Day)); 
alter table DIMESION
add constraint FKDIM_SIZ_FK foreign key (Tag) references SIZE (Tag);
alter table DIMESION
add constraint FKDIM_PRO foreign key (ID) references PRODUCT (ID);
alter table DISCOUNTS
add constraint FKDIS_PRO foreign key (ID) references PRODUCT (ID);
alter table DISCOUNTS
add constraint FKDIS_DIS_FK foreign key (D_D_ID) references DISCOUNT (ID);
alter table IS_CATEGORY
add constraint FKIS__PRO_1_FK foreign key (ID) references PRODUCT (ID);
alter table IS_CATEGORY
add constraint FKIS__CAT foreign key (Tag) references CATEGORY (Tag);
alter table IS_COLOR
add constraint FKIS__PRO_FK foreign key (ID) references PRODUCT (ID);
alter table IS_COLOR
add constraint FKIS__COL foreign key (Color) references COLOR (Color);
-- Not implemented
-- alter table PRODUCT add constraint ID_PRODUCT_CHK
--     check(exists(select * from IS_CATEGORY
--                  where IS_CATEGORY.ID = ID)); 
alter table PRODUCT
add constraint FKSELLS_FK foreign key (SEL_ID) references SELLER (ID);
alter table LIVES
add constraint FKLIV_USE_FK foreign key (Email) references USER (Email);
alter table LIVES
add constraint FKLIV_PLA foreign key (CAP, Street, Civic) references PLACE (CAP, Street, Civic);
alter table NOTIFY
add constraint FKHAS_FK foreign key (Email) references USER (Email);
-- Not implemented
-- alter table ORDER add constraint ID_ORDER_CHK
--     check(exists(select * from ORDER_PRODUCT
--                  where ORDER_PRODUCT.O_O_ID = ID)); 
alter table ORDER
add constraint FKSHIPPED_FK foreign key (CAP, Street, Civic) references PLACE (CAP, Street, Civic);
alter table ORDER
add constraint FKORDERS_FK foreign key (Email) references USER (Email);
alter table ORDER_PRODUCT
add constraint FKORD_PRO_FK foreign key (ID) references PRODUCT (ID);
alter table ORDER_PRODUCT
add constraint FKORD_ORD foreign key (O_O_ID) references ORDER (ID);
alter table SUDOKU
add constraint FKLINKED_FK foreign key (Day) references DAY (Day);
alter table USER
add constraint FKCART_FK foreign key (ID) references PRODUCT (ID);
alter table WINS
add constraint FKWIN_USE_FK foreign key (Email) references USER (Email);
alter table WINS
add constraint FKWIN_DAY foreign key (Day) references DAY (Day);
alter table WISHES
add constraint FKWIS_USE_FK foreign key (Email) references USER (Email);
alter table WISHES
add constraint FKWIS_PRO foreign key (ID) references PRODUCT (ID);
-- Index Section
-- _____________ 
create unique index ID_CATEGORY_IND on CATEGORY (Tag);
create unique index ID_COLOR_IND on COLOR (Color);
create unique index ID_CREDIT_CARD_IND on CREDIT_CARD (Email, Number);
create unique index ID_DAY_IND on DAY (Day);
create unique index ID_DIMESION_IND on DIMESION (ID, Tag);
create index FKDIM_SIZ_IND on DIMESION (Tag);
create unique index ID_DISCOUNT_IND on DISCOUNT (ID);
create unique index ID_DISCOUNTS_IND on DISCOUNTS (ID, D_D_ID);
create index FKDIS_DIS_IND on DISCOUNTS (D_D_ID);
create unique index ID_IS_CATEGORY_IND on IS_CATEGORY (Tag, ID);
create index FKIS__PRO_1_IND on IS_CATEGORY (ID);
create unique index ID_IS_COLOR_IND on IS_COLOR (Color, ID);
create index FKIS__PRO_IND on IS_COLOR (ID);
create unique index ID_PRODUCT_IND on PRODUCT (ID);
create index FKSELLS_IND on PRODUCT (SEL_ID);
create unique index ID_LIVES_IND on LIVES (CAP, Street, Civic, Email);
create index FKLIV_USE_IND on LIVES (Email);
create unique index ID_NOTIFY_IND on NOTIFY (ID);
create index FKHAS_IND on NOTIFY (Email);
create unique index ID_ORDER_IND on ORDER (ID);
create index FKSHIPPED_IND on ORDER (CAP, Street, Civic);
create index FKORDERS_IND on ORDER (Email);
create unique index ID_ORDER_PRODUCT_IND on ORDER_PRODUCT (O_O_ID, ID);
create index FKORD_PRO_IND on ORDER_PRODUCT (ID);
create unique index ID_PLACE_IND on PLACE (CAP, Street, Civic);
create unique index ID_SELLER_IND on SELLER (ID);
create unique index ID_SIZE_IND on SIZE (Tag);
create unique index ID_SUDOKU_IND on SUDOKU (ID);
create unique index FKLINKED_IND on SUDOKU (Day);
create unique index ID_USER_IND on USER (Email);
create index FKCART_IND on USER (ID);
create unique index ID_WINS_IND on WINS (Day, Email);
create index FKWIN_USE_IND on WINS (Email);
create unique index ID_WISHES_IND on WISHES (ID, Email);
create index FKWIS_USE_IND on WISHES (Email);