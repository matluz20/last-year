<?php
$conn=mysqli_connect('127.0.0.1','root','Davidnoa123#');
if (!$conn)
{
die ('Ne peut pas se connecter');
}
mysqli_select_db($conn,'ETUDIANT');
$age_min=$_POST['age'];
$requete='SELECT nom,Utilisateurs.prenom,age FROM Utilisateurs, Informations WHERE
Utilisateurs.id_users = Informations.id_medic AND age > '.$age_min.';';
$resultats=mysqli_query($conn,$requete);
while ( $personne = mysqli_fetch_assoc($resultats))
{
echo "Patient ".$personne['prenom']." ".$personne['nom'].": ";
echo "son age est ".$personne['age'];
echo "<br />";
}
mysqli_close($conn);
?>
