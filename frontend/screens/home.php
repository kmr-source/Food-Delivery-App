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
                    <a class="nav-link active" aria-current="page" href="">Home</a>
                    <a class="nav-item nav-link" href="users.php">Users</a>
                    <a class="nav-item nav-link" href="restaurants.php">Restaurants</a>
                </div>
            </div>
        </div>
    </nav>

    <br>
    <br>
    <br>
    <br>

    <div class="container">
        <h1 class="display-1">
            Welcome to Food App
        </h1>
        <p class="lead">
            Food Delivery Application will be the domain for our project. The domain will
            focus on customer and delivery management logistics, primarily on the data exchanged
            between the users and restaurants. The goal of our project is to identify how long
            it takes on average for a food order to be placed, prepared, and delivered from a
            restaurant to its customers, as well as how payments are made by customers and
            received by the restaurants and drivers. Customers can also provide feedback to restaurants.
            Orders can also have complaints made by the user. 
        </p>
    </div>

    <br>
    <br>

    <div class="container">
        <h2 class="display-3"> Explore Our Services </h2>
        <p class="lead">First select the service and then select one or more pieces of information regarding that service.</p>
        <hr>
        <form class="row g-3 needs-validation" method ="POST"  action="home.php" novalidate>
            <input type = "hidden" id ="userTableLookup" name ="POST">
            <div class="col-3">
                Service <select class="form-select" name="tables2" id="tables2" required>
                    <option value="" selected="selected">Select Option</option>
                </select>
                <div class="invalid-feedback"> Please select a value to proceed </div>
                <br>
                Information <select class="form-select" name="attributes2[]" id="attributes2" multiple required>
                    <option disabled value="">Please select option first</option>
                </select>
                <div class="invalid-feedback"> Please select a value to proceed </div>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Submit" name ="userProjectionTest">
            </div>
        </form>
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

        //https://www.w3schools.com/howto/howto_js_cascading_dropdown.asp CREDIT
        var tableObject = {
            "Customer": {
                "userID": [],
                "numOrders": [],
                "address": []
            },
            "Users": {
                "userID": [],
                "password": [],
                "firstName": [],
                "lastName":[],
                "email":[],
                "phoneNumber":[],
            },
            "Driver": {
                "userID": [],
                "numDeliveries": [],
            },
            "TrackingTable_1": {
                "status": [],
                "endTime": [],
            },
            "TrackingTable_2": {
                "startTime": [],
                "endTime": [],
                "duration":[],
            },
            "TrackingTable_3": {
                "trackingID": [],
                "endTime": [],
                "startTime": [],
            },
            "OrderTable_1": {
                "deliveryFee": [],
                "orderType": [],
            },
            "OrderTable_2": {
                "orderType": [],
                "subtotal": [],
                "totalAmount": [],
            },
            "OrderTable_3": {
                "orderID": [],
                "Customer_userID": [],
                "Driver_userID": [],
                "trackingID":[],
                "orderType":[],
                "subtotal":[],
            },
            "Complain_Regarding": {
                "complainID": [],
                "details": [],
                "orderID": [],
                "userID":[],
            },
            "RestaurantTable_1": {
                "name": [],
                "logo": [],
            },
            "RestaurantTable_2": {
                "location": [],
                "name": [],
                "overallRating": [],
            },
            "RestaurantTable_3": {
                "location": [],
                "phoneNum": [],
            },
            "RestaurantTable_4": {
                "restaurantID": [],
                "manager": [],
                "phoneNum": [],
            },
            "Menu_Item": {
                "itemID": [],
                "restaurantID": [],
                "itemName": [],
                "itemID": [],
                "description": [],
                "price": [],
                "quantity":[],
            },
            "Feedback_Gives": {
                "feedbackID": [],
                "rating": [],
                "review": [],
                "userID": [],
                "restaurantID": [],
            },
            "Contains": {
                " orderID": [],
                "itemID": [],
                "restaurantID": [],
            },
            "PaymentTable_1": {
                "amount": [],
                "tax": [],
            },
            "PaymentTable_2": {
                "paymentID": [],
                "amount": [],
                "paymentDate": [],
                "userID": [],
                "restaurantID": [],
            },

        }

        window.onload = function() {
            var tableSel = document.getElementById("tables2");
            var attSel = document.getElementById("attributes2");
            for (var x in tableObject) {
                tableSel.options[tableSel.options.length] = new Option(x, x);
            }
            tableSel.onchange = function() {
                //empty att
                attSel.length = 1;
                //display values

                for (var y in tableObject[this.value]) {
                    attSel.options[attributes2.options.length] = new Option(y, y);
                }
            }
        }
    </script>
</body>
</html>