
CREATE DATABASE ; 

CREATE SCHEMA ;

-- creating the tables 
-- kozvetites
CREATE TABLE IF NOT EXISTS schema_name.kozvetites (
	csatorna serial REFERENCES schema_name.csatorna (nev) NOT NULL,
	musor serial REFERENCES schema_name.musor (cim) NOT NULL
    ido TIMESTAMP NOT NULL
)


...