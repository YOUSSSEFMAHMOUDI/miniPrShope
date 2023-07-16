<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Shopping Cart</title>
    <style>
        .product-card {
            margin-bottom: 20px;
           
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .delete-button{
            float: right;
            cursor: pointer;
            color: red;
        }
        
    </style>
</head>

<body>
    <div class="container">
        <a href="./admin.php" class="btn btn-success">AddProduct</a>
        <a href="./modify_product.php" class="btn btn-primary">ModifProduct</a>
        
        <h1>Product List</h1>
        <div class="row">
            <?php
            include_once('db.php');
            // Retrieve products from the database
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            // Generate product cards based on the retrieved data
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $name = $row['name'];
                    $price = $row['price'];
                    $image = $row['img'];

                    echo '<div class="col-md-4">';
                    echo '<div class="card product-card">';
                    echo '<img class="card-img-top" src="' . $image . '" alt="' . $name . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $name . '</h5>';
                    echo '<p class="card-text">Price: $' . $price . '</p>';
                    echo '<div class="input-group">';
                    echo '<input type="number" class="form-control quantity" value="1" min="1">';
                    echo '<div class="input-group-append">';
                    echo '<button class="btn btn-primary add-to-cart" data-name="' . $name . '" data-price="' . $price . '">Add to Cart</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No products found.";
            }

            // Close the database connection
            $conn->close();
            ?>
     
        </div>
        <hr>
        <h2>Shopping Cart</h2>
        <ul id="cart" class="list-group"></ul>
        

        <p id="total">Total: $0</p>
        
    </div>

    <script>
        
document.addEventListener("DOMContentLoaded", function() {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const cart = document.getElementById("cart");
  const total = document.getElementById("total");
  let cartTotal = 0;

  addToCartButtons.forEach(button => {
    button.addEventListener("click", addToCart);
  });

  cart.addEventListener("click", removeItem);

  function addToCart(event) {
    const button = event.target;
    const name = button.getAttribute("data-name");
    const price = button.getAttribute("data-price");
    const quantity = button.parentElement.previousElementSibling.value;

    const listItem = document.createElement("li");
    listItem.classList.add("list-group-item");

    const itemInfo = document.createElement("span");
    itemInfo.textContent = `${name} - $${price} x ${quantity}`;
    listItem.appendChild(itemInfo);

    const deleteButton = document.createElement("span");
    deleteButton.innerHTML = "Remove";
    deleteButton.classList.add("delete-button");
    listItem.appendChild(deleteButton);

    cart.appendChild(listItem);

    const itemTotal = parseFloat(price) * parseInt(quantity);
    cartTotal += itemTotal;

    total.textContent = `Total: $${cartTotal}`;

    button.parentElement.previousElementSibling.value = 1;
  }

  function removeItem(event) {
    const item = event.target;
    if (item.classList.contains("delete-button")) { // Vérifie si l'élément est un bouton de suppression
      const listItem = item.parentElement;
      const itemInfo = listItem.firstChild.textContent;
      const itemTotal = parseFloat(itemInfo.match(/\$\d+(\.\d+)?/)[0].substring(1));

      cart.removeChild(listItem);

      cartTotal -= itemTotal;
      total.textContent = `Total: $${cartTotal}`;
    }
  }
});
    </script>
</body>

</html>