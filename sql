create table ab_testdata
(
    id          bigint      not null
        primary key,
    ab_testname varchar(80) not null
        unique
);


