VEHICLE SERVICES BOOKING SYSTEM — SETUP GUIDE (XAMPP)
========================================================

1. INSTALL XAMPP
   Download from https://www.apachefriends.org and install it
   (includes Apache, PHP, and MySQL/MariaDB).

2. COPY THE PROJECT FOLDER
   Copy this entire "vsbs" folder into XAMPP's htdocs directory:
     Windows: C:\xampp\htdocs\vsbs
     Linux:   /opt/lampp/htdocs/vsbs
     macOS:   /Applications/XAMPP/htdocs/vsbs

3. START SERVICES
   Open the XAMPP Control Panel and click "Start" next to
   Apache and MySQL.

4. CREATE THE DATABASE
   - Open http://localhost/phpmyadmin in your browser.
   - Click "Import" at the top.
   - Choose the file "database.sql" from this folder.
   - Click "Go". This creates the "vehicle_service_db" database
     with the users, services, and bookings tables, plus sample
     service data.

5. DATABASE CONNECTION
   includes/db.php already uses XAMPP's defaults:
       host: localhost
       user: root
       pass: (blank)
       db:   vehicle_service_db
   If you set a MySQL root password in XAMPP, update $db_pass
   in includes/db.php to match.

6. RUN THE WEBSITE
   Open your browser and go to:
       http://localhost/vsbs/index.php

   Pages:
     index.php           Home page
     services.php         Service catalogue (pulled live from MySQL)
     register.php          Create an account
     login.php             Log in
     book.php             Book a service (login required)
     my_bookings.php      View your own bookings (login required)
     logout.php            Log out
     admin/dashboard.php   View & update all bookings (admin view)

FOLDER STRUCTURE
----------------
vsbs/
├── index.php
├── services.php
├── register.php
├── login.php
├── book.php
├── my_bookings.php
├── logout.php
├── database.sql
├── css/
│   └── style.css
├── js/
│   └── script.js
├── includes/
│   ├── db.php           <- MySQL connection
│   ├── header.php
│   └── footer.php
└── admin/
    └── dashboard.php

DYNAMIC FEATURES
-----------------
- User registration with hashed passwords (password_hash/password_verify)
- Session-based login/logout
- Service catalogue loaded dynamically from the MySQL "services" table
- Booking form with live JavaScript price/duration preview, saved into
  the "bookings" table via a prepared statement
- Admin dashboard listing all bookings with an inline status-update
  dropdown (data management: Pending/Confirmed/Completed/Cancelled)
