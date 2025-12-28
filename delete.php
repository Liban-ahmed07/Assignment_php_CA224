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

Chapter 8 Practice
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Statement</title>
</head>
<body>
    <?php
        if (isset($_GET['delete'])) {
            // echo ("<br>Ready to delete");
            $id = $_GET['delete'];
            require_once("connection.php");
            if (!$conn->connect_error) {
                if ($conn->query("delete from students where id = '$id';")) {
                    echo ("<br>Successfully deleted.");
                    // redirect to select.php page 
                    header ("location: select.php");
                }
                else
                    echo ("<br>Nothing deleted.");
            }
        }    
        else
            echo ("<br>Sorry!!! Unauthorized access.");
    ?>
</body>
</html>
De ... hp
Displaying Delete.php.Chapter 8 Practice