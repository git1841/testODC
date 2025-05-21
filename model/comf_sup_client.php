<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de suppression</title>
</head>
<body>
  <script>
    function confirmerSuppression() {
      const confirmation = confirm("Es-tu sûr de vouloir supprimer ?");
      if (confirmation) {
        window.location.href = "sup.php"; // Redirection si OUI
      } else {
        window.location.href = "ok.php";  // Redirection si NON
      }
    }
    confirmerSuppression()
  </script>
</body>
</html>
