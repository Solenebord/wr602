<!DOCTYPE html>
<html>
<head>
	<title>CONTAINER SYMFONY</title>
	<meta charset="utf-8" />
</head>
<body>
<h1>CONTAINER SYMFONY MODE D'EMPLOI</h1>
<p>	Pour créer un nouveau projet Symfony, connectez-vous au container avec la commande : docker exec -ti symfony</p>
<p> A l'invite de commandes, placez-vous dans le dossier "/var/www" </p>
<p> Saisissez la commande : git config --global --add safe.directory /var/www/PROJET (remplacez PROJET par le nom de votre choix) </p>
<p> Créez votre projet symfony avec la commande "symfony new PROJET" </p>
<p> Une fois le projet créé, déplacez-vous dans le dossier /etc/apache2/sites-enabled</p>
<p> Editez le fichier 001-symfony.conf et remplacer PROJET par le nom de votre projet (et donc de votre dossier qui a été créé dans /var/www)</p>
<p> Rechargez apache2</p>
<p> Votre projet est accessible par l'URL : symfony.mmi-troyes.fr
<p> </p>
<p> Si vous voulez créer un autre projet, procédez de même en dupliquant le fichier 001-symfony.conf et en modifiant le nom du projet</p>
<p> ATTENTION : La valeur de ServerName doit correspondre à un nom DNS pointant sur 127.0.0.1 (c'est le cas de symfony.mmi-troyes.fr et de wr313.mmi-troyes.fr)</p>
</body>
</html>