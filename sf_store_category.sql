-- auto-generated definition
create table category
(
  id        int auto_increment
    primary key,
  parent_id int          null,
  name      varchar(255) not null,
  constraint FK_64C19C1727ACA70
  foreign key (parent_id) references category (id)
)
  engine = InnoDB
  collate = utf8mb4_unicode_ci;

create index IDX_64C19C1727ACA70
  on category (parent_id);

INSERT INTO sf_store.category (id, parent_id, name) VALUES (1, null, 'Computers');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (2, 1, 'Laptops');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (3, 1, 'PCs');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (4, 1, 'Tablets');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (5, 2, 'Toshiba');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (6, 2, 'ASUS');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (7, 3, 'HP');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (8, 4, 'HP');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (9, 2, 'Lenovo');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (10, 3, 'Dell');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (11, 4, 'Casio');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (12, null, 'Appliances');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (13, 12, 'Cameras');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (14, 13, 'Cannon');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (15, 2, 'Sony');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (16, 4, 'Acer');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (18, 12, 'Vacuum Cleaners');
INSERT INTO sf_store.category (id, parent_id, name) VALUES (19, 18, 'Hoover');