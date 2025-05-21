<?php
   include_once "connect.php"; // Connexion à la base de données



   if (!isset($_GET['confirm'])) {
    $codecompteur = isset($_GET['codecompteur']) ? $_GET['codecompteur'] : '';
    echo "
    <script>
      if (confirm('Es-tu sûr de vouloir supprimer ce compteur ?')) {
        window.location.href = '?codecompteur=" . $codecompteur . "&confirm=1';
      } else {
        window.location.href = '../view/compteur.php';
      }
    </script>
    ";
    exit;
}






   // Récupérer l'ID du client à supprimer depuis l'URL
   $codecompteur = isset($_GET['codecompteur']) ? $_GET['codecompteur'] : '';

   if (!empty($codecompteur)) {
       // Préparer et exécuter la requête SQL pour supprimer le client
       $sql = "DELETE FROM COMPTEUR WHERE codecompteur = ?";
       
       // Utiliser une requête préparée pour éviter les injections SQL
       $stmt = mysqli_prepare($conn, $sql);
       
       if ($stmt) {
           // Liaison du paramètre à l'énoncé préparé
           mysqli_stmt_bind_param($stmt, "s", $codecompteur);
           
           // Exécuter la requête préparée
           if (mysqli_stmt_execute($stmt)) {
               echo "Client supprimé avec succès.";
           } else {
               echo "Erreur lors de la suppression du client : " . mysqli_error($conn);
           }
           
           // Fermer l'énoncé
           mysqli_stmt_close($stmt);
       } else {
           echo "Erreur dans la préparation de la requête : " . mysqli_error($conn);
       }
   } else {
       echo "Aucun ID de client spécifié.";
   }


   if (!empty($codecompteur)) {
    // Préparer et exécuter la requête SQL pour supprimer le client
    $sql = "DELETE FROM EAU WHERE codecompteur = ?";
    
    // Utiliser une requête préparée pour éviter les injections SQL
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // Liaison du paramètre à l'énoncé préparé
        mysqli_stmt_bind_param($stmt, "s", $codecompteur);
        
        // Exécuter la requête préparée
        if (mysqli_stmt_execute($stmt)) {
            echo "Client supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du client : " . mysqli_error($conn);
        }
        
        // Fermer l'énoncé
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "Aucun ID de client spécifié.";
}


if (!empty($codecompteur)) {
    // Préparer et exécuter la requête SQL pour supprimer le client
    $sql = "DELETE FROM ELEC WHERE codecompteur = ?";
    
    // Utiliser une requête préparée pour éviter les injections SQL
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // Liaison du paramètre à l'énoncé préparé
        mysqli_stmt_bind_param($stmt, "s", $codecompteur);
        
        // Exécuter la requête préparée
        if (mysqli_stmt_execute($stmt)) {
            echo "Client supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression du client : " . mysqli_error($conn);
        }
        
        // Fermer l'énoncé
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur dans la préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "Aucun ID de client spécifié.";
}



   // Rediriger vers la page de liste des clients après la suppression
   header("Location: ../view/compteur.php");
   exit;
   ?>
