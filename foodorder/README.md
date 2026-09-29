# Spice Route – Restaurant Food Ordering Website
CS2307 – Internet Programming Lab Mini Project

**Stack:** HTML, CSS, JavaScript, PHP (server-side), MySQL (database)

## Dynamic features included
- User registration & login (sessions, hashed passwords)
- Menu browsing pulled live from the MySQL database
- Add-to-cart via AJAX (JavaScript `fetch`, no page reload) — session-based cart
- Checkout → order + order_items written to the database in a transaction
- Order history ("My Orders") per logged-in user
- Admin panel: dashboard stats, add/hide/delete menu items (CRUD), update order status

## Folder structure
```
foodorder/
├── admin/
│   ├── dashboard.php
│   ├── manage_menu.php
│   └── manage_orders.php
├── css/style.css
├── js/script.js
├── includes/
│   ├── db.php
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── database/schema.sql
├── index.php
├── menu.php
├── register.php
├── login.php
├── logout.php
├── cart.php
├── cart_action.php
├── checkout.php
├── order_success.php
├── my_orders.php
└── reset_admin_password.php
```

## Setup — step by step (Windows + XAMPP)

1. **Install XAMPP** (if not already installed) from apachefriends.org, then open the
   **XAMPP Control Panel** and click **Start** next to both **Apache** and **MySQL**.

2. **Copy the project folder.** Extract the zip and copy the whole `foodorder` folder into:
   `C:\xampp\htdocs\foodorder`

3. **Create the database.** Open a browser and go to `http://localhost/phpmyadmin`.

4. **Import the schema.** In phpMyAdmin click **Import**, choose
   `foodorder/database/schema.sql`, and click **Go**. This creates the
   `foodorder_db` database with all tables plus sample menu items and a demo admin user.

5. **Check the DB connection.** Open `foodorder/includes/db.php` — the defaults
   (`localhost` / `root` / no password / `foodorder_db`) match a stock XAMPP
   install, so usually nothing needs to change.

6. **Fix the admin password hash.** In your browser go to:
   `http://localhost/foodorder/reset_admin_password.php`
   This sets a working hash for the demo admin account. Delete this file afterward.

7. **Open the site.** Go to `http://localhost/foodorder/index.php`.

8. **Try it out:**
   - Register a new customer account, or log in as admin with
     `admin@foodorder.com` / `admin123`.
   - As a customer: browse the Menu, add items to your cart, checkout, and
     view the order under "My Orders".
   - As admin: open the **Admin** link in the navbar to see the dashboard,
     add/hide/delete menu items, and update order statuses.

## Notes for the report / viva
- Passwords are stored using PHP's `password_hash()` / `password_verify()` — never plain text.
- All SQL queries that include user input use **prepared statements** (`mysqli` `bind_param`) to prevent SQL injection.
- Output is escaped with `htmlspecialchars()` (the `clean()` helper) to prevent XSS.
- The cart is stored server-side in `$_SESSION`, and item prices are re-fetched
  from the database on add (never trusted from the client) to prevent price tampering.
- Placing an order uses a MySQL **transaction** so the order and its line items
  are saved atomically.
