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
    quantity int not null,
    constraint ID_CART_ID primary key (id_product, email)
);
create table CATEGORY (
    category_tag varchar(32) not null,
    constraint ID_CATEGORY_ID primary key (category_tag)
);
create table CREDIT_CARD (
    email varchar(64) not null,
    number varchar(16) not null,
    name varchar(32) not null,
    surname varchar(32) not null,
    expiration date not null,
    constraint ID_CREDIT_CARD_ID primary key (email, number)
);
create table NOTIFICATION (
    id_notification int not null auto_increment,
    title varchar(32) not null,
    day date not null,
    seen char not null,
    description varchar(1024) not null,
    email varchar(64) not null,
    constraint ID_NOTIFICATION_ID primary key (id_notification)
);
create table ORDERS (
    id_order int not null auto_increment,
    day date not null,
    price int not null,
    email varchar(64) not null,
    constraint ID_ORDERS_ID primary key (id_order)
);
create table ORDERS_ITEM (
    id_order int not null,
    id_product int not null,
    quantity int not null,
    constraint ID_ORDERS_ITEM_ID primary key (id_order, id_product)
);
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
    constraint ID_PRODUCT_ID primary key (id_product)
);
create table SUDOKU (
    day date not null,
    grid varchar(128) not null,
    solution varchar(128) not null,
    constraint ID_SUDOKU_ID primary key (day)
);
create table USER (
    name varchar(32) not null,
    email varchar(64) not null,
    password varchar(256) not null,
    seller char not null,
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
alter table NOTIFICATION
add constraint FKHAS_FK foreign key (email) references USER (email);
-- Not implemented
-- alter table ORDERS add constraint ID_ORDERS_CHK
--     check(exists(select * from ORDERS_ITEM
--                  where ORDERS_ITEM.id_order = id_order)); 
alter table ORDERS
add constraint FKORDERS_FK foreign key (email) references USER (email);
alter table ORDERS_ITEM
add constraint FKORD_PRO_FK foreign key (id_product) references PRODUCT (id_product);
alter table ORDERS_ITEM
add constraint FKORD_ORD foreign key (id_order) references ORDERS (id_order);
alter table PRODUCT
add constraint FKSELLS_FK foreign key (email) references USER (email);
alter table PRODUCT
add constraint FKIS_CATEGORY_FK foreign key (category_tag) references CATEGORY (category_tag);
alter table WINS
add constraint FKWIN_USE_FK foreign key (email) references USER (email);
alter table WINS
add constraint FKWIN_SUD foreign key (day) references SUDOKU (day);
alter table WISHES
add constraint FKWIS_USE_FK foreign key (email) references USER (email);
alter table WISHES
add constraint FKWIS_PRO foreign key (id_product) references PRODUCT (id_product);
-- Index Section
-- _____________ 
create unique index ID_CART_IND on CART (id_product, email);
create index FKCAR_USE_IND on CART (email);
create unique index ID_CATEGORY_IND on CATEGORY (category_tag);
create unique index ID_CREDIT_CARD_IND on CREDIT_CARD (email, number);
create unique index ID_NOTIFICATION_IND on NOTIFICATION (id_notification);
create index FKHAS_IND on NOTIFICATION (email);
create unique index ID_ORDERS_IND on ORDERS (id_order);
create index FKORDERS_IND on ORDERS (email);
create unique index ID_ORDERS_ITEM_IND on ORDERS_ITEM (id_order, id_product);
create index FKORD_PRO_IND on ORDERS_ITEM (id_product);
create unique index ID_PRODUCT_IND on PRODUCT (id_product);
create index FKSELLS_IND on PRODUCT (email);
create index FKIS_CATEGORY_IND on PRODUCT (category_tag);
create unique index ID_SUDOKU_IND on SUDOKU (day);
create unique index ID_USER_IND on USER (email);
create unique index ID_WINS_IND on WINS (day, email);
create index FKWIN_USE_IND on WINS (email);
create unique index ID_WISHES_IND on WISHES (id_product, email);
create index FKWIS_USE_IND on WISHES (email);
insert into USER (name, email, password, seller)
VALUES (
        'seller1',
        'seller1@gmail.com',
        '$2y$10$N6wsVyo0tewSM9aJB/DB0ue0xohDC2.WgoF.SvLO2Z5n0to1bku9e',
        1
    ),
    (
        'user1',
        'user1@gmail.com',
        '$2y$10$vhlDCfDUNa8UCYiitSN8Vuwl.9W0lRR/HgF8sTBQWn8e6j.zYwLBG',
        0
    ),
    (
        'user2',
        'user2@gmail.com',
        '$2y$10$cTQEdrPr.1NlNLBEX.l.neXS4HfOQnzkgNZXtaaa520JS9w.HjsHK',
        0
    );
insert into CATEGORY (category_tag)
VALUES ('passatempo'),
    ('abbigliamento'),
    ('casa');
insert into PRODUCT (
        name,
        description,
        price,
        image,
        email,
        category_tag,
        discount,
        availability,
        removed
    )
VALUES (
        'tazza love sudoku',
        'Bellissima tazza con scritto I love sudoku',
        1000,
        '/uploads/products/tazza1.jpg',
        'seller1@gmail.com',
        'casa',
        10,
        10,
        0
    ),
    (
        'rivista settimana sudoku',
        'Fantastica rivista per allenare la mente con sudoku',
        800,
        '/uploads/products/settimana_sudoku1.png',
        'seller1@gmail.com',
        'passatempo',
        0,
        100,
        0
    ),
    (
        'maglia commit sudoku',
        'Maglia con scritta commit sudoku',
        1000,
        '/uploads/products/tshirt_commit_sudoky.jpg',
        'seller1@gmail.com',
        'abbigliamento',
        20,
        100,
        0
    ),
    (
        'scheda video 5090',
        'Grande scheda video 5090 con un pizzico di sudoku',
        9900,
        '/uploads/products/5090.jpg',
        'seller1@gmail.com',
        'passatempo',
        0,
        100,
        0
    ),
    (
        'copricerchi',
        'Ottimi copricerchi per la vostra auto, per far vedere a tutti chi ama veramente i sudoku',
        5000,
        '/uploads/products/copricerchi.jpg',
        'seller1@gmail.com',
        'passatempo',
        10,
        50,
        0
    ),
    (
        'cover telefono',
        'Miglior cover sul mercato, per ostentare la vostra passione per i sudoku',
        900,
        '/uploads/products/coverTelefono.jpg',
        'seller1@gmail.com',
        'passatempo',
        0,
        100,
        0
    ),
    (
        'tazza sudoku is my game',
        'Tazza Alex is my name sudoku is my game',
        1250,
        '/uploads/products/tazza2.jpeg',
        'seller1@gmail.com',
        'casa',
        5,
        25,
        0
    ),
    (
        'tazza con sudoku',
        'tazza bianca con sudoku',
        750,
        '/uploads/products/tazza3.jpeg',
        'seller1@gmail.com',
        'casa',
        5,
        25,
        0
    ),
    (
        'tazza samurai sudoku',
        'tazza con sudoku samurai',
        750,
        '/uploads/products/tazza_samurai.jpg',
        'seller1@gmail.com',
        'casa',
        2,
        200,
        0
    );
INSERT INTO SUDOKU (day, grid, solution)
VALUES (
        CURDATE(),
        '534678912672195348198342567859761423426853791713924856961537284287419635345286170',
        '534678912672195348198342567859761423426853791713924856961537284287419635345286179'
    );
insert into CREDIT_CARD (
        email,
        number,
        name,
        surname,
        expiration
    )
VALUES (
        'user1@gmail.com',
        '1234567890123456',
        'Mario',
        'Rossi',
        '2024-12-31'
    ),
    (
        'user2@gmail.com',
        '1234567890123456',
        'Andrea',
        'Monc',
        '2024-12-31'
    ),
    (
        'user1@gmail.com',
        '1234567890123457',
        'Mario1',
        'Rossi1',
        '2027-1-1'
    );

INSERT INTO ORDERS (day, price ,email)
VALUES (
        CURDATE(),
        1000,
        "user2@gmail.com");
INSERT INTO ORDERS_ITEM (id_order, id_product, quantity)
VALUES (
        1,
        1,
        1
    );
INSERT INTO ORDERS (day, price ,email)
VALUES (
        CURDATE(),
        100,
        "user2@gmail.com");
INSERT INTO ORDERS_ITEM (id_order, id_product, quantity)
VALUES (
        2,
        2,
        2
    );
INSERT INTO ORDERS (day, price ,email)
VALUES (
        CURDATE(),
        10,
        "user2@gmail.com");
INSERT INTO ORDERS_ITEM (id_order, id_product, quantity)
VALUES (
        3,
        3,
        3
    );
INSERT INTO ORDERS (day, price ,email)
VALUES (
        CURDATE(),
        1,
        "user2@gmail.com");
INSERT INTO ORDERS_ITEM (id_order, id_product, quantity)
VALUES (
        4,
        4,
        4
    );

INSERT INTO WINS(day, email)
VALUES (
        CURDATE(),
        "user2@gmail.com");
