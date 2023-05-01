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
                    <a class="nav-link active" aria-current="page" href="">Users</a>
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
        <h2 class="display-3">Sign Up</h2>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="users.php" novalidate> 
            <input type="hidden" id="insertRequest" name="POST">
            <div class="col-3">
                User ID <input class="form-control" type="number" name="uId" min="1" max="9999999999" required> 
                <div class="invalid-feedback"> Please provide a positive user ID. </div>
                First Name <input class="form-control" type="text" name="firstName" maxlength="30" required> 
                <div class="invalid-feedback"> Please provide a valid first name. </div>
                Last Name <input class="form-control" type="text" name="lastName" maxlength="30" required> 
                <div class="invalid-feedback"> Please provide a valid last name. </div>
                Address <input class="form-control" type="text" name="userAddress" maxlength="80" required> 
                <div class="invalid-feedback"> Please provide a valid address. </div>
            </div>
            <div class="col-3">
                Email <input class="form-control" type="email" name="uEmail" maxlength="320" required>
                <div class="invalid-feedback"> Please provide an email address. </div>
                Password <input class="form-control"type="password" name="uPass" maxlength="64" required>
                <div class="invalid-feedback"> Please provide a password. </div>
                Phone Number <input class="form-control" type="number" name="phoneNum"  min="1000000000" max="9999999999" required> 
                <div class="invalid-feedback"> Please provide a valid 10-digit phone number. </div>

                Select account type
                <select class="form-select" name="userType" id ="userTypeOptions" required>
                    <option  selected value="customer">Customer</option>
                    <option value="driver">Driver</option>
                </select>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Sign Up" name="insertUser">
            </div>
        </form>
    </div>

    <!-- <br>
    <br> -->

    <!-- <div class="container">
        <h2 class="display-3">Update Profile Information</h2>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="users.php" novalidate> 
            <input type="hidden" id="updateRequest" name="POST">
            <div class="col-3">
                User ID <input class="form-control" type="number" name="uId" required> 
                First Name <input class="form-control" type="text" name="firstName" required>
                Last Name <input class="form-control" type="text" name="lastName" required> 
            </div>
            <div class="col-3">
                Email <input class="form-control" type="email" name="uEmail" required>
                <div class="invalid-feedback">Please enter a valid email address</div>
                Password <input class="form-control"type="password" name="uPass" required> 
                Phone Number <input class="form-control"type="number" name="phoneNum" required>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Update Profile" name="updateUser"> 
            </div>
        </form>
    </div> -->

    <br>
    <br>

    <div class="container">
        <h2 class="display-3"> Unsubscribe Users </h2>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="users.php" novalidate> <!--refresh page when submitted-->
            <input type = "hidden" id ="handleUserDelete" name ="POST">
            <div class="col-3">
                Select Attribute <select class="form-select" name="userAttributes" id ="userAttributesTable" required>
                    <option value="userID">UserID</option>
                    <option value="firstName">First Name</option>
                    <option value="lastName">Last Name</option>
                    <option value="email">Email</option>
                    <option value="phoneNumber">Phone Number</option>
                    <!-- <option value ="Password">Password</option> -->
                </select>
            </div>
            <div class="col-3">
                Enter value <input class="form-control" type="number" min="0" name="attrValue" required>
                <div class="invalid-feedback" id="invalidFeedback"> Please enter a value to proceed </div>
            </div>
            <div class="col-12">
                <input class="btn btn-primary" type="submit" value="Unsubscribe" name="deleteUser"></p> 
            </div>
        </form>
    </div>
    <script>
        // Script to dynamically change type of input according to the selector
        const select = document.getElementById("userAttributesTable")
        const feedback = document.getElementById("invalidFeedback")
        const input = document.getElementsByName("attrValue")[0]

        select.addEventListener("change", function() {

            const selectedValue = select.value;

            if (selectedValue === "email") {
                input.type = "email"
                input.maxLength = "320"
                feedback.textContent = "Please provide a valid email address"
            } else if (selectedValue === "phoneNumber") {
                input.type = "number"
                input.min = "100000000"
                input.max = "999999999"
                input.maxLength = "64"
                feedback.textContent = "Please provide a valid 10-digit phone number"
            } else if (selectedValue === "lastName") {
                input.type = "text"
                input.maxLength = "30"
                feedback.textContent = "Please provide a last name"
            } else if (selectedValue === "firstName") {
                input.type = "text"
                input.maxLength = "30"
                feedback.textContent = "Please provide a first name"
            }  else { // userId
                input.type = "number"
                input.min = "1"
                input.max = "999999999"
                feedback.textContent = "Please provide a user ID"
            }          
        });
    </script>

    <br>
    <br>

    <div class="container">
        <!-- https://www.geeksforgeeks.org/how-to-get-multiple-selected-values-of-select-box-in-php/-->
        <h2 class="display-3"> Filter User Information </h2>
        <p class="lead">To Select multiple options: Hold down the Ctrl (windows) or Command (Mac) button.</p>
        <hr>
        <form class="row g-3 needs-validation" method="POST" action="users.php" novalidate>
        <input type = "hidden" id ="userTableLookup" name ="POST">
        <div class="col-3">
        <select class="form-select" name="Lookup[]" multiple required>
            <option value="userID">User ID</option>
            <option value="firstName">First Name</option>
            <option value="lastName">Last Name</option>
            <option value="email">Email</option>
            <option value="phoneNumber">phone Number</option>
            <option value="password">password</option>
        </select>
        <div class="invalid-feedback"> Please select a value to proceed </div>

        </div>
        <div class="col-12">
            <input class="btn btn-primary" type="submit" value="Search" name="userSearch">
        </div>
        </form>
    </div>

    <br>
    <br>

    <div class="container">
        <h2 class="display-3"> View Users </h2>
        <hr>

        <div class="row text-center">
            <div class="col">
                <form method="GET" action="users.php">
                    <input type="hidden" id="showDataRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show All Users" name="showUserData"></p>
                </form>
            </div>
            <div class="col">
                <!-- added to visualize cascade on delete user -->
                <form method="GET" action="users.php">
                    <input type="hidden" id="showCustomersRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show All Customers" name="showCustomerData"></p>
                </form>
            </div>
            <div class="col">
                <form method="GET" action="users.php">
                    <input type="hidden" id="showDriversRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show All Drivers" name="showDriverData"></p>
                </form>
            </div>
            <div class="col">
                <form method="GET" action="users.php">
                    <input type="hidden" id="showDataRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Biggest Critics" name="showDivisionResult"></p>
                </form>
            </div>

            <div class="col">
                <form method="GET" action="users.php">
                    <input type="hidden" id="showDataRequest" name="GET">
                    <input class="btn btn-primary" type="submit" value="Show Biggest Foodies" name="showNAGBResult"></p>
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