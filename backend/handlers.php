<?php
$hasErr = 0;

/**
 * executes a SQL command
 */
function runSQL($cmd) {
    global $db_conn, $success;

    $stmt = OCIParse($db_conn, $cmd);

    if (!$stmt) {
        echo "<br>Cannot parse this cmd: " . $cmd . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    $r = OCIExecute($stmt, OCI_DEFAULT);
    if (!$r) {
        // echo "<br>Cannot execute this cmd: " . $cmd . "<br>";
        $e = oci_error($stmt);
        // echo htmlentities($e['message']);
        showErrorMessage($e, $cmd);
        $success = False;
    } else {
        $success = true;
    }

    return $stmt;
}

/**
 * takes a list of inputs and input
 * types and binds them to reusable sql
 */
function runBoundSQL($cmdstr, $list) {
    global $db_conn, $success;

    $stmt = OCIParse($db_conn, $cmdstr);

    if (!$stmt) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = False;
    }

    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {

            OCIBindByName($stmt, $bind, $val);
            unset ($val);
        }

        $r = OCIExecute($stmt, OCI_DEFAULT);
        if (!$r) {
            // echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($stmt);
            // echo htmlentities($e['message']);
            // showErrorMessage($e);
            $success = False;
            return $e;
        } else {
            $success = true;
        }

        return null;
    }
}

function printTable($heading, $data) {

    echo "<div class = \"container table-responsive\"><h2 class= \"display-3\"> $heading </h2>";
    echo "<table class= \"table text-center table-bordered table-hover table-dark\">";

    $topRow = "<tr>";

    $num_cols = OCI_Num_Fields($data); // gets the number of columns in a statement

    for ($i = 1; $i <= $num_cols; ++$i) {
        $colname = OCI_Field_Name($data, $i); // gets the the name of the column at a specific index
        $topRow .= "<th>" . $colname . "</th>";
    }
    $topRow .= "</tr>";
    echo $topRow;

    while ($row_arr = OCI_Fetch_Array($data, OCI_BOTH)) { // fetch array returns a row from the query
        $row = "<tr>";
        for ($i = 0; $i < $num_cols; ++$i) {
            $row .= "<td class=\"w-15\">" . $row_arr[$i] . "</td>";
        }
        $row .= "</tr>";
        echo $row;
    }

    echo "</table></div>";
    echo "<script>window.scrollTo(0, document.body.scrollHeight)</script>";
}

function createNotification($heading, $message, $success){
    if ($success){
        echo '
                <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">'.$heading.'</h4>
                    '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                </div>
                <script>
                    window.scrollTo(0, document.body.scrollHeight);
                </script>
                ';
    }
    else{
        echo'
                <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">'.$heading.'</h4>
                    '.$message.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                </div>
                <script>
                    window.scrollTo(0, document.body.scrollHeight);
                </script>
                ';
    }
}

function showErrorMessage($err, $cmd) {
    $err_code = $err['code'];

    global $hasErr;

    if (str_contains($cmd, "UPDATE")) {
        switch ($err_code) {
            case 1: {
                $hasErr = 1;
                createNotification("Error encountered!", "Cannot update with the new IDs since they already exist", false);
                break;
            }
            case 2292: {
                $hasErr = 1;
                createNotification("Error encountered!", "Integrity constraint violated.", false);
                break;
            }
            case 2293: {
                createNotification("Error encountered!", "Cannot validate.", false);
                break;
            }
            default: {
                createNotification("Error encountered!", $err['message'], false);
                break;
            }
        }
        return;
    }

    switch ($err_code) {
        case 1: {
            createNotification("Error encountered!", "One or more of User ID, Email or Phone Number you entered already exist, kindly recheck these values from the Show All Users at the bottom and then proceed.", false);
            break;
        }
        case 2292: {
            createNotification("Error encountered!", "Integrity constraint violated.", false);
            break;
        }
        case 2293: {
            createNotification("Error encountered!", "Cannot validate.", false);
            break;
        }
        default: {
            createNotification("Error encountered!", $err['message'], false);
            break;
        }
    }
}

