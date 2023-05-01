<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
</head>
<body>
<nav class="navbar fixed-top navbar-expand-md bg-dark fs-3" data-bs-theme="dark">
    <div class="container-fluid">
                <a class="navbar-brand fs-3" href="">Food App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#expandableButton" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="expandableButton">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="home.php">Home</a>
                    <a class="nav-item nav-link" href="users.php">Users</a>
                    <a class="nav-link active" aria-current="page" href="">Restaurants</a>
                </div>
            </div>
        </div>
    </nav>

    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <h2 class="display-3">Search Restaurant</h2>
        <p class="lead"> Choose one or more of the following items to search by </p>
        <hr>
        <form class="row g-3" method="POST" action="restaurants.php"> 
            <input type="hidden" id="insertRequest" name="POST">
            <div class="col-3">
                Restaurant Location <input class="form-control" type="text" maxlength="80" name="location">
                <div class="invalid-feedback"> Please provide a restaurant location </div>
                Restaurant Name <input class="form-control" type="text" name="name" maxlength="30"> 
                <div class="invalid-feedback"> Please provide a name for the restaurant </div>
                Restaurant Manager <input class="form-control" type="text" name="manger" maxlength="30"> 
                <div class="invalid-feedback"> Please provide a name for the restaurant manager</div>
            </div>
            <div class="col-3">
                Restaurant Phone Number <input class="form-control" type="text" name="phoneNum" min="1000000000" max="9999999999"> 
                <div class="invalid-feedback"> Please provide a phone number for the restaurant. </div>
                Restaurant Rating <input class="form-control" type="number" name="overallRating" step="0.1" min="0" max="5.0">
                <div class="invalid-feedback"> Please provide a rating for this restaurant</div>
                Restaurant ID <input class="form-control" type="number" name="rID" min="1" max="9999999999"> 
                <div class="invalid-feedback"> Please provide an ID for this restaurant</div>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Search" name="restaurantLookupByLocation2">
            </div>
        </form>
    </div>

    <br>
    <br>

    <div class="container">
        <h2 class="display-3">Search Menu Items</h2>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="restaurants.php" novalidate> 
            <input type = "hidden" id ="itemRestaurants" name ="POST">
            <div class="col-3">
                Item Name <input class="form-control" type="text" name ="itemName" maxlength="30" required>
                <div class="invalid-feedback"> Please enter a value to proceed </div> 
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Search" name="showItemRestaurants">
            </div>
        </form>
    </div>

    <br>
    <br>


    <div class="container">
        <h2 class="display-3">Update Menu Item</h2>
        <p class="lead"> You must enter the correct item number and restaurant ID to update the item. </p>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="restaurants.php" novalidate>
            <input type="hidden" id="updateRequest" name="POST">
            <div class="col-3">
                Old Item ID <input class="form-control" type="number" min="1" max="9999999999" name="itemID" required>
                Old Restaurant ID  <input class="form-control" type="number" min="1" max="9999999999" name="restaurantID" required>
                Item Name  <input class="form-control" type="text" name="itemName">
                Description <input class="form-control" type="text" name="description">
            </div>
            <div class="col-3">
                New Item ID <input class="form-control" type="number" name="newItemID" min="1" max="9999999999">
                New Restaurant ID  <input class="form-control" type="number" name="newRestaurantID" min="1" max="9999999999">
                Price <input class="form-control"type="number" name="price" step="0.01">
                Quantity <input class="form-control"type="number" name="quantity">
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Update Menu" name="updateMenu">
            </div>
        </form>
    </div>

    <br>
    <br>

    <div class="container">
        <h2 class="display-3">Delete Menu Item</h2>
        <p class="lead"> You must enter the correct item number and restaurant ID to delete the item. </p>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="restaurants.php" novalidate>
            <input type="hidden" id="deleteRequest" name="POST">
            <div class="col-3">
                Item ID <input class="form-control" type="number" name="itemID" min="1" max="9999999999">
                Restaurant ID  <input class="form-control" type="number" name="restaurantID" min="1" max="9999999999">
                Item Name  <input class="form-control" type="text" name="itemName">
            </div>
            <div class="col-3">
                Description <input class="form-control" type="text" name="description">
                Price <input class="form-control"type="number" name="price" min="0" step="0.1">
                Quantity <input class="form-control"type="number" name="quantity" min="0">
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Delete Menu" name="deleteMenu">
            </div>
        </form>
    </div>


    <br>
    <br>

    <div class="container">
        <h2 class="display-3">Big Spenders</h2>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="restaurants.php" novalidate> 
            <input type = "hidden" id ="showNumOrders" name ="POST">
            <div class="col-3">
                Enter Order Total <input class="form-control" type="number" name ="orderTotal" min="0" max="999999" step="0.1" required> 
                <div class="invalid-feedback"> Please enter a valid price to proceed </div>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Search" name="showCustomersOrders">
            </div>
        </form>
    </div>

    <br>
    <br>

    <div class="container">
        <!-- https://www.geeksforgeeks.org/how-to-get-multiple-selected-values-of-select-box-in-php/-->
        <h2 class="display-3"> Filter Menu Items </h2>
        <p class="lead">To Select multiple options: Hold down the Ctrl (windows) or Command (Mac) button.</p>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="restaurants.php" novalidate>
        <input type = "hidden" id ="userTableLookup" name ="POST">
        <div class="col-3">
        <select class="form-select" name="menuLookup[]" multiple required>
            <option value="itemID">Item ID</option>
            <option value="restaurantID">Restaurant ID</option>
            <option value="itemName">Item Name</option>
            <option value="description">Description</option>
            <option value="price">Price</option>
            <option value="quantity">Quantity</option>
        </select>
        <div class="invalid-feedback"> Please select a value to proceed </div>
        </div>
        <div class="col-12">
            <input class="btn btn-primary" type="submit" value="Search" name="menuFilterSearch">
        </div>
        </form>
    </div>

    <br>
    <br>

    <div class="container">
        <h2 class="display-3"> Explore </h2>
        <hr>

        <div class="row text-center">
            <div class="col">
                <form method="GET" action="restaurants.php">
                    <input type="hidden" id="showDataRestaurant" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Restaurants" name="showResData">
                </form>
            </div>  
            <div class="col">
                <form method="GET" action="restaurants.php">
                    <input type="hidden" id="showMenuData" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Menu Items" name="showMenuData">
                </form>
            </div>  
            <div class="col">
                <form method="GET" action="restaurants.php">
                    <input type="hidden" id="showOrdersData" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Orders" name="showOrdersData">
                </form>
            </div>  
            <div class="col">
                <form method="GET" action="restaurants.php">
                    <input type="hidden" id="showDataRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Total Items Per Restaurant" name="showMenuItemCountData"></p>
                </form>
            </div>  
        </div>
    </div>

    <br>

    <?php 
        include "../../backend/router.php";
        handleRequest();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
                }, false)

            })
        })()
    </script>
</body>
</html>