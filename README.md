# enoteca2.0

come l'enoteca ma più tech

TODO:
tabella articoli:

- id_articolo               INT(16)
- numero inventario         VARCHAR(32)
- stato                     SET(disponibile, guasto, prenotato, in prestito)
- fk_id_categoria           INT(16)
- fk_id_centro              INT(16)

tabella categorie:

- id_categoria              INT(16)
- nome                      VARCHAR(32)
- tipologia                 VARCHAR(32)

tabella centri:

- id_centro                 INT(16)
- nome                      VARCHAR(32)
- città                     VARCHAR(32)
- indirizzo                 VARCHAR(64)

tabella utenti:

- id_utente                 INT(16)
- nome                      VARCHAR(32)
- cognome                   VARCHAR(32)
- indirizzo                 VARCHAR(64)
- email                     VARCHAR(32)
- password                  VARCHAR(32) + MD5
- tipologia_utente          SET(cliente, operatore, amministratore)

tabella prestiti:

- id_prestito               INT(16)
- data_inizio_prestito      DATE
- data_fine_prestito        DATE
- fk_id_utente              INT(16)
- fk_id_articolo            INT(16)

tabella prenotazioni:

- id_prenotazione           INT(16)
- data_inizio_prenotazione  DATE
- fk_id_utente              INT(16)
- fk_id_articolo            INT(16)
