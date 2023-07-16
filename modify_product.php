<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}
if (!isset($_GET['id'])) {
    // Récupérer la liste des produits depuis la base de données
    $sql = "SELECT id, name  FROM products";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>Choisissez le produit à modifier :</h3><br>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><a class=\"pre\" href='modify_product.php?id=" . $row['id'] . "'>" . $row['name'] . "</a></li><br>";
        }
    } else {
        echo "Aucun produit trouvé.";
    }
}
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Récupérer les données du produit

        $name = $row['name'];
        $price = $row['price'];
        $image = $row['img'];


        // Display the form
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <style>
                h3 {
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                    font-size: x-large;
                }

                .pre {
                    color: black;
                    cursor: pointer;
                }

                a {
                    font-family: Verdana, Geneva, Tahoma, sans-serif;
                    text-decoration: none;
                }
            </style>
        </head>

        <body>
            <form action="modify_product.php" method="post">
                <input type="hidden" name="id" value="<?php echo $productId; ?>"> <br>
                <input type="text" name="name" value="<?php echo $name; ?>" style="border-radius: 12px; height: 40px ;border: 1px solid; width: 800px;"> <br> <br>
                <input type="text" name="price" value="<?php echo $price; ?>" style="border-radius: 12px; height: 40px; border: 1px solid; width: 800px;"><br> <br>
                <input type="text" name="image" value="<?php echo $image; ?>" style="border-radius: 12px; height: 40px ;border: 1px solid;width: 800px;"><br> <br>
                <input type="submit" value="Modifier" style="border-radius: 18px; width: 90px;  height: 30px; border: 1px solid;
                background-color: blue; border: 1px solid blue; color:antiquewhite"><br>
            </form>
        </body>

        </html>
<?php
    } else {
        echo "Aucun produit trouvé avec l'ID : " . $productId;
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>

<?php
// Récupération des valeurs du formulaire
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion à la base de données : " . $conn->connect_error);
    }

    // Requête de mise à jour du produit
    $query = "UPDATE products SET name = '$name', price = '$price', img = '$image' WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // La mise à jour a réussi
        // Rediriger vers la page qui affiche la liste des produits ou afficher un message de succès
        header('Location: index.php');
        exit;
    } else {
        // La mise à jour a échoué
        // Gérer l'erreur ou afficher un message d'erreur
        echo "Erreur lors de la mise à jour du produit.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>