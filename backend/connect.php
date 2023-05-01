<?php

    /**
     * Connect to DB
     */
    function connectToDB() {
        global $db_conn;
        $db_conn = OCILogon("ora_kaitimk", "a16915143", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {

            // echo "Database is Connected!"."<br>";
            return true;

        } else {

            // echo "Cannot connect to Database";
            $e = OCI_Error();
            // echo htmlentities($e['message']); // converts characters into HTML entities
            return false;
        }

    }

    /**
     * disconnect from DB
     */
    function disconnectFromDB() {
        global $db_conn;

        // echo "<br>"."Disconnecting from Database";

        OCILogoff($db_conn);
    }

?>