create table page (
  id   integer primary key AUTOINCREMENT not null,
  url  clob not null,
  hash clob not null,
  data clob not null
);
create unique index page_hash
  on page (hash);
