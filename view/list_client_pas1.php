<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche de Clients</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 50px;
            background-color: #f7f7f7;
            color: #333;
        }

        h2 {
            color: #388e3c;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8em;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 128, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #388e3c;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #388e3c;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2e7d32;
        }

        button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <h2>Recherche de Clients qui n'ont pas encore payé ce mois</h2>
    <form action="../model/list_client_pas2.php" method="GET">
        <label for="mois">Choisissez un mois :</label>
        <select id="mois" name="mois" required>
            <option value="1">Janvier</option>
            <option value="2">Février</option>
            <option value="3">Mars</option>
            <option value="4">Avril</option>
            <option value="5">Mai</option>
            <option value="6">Juin</option>
            <option value="7">Juillet</option>
            <option value="8">Août</option>
            <option value="9">Septembre</option>
            <option value="10">Octobre</option>
            <option value="11">Novembre</option>
            <option value="12">Décembre</option>
        </select>
        <button type="submit">Soumettre</button>
    </form>
</body>
</html>
