#!/bin/bash

#Check if there is a new file
#inotifywait -m /var/mail/vhosts/centinfo.com/email2/cur/ -e moved_to

while :; do
	#Saving facture to drive of the user corresponding
	newMail=$(inotifywait -e moved_to /var/mail/vhosts/centinfo.com/*/cur/)
	touch result.txt
	echo "$newMail" > result.txt
	mailPath=$(cut -f1 -d" " result.txt)
	mailName=$(cut -f3 -d" " result.txt)
	mailUser=$(echo $mailPath | cut -f 6 -d '/')
	touch mailContent.txt
		cat $mailPath$mailName > mailContent.txt
		mailSend1=$(cut -f3 -d" " mailContent.txt | head -10 | tail -n 1 | cut -f 1 -d"@" | cut -f 2 -d".")
		mailSend2=$(echo ${mailSend1^^})
	rm result.txt mailContent.txt

	#If there is a new mail which is arrived
	if [[ $mailName == *"2,a"* ]]; then
		echo "-----------------------------------------------------------------"
		echo "Mail path: $mailPath"
		echo "Name mail: $mailName"
		echo "User concerned by the mail: $mailUser"
		echo "mailSend1: $mailSend1"
		echo "mailSend2: $mailSend2"

		echo "Extraction attachment from the email..."
		munpack $mailPath$mailName
		#Delete the .desc file linked to the attachment
		rm *.desc
		#Get the name of the attachment
		mailAttachName=$(ls -Art | tail -n 1)
		echo "Done"

		echo "mailAttachName: $mailAttachName"

		echo "Sending mail to the Drive of the user corresponding... ($mailAttachName)"
		mv $mailAttachName /var/www/html/PA_2.0/public/uploads/documents
		chmod 777 "/var/www/html/PA_2.0/public/uploads/documents/$mailAttachName"
		echo "Done"

		#Create Folder for attachment
		mailUserFull=$(echo "${mailUser}@centinfo.com");
		getValueFolder=$(echo "SELECT EXISTS(SELECT 1 from categorie WHERE NOM_CATEGORIE='$mailSend2');" | mysql mailserver -u padmin -ppassword | tail -n 1);
		idUser=$(echo "SELECT id FROM virtual_users WHERE email='$mailUserFull';" | mysql mailserver -u padmin -ppassword | tail -n 1);
		echo "Adresse mail de l'utilisateur concerné: $mailUserFull"
		echo "ID user concerné: $idUser"
		echo 'La catégorie existe ? 0 (non) et 1 (oui)= '$getValueFolder #c'est le nom du service ici 'EDF'

		#La catégorie n'existe pas (si la catégorie existe sauter cette étape)
		if (( $getValueFolder == '0' )) ; then
			echo "INSERT INTO categorie(NOM_CATEGORIE, TYPE_DE_CATEGORIE, user_id, id_categorie_parent) VALUES ('$mailSend2','fff','$idUser',NULL);" | mysql mailserver -u padmin -ppassword
		fi

		#Add document to DDB for Application
		numFolder=$(echo "SELECT id_categorie FROM categorie WHERE NOM_CATEGORIE='$mailSend2';" | mysql mailserver -u padmin -ppassword | tail -n 1);
		nameAttach=$(echo $mailAttachName | cut -f 1 -d".");
		formatAttach=$(echo $mailAttachName | cut -f 2 -d".");
		time=$(date '+%Y-%m-%d %H:%M:%S')

		echo "Numéro folder: $numFolder"
		echo "format Attach: $formatAttach"
		echo "name Attach: $nameAttach"
		echo "Received time: $time"		
		
		echo "INSERT INTO documentperso(ID_CATEGORIE, DATE_DE_PARUTION, CHEMIN_ABSOLUE, FORMAT, NOM_DOCUMENT, INTITULE_DOCUMENT) VALUES ($numFolder,'$time','/var/www/html/PA_2.0/src/Entity/../../public/uploads documents/','$formatAttach','$nameAttach','$mailAttachName');" | mysql mailserver -u padmin -ppassword
		echo "-----------------------------------------------------------------"
		echo ""
		echo ""
	fi
done