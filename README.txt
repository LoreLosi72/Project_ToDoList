1-INSERIRE LA CARTELLA ToDoList ALL'INTERNO DELLA CARTELLA WWW DI UNISERVERZ.
2-CREARE UN'UTENZA IN PHPMYADMIN E IMPORTARE IL FILE .SQL
3-MODIFICARE I CAMPI DI CONNESSIONE AL DATABASE NEL FILE connection.php e connection_privata.php CON LE CREDENZIALI CHE SI SONO CREATE PRECEDENTEMENTE IN PHPMYADMIN
E CON LE QUALI SI E' IMPORTATO IL FILE .SQL

UTENTI ALL'INTERNO DELLA TABELLA utenti:
Lorenzo password->password123
Aurora password->password123
Luca_rossi password->@password1234
Giuliano72 password->pippo2345

POPOLAZIONE DATABASE:
E' messo a disposizione il file EVENTI.csv creato da mockaroo con cui è stata popolata la tabella impegni in precedenza.
Per creare un nuovo csv di popolazione:
-ID -->Row Number
-Nome --> utilizzo di Department(retail)-->consigliato
-Data_impegno --> utilizzo data in formato yyyy-mm-dd
-fk_utente --> utilizzo number con intervallo che va dal primo id all'ultimo id della tabella utenti.
per popolarlo utilizzare la parte di codice commentata nel file connection.php e cambiare il nome del file da aprire 
in base al nome del file csv inserito e il numero di righe, sempre in base al numero di righe presenti nel file csv inserito.
