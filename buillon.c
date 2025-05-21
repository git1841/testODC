gestion de erreur
button pour revenir direct au acceuille
n'esntre pas de 2 meme codecli
mettre de page sit que modification avec succee

// condition de date
// le entrer doit etre entier
// le affichage si le codeclin n'est pas trouver



technique :


codecli nom montant date




select codecompteur from ELEC where 


$sql = SELECT c.nom, c.codecli
FROM CLIENT c
JOIN COMPTEUR cp ON c.codecli = cp.codeclient
JOIN ELEC e ON cp.codecompteur = e.codecompteur
WHERE MONTH(e.date_limite_paie) = $mois AND YEAR(e.date_limite_paie) = 2024;





St@rlink.En12025





7 janv

releve   presenter  limite  payer

1 janv   30janv     7fev   10 fevr


tables  :

CLIENT : 
- codecli		
- nom		
- sexe	
- quartier	

PAYER : 
idpaye	
codecli	
datepaie	
montant

COMPTEUR :
codecompteur	
type		
pu	
codecli

ELEC :
codeElec		
codecompteur	
valeur1		
date_releve
date_presentation	
date_limite_paie

EAU : 
codeEau	
codecompteur
valeur2	
date_releve2
date_presentation2	
date_limite_paie2




donner le code php nommer payer_client.php pour faire cette specification :

- listes des : nom(collone nom) et codecli(collone codecli) dans le table CLIENT
- listes des date(collone datepaie) de payement dans le table PAYER 
- listes des codecompteur(collone codecompteur) dans le table COMPTEUR
- prendre a partire de cette codecompteur le date_presentation(collone date_presentation) dans le table ELEC
- prendre a partire de cette codecompteur le date_limite_paie(collone date_limite_paie) dans le table ELEC

si le datepaie est entre les date_presentation et le date_limite_paie alors affichie(en utulisant le HTML et CSS) que le client est 'deja payer' sinon 'pas encore pay'



-list client       -date de payement      -date de presentation       -date limite de payement

prendre le 







192.10.2.0



000
001
010
011
100
101
110
111


192.255.255.255 

192.0.1.0
192.00000000.00000000.0000000

192.25.0.0

192.2.1.0

11111111 = 256 


0 255




192.10.10.0
14 = 2**4
255.255.255.0

1111 1111.1111 1111.1111 1111.1111 0000
255.255.255.240


nombre de adress utulisable :

1
192.10.10.0000 0000 = 192.10.10.0000 0001 -> 192.10.10.0001 1110
                                1 -> 30 (30)

2
192.10.10.0010 0000 = 192.10
.10.0010 0001 -> 192.10.10.0010 1110
                                 33 ->   46.   (13)                                
.
.
.

14
192.10.10.1110 0000 = 192.10.10.1101 0001 -> 192.10.10.1110 1110













<div class="sidebar">
        <div class="logo">
            <h2>Gestion</h2>
        </div>
        <nav>
            <ul>
            <li><a href="page_acceuille.php">Acceuille</a></li>
                <li><a href="client.php">Clients</a></li>
                <li><a href="compteur.php">Compteurs</a></li>
                <li><a href="releve_elec.php">Relevé Électrique</a></li>
                <li><a href="releve_eau.php">Relevé Eau</a></li>
                <li><a href="payer.php">Payer</a></li>
                <li><a href="diver.php">diver</a></li>
            </ul>
        </nav>
</div> 


/* Sidebar */
.sidebar {
    width: 250px;
    background-color:#22b043;
    color: white;
    padding-top: 20px;
    position: fixed;
    height: 100%;
}

.sidebar .logo {
    text-align: center;
font-size: 24px;
    margin-bottom: 20px;
}

.sidebar nav ul {
    list-style: none;
    padding-left: 0;
}

.sidebar nav ul li {
    padding: 15px;
    text-align: center;
}

.sidebar nav ul li a {
    color: white;
    text-decoration: none;
font-size: 18px;
    display: block;
}

.sidebar nav ul li a:hover,
.sidebar nav ul li a.active {
    background-color: #28a745;
    color: #fff;
}






//confirmation de suppretion
//argeant a payer .... rest de payement ... 
//mail
//personner ne pas payer dans un moi donner
//niveau
//facture
//3 dernier hitrorique












https://meet.jit.si/remisedeprojetl2


<style>





</style>