-- auto-generated definition
create table product
(
  id           int auto_increment
    primary key,
  category_id  int            null,
  model        varchar(255)   not null,
  manufacturer varchar(255)   null,
  price        decimal(10, 2) null,
  date_added   datetime       null,
  constraint FK_D34A04AD12469DE2
  foreign key (category_id) references category (id)
)
  engine = InnoDB
  collate = utf8mb4_unicode_ci;

create index IDX_D34A04AD12469DE2
  on product (category_id);

INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (1, 5, 'L50', 'Toshiba', 500.00, '2018-06-29 18:03:11');
INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (2, 5, 'Satellite', 'Toshiba', 2100.00, '2018-06-29 18:13:36');
INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (3, 6, 'AS300', 'ASUS', 1500.00, '2013-01-02 15:02:00');
INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (4, 7, 'Tablet400', 'HP', 350.00, '2018-06-30 23:56:15');
INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (5, 10, 'Inspiron', 'Dell', 1300.00, '2016-05-08 01:39:00');
INSERT INTO sf_store.product (id, category_id, model, manufacturer, price, date_added) VALUES (6, 10, 'Vostro', 'Dell', 1100.00, '2015-02-28 13:02:00');