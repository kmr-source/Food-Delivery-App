<?php 
    include 'handlers.php';
    include 'connect.php';

    /**
     * handles POST and GET requests
     */
    function handleRequest() {
        if (isset($_POST['POST'])) {
            handlePOST();
        } else if (isset($_GET['GET'])) {
            handleGET();
        }
    }

    /**
     * function to handle all POST routes
     */ 
    function handlePOST() {
        if (connectToDB()) {
            
            // inserts
            if (array_key_exists('insertUser', $_POST)) {
                handleInsertRequest();
            }

            // updates
            if (array_key_exists('updateUser', $_POST)) {
                handleUpdateRequest();
            }


            if (array_key_exists('deleteUser', $_POST)) {
                handleDeleteRequest();
            }

            //SELECTION
            if ( array_key_exists("restaurantLookupByLocation2",$_POST)) {
                handleRestaurantRequest();
            }

            if(array_key_exists("userSearch", $_POST)){
                handleSearchUserRequest();
            }

            if(array_key_exists("menuFilterSearch", $_POST)){
                handleMenuFilterSearchRequest();
            }

            // Join
            if(array_key_exists("showItemRestaurants", $_POST)){
                handleJoinRequest();
            }

            // if(array_key_exists("showRatingRestaurants", $_POST)){
            //     handleHavingRequest();
            // }

            //Having Request
            if(array_key_exists("showCustomersOrders", $_POST)){
                handleHavingRequest();
            }

            // PROJECTION ALL TALBES requirement
            if(array_key_exists("userProjectionTest", $_POST)){
                handleSearchUserRequest2();
            }

            // UPDATE QUERY
            if(array_key_exists("updateMenu", $_POST)){
                handleUpdateDeleteMenuItem(0);
            }

            // Delete Query
            if(array_key_exists("deleteMenu", $_POST)){
                handleUpdateDeleteMenuItem(1);
            }
        }

        disconnectFromDB();
    }

    /**
     * function to handle all GET routes
     */
    function handleGET() {
        if (connectToDB()) {
            if (array_key_exists('showUserData', $_GET)) {
                $res = runSQL(" SELECT * FROM Users");
                printTable('Users', $res);
            }

            if (array_key_exists('showCustomerData', $_GET)) {
                $res = runSQL(" SELECT Users.firstName, Users.lastName, Customer.numOrders, Customer.address
                                FROM Customer
                                INNER JOIN Users ON Customer.userID = Users.userID");
                printTable('Customers', $res);
            }

            if (array_key_exists('showDriverData', $_GET)) {
                $res = runSQL(" SELECT Users.firstName, Users.lastName, Driver.numDeliveries
                                FROM Driver
                                INNER JOIN Users ON Driver.userID = Users.userID
                            ");
                printTable('Drivers', $res);
            }

            if(array_key_exists('showMenuData',  $_GET)){
                $res = runSQL("SELECT * FROM Menu_Item");
                printTable('Menu Items', $res);
            }
            
            if(array_key_exists('showOrdersData',  $_GET)){
                $res = runSQL("SELECT * FROM Contains");
                printTable('Orders', $res);               
            }

            if (array_key_exists('showResData', $_GET)) {
                $res = runSQL(" SELECT r2.location, r1.name
                                FROM  RestaurantTable_2 r2, RestaurantTable_1 r1
                                WHERE r1.name = r2.name");
                printTable('Restaurants', $res);
            }
            
            // show number of items per restaurant
            if (array_key_exists('showMenuItemCountData', $_GET)){
                $res = runSQL(" WITH temp (resID, count) as 
                                    (
                                        SELECT restaurantID,  COUNT(*) AS Items
                                        FROM Menu_Item
                                        GROUP BY restaurantID
                                    )
                                    SELECT RestaurantTable_2.name, count
                                    FROM temp 
                                    INNER JOIN RestaurantTable_4 ON temp.resID = RestaurantTable_4.restaurantID
                                    INNER JOIN RestaurantTable_3 ON RestaurantTable_4.phoneNum = RestaurantTable_3.phoneNum
                                    INNER JOIN RestaurantTable_2 ON RestaurantTable_3.location = RestaurantTable_2.location
                            ");
                printTable('Number of Items', $res);
            }



            // Nested Aggregation Group by
            if(array_key_exists('showNAGBResult',$_GET)){
                // echo "start....";
                $res = runSQL("Select c.userID, avg(c.numOrders) as avg 
                                    From customer c , Users u
                                    GROUP BY  c.userID Having avg(c.numOrders)>all(Select Min(c2.numOrders) as min 
                                                        From Customer c2, Users u2 
                                                        Where u2.userID = c2.userID)");
                printTable('Biggest Foodies Supporters', $res);
            }
            
            // users that gave feedback to all restaurants
            if (array_key_exists('showDivisionResult', $_GET)){
                $res = runSQL(" SELECT U.userID, U.firstName, U.lastName, U.email, u.phoneNumber
                                FROM Users U
                                WHERE NOT EXISTS(
                                    SELECT restaurantID
                                    FROM RestaurantTable_4 R
                                    WHERE NOT EXISTS(
                                        SELECT feedbackID
                                        FROM Feedback_Gives F
                                        WHERE F.userID=U.userID AND F.restaurantID=R.restaurantID ))");
                printTable('Biggest Critics', $res);
            }

        }

        disconnectFromDB();
    }
?>