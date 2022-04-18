/* parametres :
nom = nom de l'administrateur
prenom = prenom de l'administrateur
mail = mail de l'administrateur
role = admin (!important)
datecreated = current_date
password = md5(mot de passe pour la connexion de administaratur)
*/

/*
 le nom, prenom, mail, role et le mot de passe ecrit a l'intérieur de la fonction md5(), doivent etre entre guillement '' */

INSERT INTO public.users(
	nom, prenom, mail, role, datecreated, password)
	VALUES (?, ?, ?, ?, ?, ?,);


/* parametres :
id = au numero id de l'users que vous venez de créer avec le role admin (si il s'agit du premier utilisateur créé alors lid = 1)
*/
	
INSERT INTO public.administrateur(
	userid)
	VALUES (?);

