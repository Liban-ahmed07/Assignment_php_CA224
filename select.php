Skip to main content
Google Classroom
PHP & MySQL (CA224-JUST)
CA-CA224
Chapter 8 Practice
Abdisalam Yusuf Abdi
•
Dec 20 (Edited Dec 20)
Connection.php
PHP

Delete.php
HTML

Insert.php
HTML

Select.php
HTML

classes.sql
SQL

students (2).sql
SQL

Class comments

Add class comment…

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Statement</title>
    <style>
        table {width: 100%; border-collapse: collapse;}
        td, th {border: 1px solid brown;}
        th {background-color: gray;}
        h1 {text-align: center;}
        tr:nth-child(odd) {background-color: lightgray;}
    </style>
</head>
<body>
    <h1>Select Statement</h1>
    <?php
        // Step 1 establish connection 
        require_once("connection.php");
        // Test connectoin 
        if (!$conn->connect_error) {
            // echo ("<br>Successfully connected");
            // Step 2 formulate query 
            $sql = "select * from students where class ='ca224' or class='ca222'  order by class;";
            // Step 3 submit query 
            $result = $conn->query($sql);
            /* echo ("<pre>");
            var_dump($result);
            echo ("</per>"); */
            // Step 4 process the result and display on the browser 
            if ($result->num_rows) {
                echo ("<br><a href='insert.php' target='_blank'>Add new student</a>");
                echo ("<table> <caption>List of CA224 students</caption>");
                // display table header 
                $header = $result->fetch_fields();
                echo ("<tr>");
                foreach ($header as $h)
                    echo ("<th>". ucfirst($h->name));
                echo ("<th>Delete<th>Update");
                while ($row = $result->fetch_assoc()) {
                    echo ("<tr>");
                    // echo ($row['id']. ", ". $row['fullname']);
                // to print all fields use another loop 
                    foreach ($row as $value)
                        echo ("<td>$value");
                    echo ("<td><a href='Delete.php?delete=". $row['id']. "' onClick = 'return confirm(\"Are you really want to delete?\")'>Delete</a><td><a href='insert.php?update=". $row['id']. "' onClick='return confirm(\"Are you really want to update?\");' target='_blank'>Update</a>");
                }
                echo ("</table>");
                echo ("<h1>Returned ". $result->num_rows . " records.</h1>");
            }
            else
                echo ("<br>Sorry!!! Empty recordset");
            // Step 5 close connectioin 
            $conn->close();
        }
        else
            echo ("<br>Failed to connect");
    ?>
</body>
</html>
Sel ... php
Displaying Select.php.