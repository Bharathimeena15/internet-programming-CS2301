<!DOCTYPE html>
<html>
<head>
    <title>Library - Book List</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            font-size: 18px;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 30px;
        }

        table {
            margin: auto;
            border-collapse: collapse;
            width: 75%;
            font-size: 18px;
        }

        th, td {
            border: 2px solid black;
            padding: 14px 20px;
            text-align: center;
        }

        th {
            font-size: 20px;
        }

        td {
            height: 35px;
        }
    </style>
</head>

<body>

<h2>Library Book Details</h2>

<?php

// Load XML file
$xml = simplexml_load_file("books.xml")
        or die("Error: Cannot load XML file.");

echo "<table>";

echo "<tr>";
echo "<th>Title</th>";
echo "<th>Author</th>";
echo "<th>Year</th>";
echo "<th>Price</th>";
echo "</tr>";

// Display each book
foreach ($xml->book as $book) {

    echo "<tr>";

    echo "<td>" . $book->title . "</td>";
    echo "<td>" . $book->author . "</td>";
    echo "<td>" . $book->year . "</td>";
    echo "<td>$" . $book->price . "</td>";

    echo "</tr>";
}

echo "</table>";

?>

</body>
</html>