function handleInsertRequest() {
    global $db_conn;

    $tuple = array (
        ":bind1" => $_POST['uId'],
        ":bind2" => $_POST['uPass'],
        ":bind3" => $_POST['firstName'],
        ":bind4" => $_POST['lastName'],
        ":bind5" => $_POST['uEmail'],
        ":bind6" => $_POST['phoneNum'],
        ":bind7" => $_POST['userAddress'],
        ":bind8" => $_POST['userType'],
        ":bind9" => 0,
    );

    $tuples = array (
        $tuple
    );

    $status = runBoundSQL("INSERT INTO Users VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $tuples);

    if ($_POST['userType'] == 'customer'){
        runBoundSQL("INSERT INTO Customer VALUES (:bind1, :bind9, :bind7)", $tuples);
    }
    else{
        runBoundSQL("INSERT INTO Driver VALUES (:bind1, :bind9)", $tuples);
    }

    if ($status == null) {
        createNotification("Success!", "You have successfully signed up for our service!", true);
    } else {
        showErrorMessage($status, "");
    }

    OCICommit($db_conn);
}

//https://stackoverflow.com/questions/4881744/verify-string-has-length-greater-than-0-and-is-not-a-space-in-php
// THIS IS FOR PROJECTION QUERY
function handleSearchUserRequest(){
    $Lookup = $_POST['Lookup'];
    $attributes = implode(" , ", $Lookup);

    if (empty($attributes)) {
        echo "Invalid";
    }

    $res =runSQL(
        "SELECT $attributes
                               FROM Users");
    printTable('Users Found',$res);
}

function handleMenuFilterSearchRequest(){
    $Lookup = $_POST['menuLookup'];
    $attributes = implode(" , ", $Lookup);
    $res =runSQL(
        "SELECT $attributes
                               FROM Menu_Item");
    printTable('Menu Items Found',$res);
}

// FINAL PROJECTION TABLE --- FOR MARKS
function handleSearchUserRequest2(){
    $table = $_POST['tables2'];
    $Lookup = $_POST['attributes2'];
    $attributes = implode(" , ", $Lookup);
    $res =runSQL(
        "SELECT $attributes From $table");
    printTable(''.$table.' Service Details', $res);
    // createNotification('Success!', 'The '.$table.' service with the selected information ('.$attributes.') is shown above.', 1);
}

// SELECTION WHERE QUERY get resturant info from submit query result for WHERE (SELECTION)
function handleRestaurantRequest(){
    $restaurant_name = $_POST['name'];
    $restaurant_location = $_POST['location'];
    $restaurant_manger = $_POST['manger'];
    $restaurant_rating = $_POST['overallRating'];
    $restaurant_phoneNumber = $_POST['phoneNum'];
    $restaurant_ID = $_POST['rID'];

    $att = '';
    $word_count = 0;


    if($restaurant_name == NULL){
        $att .="";
    }else{
        $restaurant_name = trim($restaurant_name);
        $att .= 'r2.name = '. "'{$restaurant_name}'";
        $word_count = 1;
    }

    if($restaurant_location== NULL){
        $att .="";
    }else{
        $restaurant_location= trim($restaurant_location);
        if($word_count==1){
            $att .= 'AND r2.location ='. "'{$restaurant_location}'";
        }else{
            $att .='r2.location ='. "'{$restaurant_location}'";
            $word_count=1;
        }
    }

    if($restaurant_ID == NULL){
        $att .="";
    }else{
        if($word_count==1){
            $att .=' AND r4.restaurantID='.$restaurant_ID;
        }else{
            $att .=' r4.restaurantID ='.$restaurant_ID;
            $word_count=1;
        }
    }

    if($restaurant_phoneNumber==NULL){
        $att .="";
    }else{
        if($word_count==1){
            $att .=' AND r3.phoneNum ='.$restaurant_phoneNumber;
        }else{
            $att .=' r3.phoneNum ='.$restaurant_phoneNumber;
            $word_count=1;
        }
    }

    if($restaurant_manger==NULL){
        $att .="";
    }else{
        $restaurant_manger = trim($restaurant_manger);
        if($word_count==1){
            $att .=' AND r4.manager ='."'{$restaurant_manger}'";
        }else{
            $att .=' r4.manager ='."'{$restaurant_manger}'";
            $word_count=1;
        }
    }

    if($restaurant_rating==NULL){
        $att .="";
    }else{
        if($word_count==1){
            $att .=' AND r2.overallRating='.$restaurant_rating;

        }else{
            $att .=' r2.overallRating ='.$restaurant_rating;
        }
    }

    if (empty($att)) {
        createNotification("Error encountered!", "Please fill in at least one field to view a restaurant", false);
        return;
    }

    if(array_key_exists("restaurantLookupByLocation2", $_POST)){
        $res =runSQL(
            "SELECT DISTINCT r2.name, r2.location
                        FROM RestaurantTable_2 r2, RestaurantTable_1 r1, RestaurantTable_3 r3, RestaurantTable_4 r4
                        WHERE $att");
        printTable('Restaurants Found', $res);
    }
}

function handleDeleteRequest() {

    global $db_conn, $success;
    // attributes
    $attribute = $_POST['userAttributes'];
    $value = $_POST['attrValue'];

    $res = runSQL("SELECT * FROM Users WHERE " . $attribute . "='" . $value . "'");

    if (empty(OCI_Fetch_Array($res))) {
        createNotification("Error encountered!", "User with an attribute, $attribute and value, $value does not exist", false);
        return;
    }

    runSQL("DELETE FROM Users WHERE " . $attribute . "='" . $value . "'");

    if ($success) {
        createNotification("Success!", "You have successfully unsubscribed all users with a $attribute of $value.", true);
    } else {
        createNotification("Error encountered!", "Cannot delete this user.", false);
    }

    OCICommit($db_conn);
}

function handleUpdateRequest() {
    global $db_conn;

    $userID = $_POST['uId'];
    $password = $_POST['uPass'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['uEmail'];
    $phoneNumber = $_POST['phoneNum'];

    runSQL("UPDATE Users SET password='" . $password . "', firstName='" . $firstName . "', lastName='" . $lastName . "', email='" . $email . "', phoneNumber='" . $phoneNumber . "' WHERE userID='" . $userID . "'" );

    OCICommit($db_conn);
}

// UPDATE QUERY
function handleUpdateDeleteMenuItem($x) {
    global $db_conn, $success, $hasErr;

    $validate = $x; // x=1 delete AND if x=0 update
    // FK: restaurantID
    //  Menu_Item
    $itemID = $_POST['itemID'];
    $rID = $_POST['restaurantID'];

    $itemName = $_POST['itemName'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $qty = $_POST['quantity'];

    $newItemID = $_POST['newItemID'];
    $newRestaurantID = $_POST['newRestaurantID'];

    $att = "";
    $wAtt = "";
    $del = "";
    $count =0;
    $noAtts = 0;


    if ($qty == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        $att .= 'quantity=' . $qty;
        $del .= 'quantity=' . $qty;
        $count = 1;
    }

    if ($price == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        if ($count == 1) {
            $att .= ', price=' . $price;
            $del .= ' AND price=' . $price;
        } else {
            $att .= 'price =' . $price;
            $del .= 'price=' . $price;
            $count = 1;
        }
    }

    if ($desc == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        $desc = trim($desc);
        if ($count == 1) {
            $att .= ',description=' ."'{$desc}'";
            $del .= ' AND description=' . "'{$desc}'";
        } else {
            $att .= 'description=' ."'{$desc}'";
            $del .= 'description=' ."'{$desc}'";
            $count = 1;
        }
    }

    if ($itemName == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        $itemName = trim($itemName);
        if ($count == 1) {
            $att .= ',itemName=' . "'{$itemName}'";
            $del .= ' AND itemName=' . "'{$itemName}'";
        } else {
            $att .= 'itemName=' . "'{$itemName}'";
            $del .= 'itemName=' ."'{$itemName}'";
            $count = 1;
        }
    }

    if ($itemID == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        $wAtt .= 'itemID=' . $itemID;
        if ($count == 1) {
            $del .= " AND itemID=$itemID";
        } else {
            $del .= "itemID=$itemID";
            $count = 1;
        }
    }

    if ($rID == NULL) {
        $att .= "";
    } else {
        $noAtts++;
        $wAtt .= ' AND restaurantID=' . $rID;
        if ($count == 1) {
            $del .= ' AND restaurantID=' . $rID;
        } else {
            $del .= 'restaurantID=' . $rID;
            $count = 1;
        }
    }

    /*** Empty attribute check *****/
    if ($x == 1 && empty($noAtts)) {
        createNotification("Error encountered!", "Please fill in at least one field to delete an item", false);
        return;
    }

    // TABLE BEFORE UPDATE

    $tablePrev = runSQL("Select * From MENU_ITEM");
    printTable("Table Before Update", $tablePrev);

    // GETS the restaurantID for us
    // $temp = runSQL("Select DISTINCT restaurantID
    //                 From Menu_Item
    //                 Where $wAtt");

    /***** Check if Old item and Old restaurant ID pair exist FOR UPDATE****/
    if ($x != 1) {
        $res = runSQL("SELECT * FROM Menu_Item WHERE itemID=$itemID AND restaurantID=$rID");

        if (empty(OCI_Fetch_Array($res))) {
            createNotification("Error encountered!", "Menu item with an item ID, $itemID and restaurant ID, $rID does not exist", false);
            return;
        }
    }

    if ($x == 1) {
        $res = runSQL("SELECT * FROM Menu_Item WHERE $del");

        if (empty(OCI_Fetch_Array($res))) {
            createNotification("Error encountered!", "the item you want to delete doesn't exist", false);
            return;
        }
    }

    if($validate ==0 && !empty($att)){
        runSQL("UPDATE MENU_ITEM SET $att WHERE $wAtt");
    }

    if($x == 1){
        //  runSQL("DELETE FROM Users WHERE " . $attribute . "='" . $value . "'");
        runSQL("DELETE FROM MENU_ITEM WHERE $del");
    }
    //runSQL("UPDATE MENU_ITEM SET $att WHERE $wAtt");



    // @kush add this error check above
    if((!empty($newRestaurantID) && !empty($newItemID))){

        /**** check if restaturant even exists ******/
        $res = runSQL("SELECT * FROM RestaurantTable_4 WHERE restaurantID=$newRestaurantID");

        if (empty(OCI_Fetch_Array($res))) {
            createNotification("Error encountered!", "A restaurant with the given new restaurant ID, $newRestaurantID does not exist", false);
            return;
        }

        if($validate==0){// update
            runSQL("UPDATE Menu_Item SET itemID=$newItemID, restaurantID=$newRestaurantID  WHERE $wAtt"); // Throws err code 1 (if duplicate resID, itemId pair)
            runSQL("UPDATE Contains SET itemID=$newItemID, restaurantID=$newRestaurantID  WHERE $wAtt");
        }

    }

    if ($hasErr == 1) {
        return;
    }

    $res = $success;

    $tableAfter = runSQL("Select * From MENU_ITEM");

    if($validate==0){ //update
        printTable("Table After Update", $tableAfter);
    }
    if ($validate==1){ //delete
        printTable("Table After DELETE", $tableAfter);
    }


    if ($res) {
        if($validate==0){ // update
            createNotification("Success!", "You have updated an item!", true);
        }else if($validate==1){
            createNotification("Success!", "You have deleted an item!", true);
        }
    } else {
        if($validate==0){
            createNotification("Error!", "Could not updated this item", false);
        }else if ($validate==1){
            createNotification("Error!", "Could not delete this item", false);
        }
        //createNotification("Error!", "Could not updated this item", false);
        return;
    }


    OCICommit($db_conn);

}

// JOIN
function handleJoinRequest() {
    global $db_conn;

    $itemName = $_POST['itemName'];

    if (empty($itemName)) {
        echo "Please enter an item name";
        return;
    }

    $res = runSQL(" SELECT DISTINCT M.itemName AS Item, RestaurantTable_2.name AS Restaurant
                            FROM Menu_Item  M
                            INNER JOIN RestaurantTable_4 ON M.restaurantID = RestaurantTable_4.restaurantID
                            INNER JOIN RestaurantTable_3 ON RestaurantTable_4.phoneNum = RestaurantTable_3.phoneNum
                            INNER JOIN RestaurantTable_2 ON RestaurantTable_3.location = RestaurantTable_2.location
                            WHERE M.itemName LIKE '%$itemName%'
                        ");

    printTable("Restaurants found with $itemName",$res);
}


function handleHavingRequest() {
    global $db_conn;

    $orderTotal = $_POST['orderTotal'];

    $res = runSQL(" WITH Temp(Id, cnt) as 
                            (
                                SELECT O.Customer_userID AS ID, COUNT(*) AS Count
                                FROM OrderTable_3 O 
                                WHERE O.subtotal >= $orderTotal
                                GROUP BY O.Customer_userID
                                HAVING COUNT(*) >= 1
                            )
                            SELECT Users.firstName as firstName, T.cnt as Count
                            FROM Temp T
                            INNER JOIN Users ON T.Id = Users.userID
                        ");

    printTable("Customers with total of $orderTotal dollars or above", $res);
}

?>