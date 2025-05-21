<?php

require('/opt/lampp/htdocs/pjphp/model/fpdf/fpdf.php');





$date1 = NULL;
$date2 = NULL;
$date3 = NULL;
$date4 = NULL;
$N_compteur_elec = NULL;
$N_compteur_eau = NULL;
$pu_elec = 0;
$pu_eau = 0;
$val_elec = 0;
$val_eau = 0;






// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=jirama', 'root', '');

// Récupération des variables depuis l'URL
$date_aujourdhui = date('d/m/Y');
$codecli_client = $_GET['codecli'];
$query = $pdo->prepare("SELECT nom FROM CLIENT WHERE codecli = :codecli");
$query->execute(['codecli' => $codecli_client]);
$client = $query->fetch();
$nom_client = $client['nom'];





//$adress_client = '123 Rue du Client, 1234 Ville';
//$nom_client = "TOTO";
//$codecli_client = "codeclient";
//$codecli_client = $_GET['codecli'];
try{

// Préparez la requête pour récupérer l'adresse du client
    $query1 = $pdo->prepare("SELECT quartier FROM CLIENT WHERE codecli = :codecli");
    $query1->execute(['codecli' => $codecli_client]);
    $client1 = $query1->fetch();

    if ($client1) {
        // Si une entrée est trouvée, assignez la valeur de 'quartier' à $adress_client
        $adress_client = $client1['quartier'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir une adresse par défaut ou afficher un message d'erreur
        $adress_client = "Adresse non disponible";
    }

    // Maintenant, vous pouvez utiliser la variable $adress_client comme vous le souhaitez
    //echo $adress_client;

    //$sql = "DELETE FROM ELEC WHERE codecompteur = (SELECT codecompteur FROM COMPTEUR WHERE codecli = ?)";

    $query = $pdo->prepare("SELECT codecompteur FROM COMPTEUR WHERE codecli = :codecli AND type = 'ELECTRICITE'");
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $codecompteur = $compteur['codecompteur'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        $codecompteur = "Code compteur non disponible";
    }

    // Maintenant, vous pouvez utiliser la variable $codecompteur comme vous le souhaitez
    //echo $codecompteur;

    //$date1 = '25/04/2023';
    //$date2 = '05/05/2023';

    $N_compteur_elec = $codecompteur;

    $query = $pdo->prepare("SELECT codecompteur FROM COMPTEUR WHERE codecli = :codecli AND type = 'EAU'");
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $codecompteur = $compteur['codecompteur'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        $codecompteur = "Code compteur non disponible";
    }

    $N_compteur_eau = $codecompteur;


    //$sql = "SELECT date_presentation FROM ELEC WHERE codecompteur = (SELECT codecompteur FROM COMPTEUR WHERE codecli = :codecli AND type = 'EAU')";
    /*
    $query = $pdo->prepare("SELECT date_presentation FROM ELEC WHERE codecompteur = (SELECT codecompteur FROM COMPTEUR WHERE codecli = :codecli AND type = 'ELECTRICITE'");
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $codecompteur = $compteur['codecompteur'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        $codecompteur = "Code compteur non disponible";
    }
    */
    //echo $codecompteur;


    $codecli = $codecli_client;

        // Préparer la requête SQL
        $sql = "SELECT date_presentation 
        FROM ELEC 
        WHERE codecompteur = (
            SELECT codecompteur 
            FROM COMPTEUR 
            WHERE codecli = :codecli AND type = 'ELECTRICITE'
        );";

    // Préparer la requête avec PDO
    $stmt = $pdo->prepare($sql);
    // Lier le paramètre ':codecli' à la valeur du client
    $stmt->bindParam(':codecli', $codecli, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['date_presentation'])) {
    // Convertir la date en objet DateTime
    $dateTime = new DateTime($result['date_presentation']);

    // Formater la date au format souhaité (par exemple, 'Y-m-d')
    $formattedDate = date_format($dateTime, 'Y-m-d');

    // Maintenant, $formattedDate est une chaîne de caractères que vous pouvez utiliser dans votre PDF
    } else {
    // Gérer le cas où la requête ne retourne aucun résultat ou la date n'est pas définie
    //$formattedDate = "Date non disponible";
    $formattedDate = "xx-xx-xxxx";
    }
    $date1 = $formattedDate;




    $sql = "SELECT date_limite_paie 
    FROM ELEC 
    WHERE codecompteur = (
        SELECT codecompteur 
        FROM COMPTEUR 
        WHERE codecli = :codecli AND type = 'ELECTRICITE'
    );";

    // Préparer la requête avec PDO
    $stmt = $pdo->prepare($sql);
    // Lier le paramètre ':codecli' à la valeur du client
    $stmt->bindParam(':codecli', $codecli, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['date_limite_paie'])) {
    // Convertir la date en objet DateTime
    $dateTime = new DateTime($result['date_limite_paie']);

    // Formater la date au format souhaité (par exemple, 'Y-m-d')
    $formattedDate = date_format($dateTime, 'Y-m-d');

    // Maintenant, $formattedDate est une chaîne de caractères que vous pouvez utiliser dans votre PDF
    } else {
    // Gérer le cas où la requête ne retourne aucun résultat ou la date n'est pas définie
    //$formattedDate = "Date non disponible";
    $formattedDate = "xx-xx-xxxx";
    }
    $date2 = $formattedDate;




    $sql = "SELECT date_presentation2 
    FROM EAU 
    WHERE codecompteur = (
        SELECT codecompteur 
        FROM COMPTEUR 
        WHERE codecli = :codecli AND type = 'EAU'
    );";

    // Préparer la requête avec PDO
    $stmt = $pdo->prepare($sql);
    // Lier le paramètre ':codecli' à la valeur du client
    $stmt->bindParam(':codecli', $codecli, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['date_presentation2'])) {
    // Convertir la date en objet DateTime
    $dateTime = new DateTime($result['date_presentation2']);

    // Formater la date au format souhaité (par exemple, 'Y-m-d')
    $formattedDate = date_format($dateTime, 'Y-m-d');

    // Maintenant, $formattedDate est une chaîne de caractères que vous pouvez utiliser dans votre PDF
    } else {
    // Gérer le cas où la requête ne retourne aucun résultat ou la date n'est pas définie
    //$formattedDate = "Date non disponible";
    $formattedDate = "xx-xx-xxxx";
    }
    $date3 = $formattedDate;




    $sql = "SELECT date_limite_paie2	 
    FROM EAU 
    WHERE codecompteur = (
        SELECT codecompteur 
        FROM COMPTEUR 
        WHERE codecli = :codecli AND type = 'EAU'
    );";

    // Préparer la requête avec PDO
    $stmt = $pdo->prepare($sql);
    // Lier le paramètre ':codecli' à la valeur du client
    $stmt->bindParam(':codecli', $codecli, PDO::PARAM_STR);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['date_limite_paie2'])) {
    // Convertir la date en objet DateTime
    $dateTime = new DateTime($result['date_limite_paie2']);

    // Formater la date au format souhaité (par exemple, 'Y-m-d')
    $formattedDate = date_format($dateTime, 'Y-m-d');

    // Maintenant, $formattedDate est une chaîne de caractères que vous pouvez utiliser dans votre PDF
    } else {
    // Gérer le cas où la requête ne retourne aucun résultat ou la date n'est pas définie
    //$formattedDate = "Date non disponible";
    $formattedDate = "xx-xx-xxxx";
    }
    $date4 = $formattedDate;


    //////////////////////////////////////////////////////////////////////

    $sql = "SELECT valeur1 
    FROM ELEC 
    WHERE codecompteur = (
        SELECT codecompteur 
        FROM COMPTEUR 
        WHERE codecli = :codecli AND type = 'ELECTRICITE'
    );";

    $query = $pdo->prepare($sql);
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $pu = $compteur['valeur1'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        //$pu = "Code compteur non disponible";
        $pu = 0;
    }
    $val_elec = $pu;



    $sql = "SELECT valeur2
    FROM EAU 
    WHERE codecompteur = (
        SELECT codecompteur 
        FROM COMPTEUR 
        WHERE codecli = :codecli AND type = 'EAU'
    );";

    $query = $pdo->prepare($sql);
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $pu = $compteur['valeur2'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        //$pu = "Code compteur non disponible";
        $pu = 0;
    }
    $val_eau = $pu;


    $query = $pdo->prepare("SELECT pu FROM COMPTEUR WHERE codecli = :codecli AND type = 'EAU'");
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $pu = $compteur['pu'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        //$pu = "Code compteur non disponible";
        $pu = 0;
    }
    $pu_eau = $pu;



    $query = $pdo->prepare("SELECT pu FROM COMPTEUR WHERE codecli = :codecli AND type = 'ELECTRICITE'");
    $query->execute(['codecli' => $codecli_client]);
    $compteur = $query->fetch();

    if ($compteur) {
        // Si une entrée est trouvée, assignez la valeur de 'codecompteur' à $codecompteur
        $pu = $compteur['pu'];
    } else {
        // Si aucune entrée n'est trouvée, vous pouvez définir un codecompteur par défaut ou afficher un message d'erreur
        //$pu = "Code compteur non disponible";
        $pu = 0;
    }
    $pu_elec = $pu;



    //$pu_eau 
    //$pu_elec 
    //$val_eau
    //$val_elec
    /*
    $val1 = 1000;
    $val2 = $val_eau;
    $val3 = 0.5;
    $val4 = 100;
    $val5 = 2000;
    $val6 = 500;
    $val7 = 2500;
    */
    try{
        
    $fichier_csv = "data.csv";

    // Ouverture du fichier en mode écriture (ajoute au contenu existant)
    $file = fopen($fichier_csv, 'a');

    // Vérification de l'ouverture du fichier
    if ($file) {
    // Écriture des données dans le fichier CSV
    
    fputcsv($file, array($codecli, $nom_client, 
    
    ($val_elec * $pu_elec) + 

    ($val_eau * $pu_eau), 
    
    $date1));

    // Fermeture du fichier
    fclose($file);

    }
    
    // Création du PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Entête de la facture
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'JIRO SY RANO MALAGASY', 0, 1, 'C');
    $pdf->Ln(5);


    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 10, "Votre facture du : $date_aujourdhui", 0, 1, 'C');
    $pdf->Cell(0, 10, "Tutulaire de compte : $nom_client                                                                    Date de presentation ELECTRICITER: $date1", 0, 1, 'L');
    $pdf->Cell(0, 10, "Reference Client : $codecli_client                                                                  Date limite de paiement ELECTRICITER: $date2 ", 0, 1, 'L');
    $pdf->Cell(0, 10, "Adresse installation : $adress_client                                                                        Date de presentation EAU: $date3", 0, 1, 'L');
    $pdf->Cell(0, 10, utf8_decode("Num compteur électricité : $N_compteur_elec                                                                   Date limite de paiement EAU : $date4"), 0, 1, 'L');
    $pdf->Cell(0, 10, "Num compteur eau : $N_compteur_eau", 0, 1, 'L');

    // Tableau détaillé de la facture
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Votre facture en detail', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 10);
    $pdf->SetLineWidth(.3);


    $totalWidth = 145; // Largeur totale du tableau (3 cellules * 45 unités chacune)
    $margin = ($pdf->getPageWidth() - $totalWidth) / 2;

    $pdf->SetX($margin);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 110, $pdf->GetY());
    $pdf->Cell(45, 10, '', 1, 0, 'C');
    $pdf->Cell(45, 10, utf8_decode('Electricité'), 1, 0, 'C');
    $pdf->Cell(45, 10, 'Eau', 1, 1, 'C');

    $pdf->SetX($margin);
    $pdf->SetLineWidth(.3);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 110, $pdf->GetY());
    $pdf->Cell(45, 10, "PU (Ar)", 1, 0, 'R');
    $pdf->Cell(45, 10, number_format($pu_elec), 1, 0, 'R');
    $pdf->Cell(45, 10, number_format($pu_eau), 1, 1, 'R');

    $pdf->SetX($margin);
    $pdf->SetLineWidth(.3);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 110, $pdf->GetY());
    $pdf->Cell(45, 10, "Valeur", 1, 0, 'R');
    $pdf->Cell(45, 10, number_format($val_elec), 1, 0, 'R');
    $pdf->Cell(45, 10, number_format($val_eau), 1, 1, 'R');

    $pdf->SetX($margin);
    $pdf->SetLineWidth(.3);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 110, $pdf->GetY());
    $pdf->Cell(45, 10, 'Total (Ar)', 1, 0, 'C');
    $pdf->Cell(45, 10, number_format($val_elec * $pu_elec), 1, 0, 'R');
    $pdf->Cell(45, 10, number_format($val_eau * $pu_eau), 1, 1, 'R');

    $pdf->SetX($margin);
    $pdf->SetLineWidth(.3);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 110, $pdf->GetY());
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, 'NET A PAYER : ', 0, 0, 'L');
    $pdf->Cell(85, 10, number_format(($val_elec * $pu_elec) + ($val_eau * $pu_eau)) . ' Ariary', 0, 0, 'L');

    // Sortie du PDF
    $pdf->Output('facture.pdf', 'I'); // Envoi direct au navigateur
    // $pdf->Output('facture.pdf', 'F'); // Sauvegarde sur le serveur
    }catch (Exception $e) {
        echo "<h1>Cette client n'etait pas encore recu de 3 facture</h1>";
    }
    

}
catch (Exception $e) {
    echo "<h1>Cette client n'etait pas encore recu de 3 facture</h1>";
}
?>







