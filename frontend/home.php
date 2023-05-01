
<html>
    <head>
        <title>FoodApp</title>
        <script>
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
                    "complainID ": [],
                    "details": [],
                    "orderID ": [],
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
                    "phoneNum ": [],
                },
                "RestaurantTable_4": {
                    "restaurantID": [],
                    "manager ": [],
                    "phoneNum ": [],
                },
                "Menu_Item": {
                    "itemID": [],
                    "restaurantID": [],
                    "itemName": [],
                    "itemID": [],
                    "description ": [],
                    "price": [],
                    "picture":[],
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
                    "itemID ": [],
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
    </head>

    <body>

        <!-- <form method="POST" action="mysql-test.php"> -->
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <!-- <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr /> -->
        <h1>Food App</h1>

        <h2>Insert Values into Users</h2>
        <form method="POST" action="home.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertRequest" name="POST">
            id: <input type="text" name="uId"> <br /><br />
            password: <input type="text" name="uPass"> <br /><br />
            first: <input type="text" name="firstName"> <br /><br />
            last: <input type="text" name="lastName"> <br /><br />
            email: <input type="text" name="uEmail"> <br /><br />
            number: <input type="text" name="phoneNum"> <br /><br />
            <input type="submit" value="Insert" name="insertUser"></p>
        </form>

        <hr />

        <h2>Update User by ID</h2>
        <form method="POST" action="home.php"> <!--refresh page when submitted-->
            <input type="hidden" id="updateRequest" name="POST">
            id: <input type="text" name="uId"> <br /><br />
            password: <input type="text" name="uPass"> <br /><br />
            first: <input type="text" name="firstName"> <br /><br />
            last: <input type="text" name="lastName"> <br /><br />
            email: <input type="text" name="uEmail"> <br /><br />
            number: <input type="text" name="phoneNum"> <br /><br />
            <input type="submit" value="Update" name="updateUser"></p>
        </form>

        <hr />

        <!-- <h2> Enter UserID to delete  </h2>
        <form method ="POST" action = "home.php">
            <input type = "hidden" id ="handleUserDelete" name ="POST">
            userID: <input type="text" name ="userID"> <br/><br/>
            <input type ="submit" value="Delete" name="deleteUser"></p>
        </form> -->

        <h2>User Delete</h2>
        <form method="POST" action="home.php"> <!--refresh page when submitted-->
            <input type = "hidden" id ="handleUserDelete" name ="POST">
            <!-- attribute:  -->
            attribute: <select name="userAttributes" id ="userAttributesTable">
                <option value="userID">UserID</option>
                <option value="firstName">First Name</option>
                <option value="lastName">Last Name</option>
                <option value="email">Email</option>
                <option value="phoneNumber">Phone Number</option>
                <!-- <option value ="Password">Password</option> -->
            </select>
            value: <input type="text" name="attrValue">
            <input type="submit" value="Delete" name="deleteUser"></p>
        </form>

        <hr/>

        <hr />

        <!-- Restaurant LOCATION LOOKUP USING NAME FIELD ... FOR WHERE (SELECTION)-->
        <h2> Enter Restaurant name to find the Name & locations </h2>
        <form method ="POST" action = "home.php">
            <input type = "hidden" id ="restaurantLookup" name ="POST">
            Restaurant Name: <input type="text" name ="name"> <br/><br/>
            <input type ="submit" name="restaurantLookup"></p>
        </form>

        <h2> Enter Restaurant location to find the name of the Restaurant  </h2>
        <form method ="POST" action = "home.php">
            <input type = "hidden" id ="restaurantLookupByLocation" name ="POST">
            Restaurant location: <input type="text" name ="location"> <br/><br/>
            <input type ="submit" name="restaurantLookupByLocation"></p>
        </form>

        <h2> Search for the  Restaurant by Name, location, manger, phone Number, Rating or restaurantID </h2>
        <p> Choose one or more of the following items to search by </p>
        <form method ="POST" action = "home.php">
            <input type = "hidden" id ="restaurantLookupByLocation" name ="POST">
            Restaurant Location: <input type="text" name ="location"> <br/><br/>
            Restaurant Name: <input type="text" name ="name"> <br/><br/>
            Restaurant Manger: <input type="text" name ="manger"> <br/><br/>
            Restaurant phone Number: <input type="text" name ="phoneNum"> <br/><br/>
            Restaurant Rating: <input type="text" name ="overallRating"> <br/><br/>
            Restaurant ID: <input type="text" name ="rID"> <br/><br/>
            <input type ="submit" name="restaurantLookupByLocation2"></p>
        </form>

        <!-- Join -->
        <h2> Get all restaturants that serve a specific item</h2>
        <form method ="POST" action = "home.php">
            <input type = "hidden" id ="itemRestaurants" name ="POST">
            ItemName: <input type="text" name ="itemName"> <br /><br />
            <input type ="submit" value="Search" name="showItemRestaurants"></p>
        </form>

        <!-- Aggregation with GROUP BY and HAVING -->
        <h2>Show number of orders for each customer who placed at least 1 order above a specific amount</h2>
        <form method="POST" action="home.php">
            <input type="hidden" id="showNumOrders" name="POST">
            orderTotal: <input type="text" name ="orderTotal"> <br /><br />
            <input type="submit" name="showCustomersOrders"></p>
        </form>

        <!-- https://www.geeksforgeeks.org/how-to-get-multiple-selected-values-of-select-box-in-php/-->
        <h2> Finding User Information Projection  </h2>
        <p>To Select multiple options: Hold down the Ctrl (windows) or Command (Mac) button.</p>
        <form method="POST" action="home.php"> <!--refresh page when submitted-->
        <input type = "hidden" id ="userTableLookup" name ="POST">
           <select name="Lookup[]" multiple>
               <option value="userID">User ID</option>
               <option value="firstName">First Name</option>
               <option value="lastName">Last Name</option>
               <option value="email">Email</option>
               <option value="phoneNumber">phone Number</option>
               <option value="password">password</option>
           </select>
           <input type="submit" value="search" name="userSearch"></p>
        </form>

        <hr/>

        <!-- FOR CREDIT PROJECTION QUERY -->
        <h2>Projection of Tables</h2>
        <form method="POST" action="home.php"> <!--refresh page when submitted-->
            <input type = "hidden" id ="projectionLookup" name ="POST">
            TABLES: <select name="tables" id ="tables">
                <option value="Users">Users</option>
                <option value="Driver">Drivers</option>
                <option value="Customer">Customers</option>
                <option value="Orders">Orders</option>
                <option value="Tracking for Orders">Tracking</option>
                <option value ="Complaints">Complaints</option>
                <option value ="Restaurant">Restaurants</option>
                <option value ="Menu_Item">Menu Items</option>
                <option value ="Feedback_Gives">Feedbacks</option>
                <option value ="Payments">Payments</option>
                <option value ="Contains">Payments</option>
            </select>
            Attributes: <input type="text" name="attributes">
            <input type="submit" value="search" name="projectionSearch"></p>
        </form>

        <!-- PROJECTION OF ALL TABLES FINAL VERSION credit : //https://www.w3schools.com/howto/howto_js_cascading_dropdown.asp CREDIT-->
        <h2> PROJECTION ALL TABLES </h2>
        <form method ="POST"  action="home.php">
            <input type = "hidden" id ="userTableLookup" name ="POST">
            Options: <select name="tables2" id="tables2">
                <option value="" selected="selected">Select Option</option>
            </select>
            <input type = "hidden" id ="userTableLookup" name ="POST">
            <br><br>
            Attributes: <select name="attributes2[]" id="attributes2" multiple>
                <option value="" selected="selected">Please select option first</option>
            </select>
            <br><br>
            <input type="submit" value="Submit" name = "userProjectionTest">
        </form>

        <hr/>


        <!-- buttons for tables </h2>

        -- <h2>Update Name in DemoTable</h2> --
        <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

        <form method="POST" action="mysql-test.php">
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Old Name: <input type="text" name="oldName"> <br /><br />
            New Name: <input type="text" name="newName"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <hr /> -->

        <h2>Show Users Table</h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showDataRequest" name="GET">
            <input type="submit" name="showUserData"></p>
        </form>


        <!-- added to visualize cascade on delete user -->
        <h2>Show Customers Table</h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showCustomersRequest" name="GET">
            <input type="submit" name="showCustomerData"></p>
        </form>
 
        <h2>Show Drivers Table</h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showDriversRequest" name="GET">
            <input type="submit" name="showDriverData"></p>
        </form>

         <h2>Show Restaurants</h2>
         <form method="GET" action="home.php">
            <input type="hidden" id="showDataRestaurant" name="GET">
             <input type="submit" name="showResData"></p>
        </form>

        <!-- Aggregation with GROUP BY -->
        <h2>Show Number of Menu Items per Restaurant</h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showDataRequest" name="GET">
            <input type="submit" name="showMenuItemCountData"></p>
        </form>
 
        <!-- Division -->
        <h2>Find all users who gave feedback to all restaturants </h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showDataRequest" name="GET">
            <input type="submit" name="showDivisionResult"></p>
        </form>

        <!-- NESTED Aggregation with GROUP BY -->
        <h2>Find the name of the Customer who placed the Highest number of Orders </h2>
        <form method="GET" action="home.php">
            <input type="hidden" id="showDataRequest" name="GET">
            <input type="submit" name="showNAGBResult"></p>
        </form>



        <?php 
            include "../backend/router.php";
            handleRequest();
        ?>
	</body>
</html>