<!DOCTYPE html>
<html>

<head>

    <title>Book Information</title>

    <style>

        body {
            font-family: Arial;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: white;
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .price {
            color: green;
            font-weight: bold;
        }

    </style>

</head>

<body>

<h1>Book Information</h1>

<?php

// Read XML file
$xml = simplexml_load_file("books.xml");

// Check XML file
if ($xml === false) {

    echo "<p>Unable to load XML file.</p>";

} else {

    echo "<table>";

    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>Title</th>";
    echo "<th>Author</th>";
    echo "<th>Price</th>";
    echo "<th>Category</th>";
    echo "</tr>";

    // Process each book
    foreach ($xml->book as $book) {

        echo "<tr>";

        echo "<td>" . $book->id . "</td>";
        echo "<td>" . $book->title . "</td>";
        echo "<td>" . $book->author . "</td>";
        echo "<td class='price'>₹" . $book->price . "</td>";
        echo "<td>" . $book->category . "</td>";

        echo "</tr>";
    }

    echo "</table>";
}

?>

</body>

</html>