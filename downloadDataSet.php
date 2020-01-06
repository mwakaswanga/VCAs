<?php

	$sql = " month, year, vca firstname, surname, r1, r1r9, r10r14, r15r19, r20r24, r25r29, r30r34, r35r49, r50plus, c1, c1c9, c10c14, c15c19, c20c24, c25c29, c30c34, c35c49, c50plus
	From services, registered_vcas
	Where vca_id = vca
	INTO OUTFILE '/var/lib/mysql-files/services.csv'
	FIELDS TERMINATED BY ','
	ENCLOSED BY '\"'
	LINES TERMINATED BY '\n'";

	$file = '/var/lib/mysql-files/services.csv'

?>