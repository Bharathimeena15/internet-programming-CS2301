function loadProducts() {

    var xhr = new XMLHttpRequest();

    xhr.open("GET", "getProducts.php", true);

    xhr.onload = function() {

        if (xhr.status == 200) {

            var xml = xhr.responseXML;

            var products = xml.getElementsByTagName("product");

            var output = "";

            output += "<table>";
            output += "<tr>";
            output += "<th>ID</th>";
            output += "<th>Product Name</th>";
            output += "<th>Category</th>";
            output += "<th>Price</th>";
            output += "<th>Stock</th>";
            output += "</tr>";

            for (var i = 0; i < products.length; i++) {

                var id = products[i].getElementsByTagName("id")[0].textContent;
                var name = products[i].getElementsByTagName("name")[0].textContent;
                var category = products[i].getElementsByTagName("category")[0].textContent;
                var price = products[i].getElementsByTagName("price")[0].textContent;
                var stock = products[i].getElementsByTagName("stock")[0].textContent;

                output += "<tr>";

                output += "<td>" + id + "</td>";
                output += "<td>" + name + "</td>";
                output += "<td>" + category + "</td>";
                output += "<td>₹" + price + "</td>";
                output += "<td>" + stock + "</td>";

                output += "</tr>";
            }

            output += "</table>";

            document.getElementById("productTable").innerHTML = output;

        } else {

            document.getElementById("productTable").innerHTML =
                "Unable to load products.";

        }

    };

    xhr.send();
}