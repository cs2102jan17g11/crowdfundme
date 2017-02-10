# pg_dump
pg_dump crowdfundme -h localhost -p 5431 -U postgres > pg.sql

# pgcli
pgcli crowdfundme -p 5431 -h localhost -U postgres

# runsql
psql crowdfundme -p 5431 -h localhost -U postgres < pg.sql