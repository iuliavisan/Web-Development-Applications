# E-commerce Web Application - PHP and MySQL Shopping Cart

## EN
**Project Overview**
This is a full-stack e-commerce application developed to manage a product catalog, user authentication, and a shopping cart system. It is designed to handle multiple relational data structures, from user credentials to complex order tracking.

**Installation and Setup**
To run this project locally, follow these environment requirements:
1. Environment: Move the project folder to your local XAMPP installation path: C:\xampp\htdocs\.
2. Server: Launch the XAMPP Control Panel and start both Apache and MySQL services.
3. Database Setup:
    * Access phpMyAdmin (127.0.0.1).
    * Create a new database named "magazin" and import the provided magazin.sql file.
    * Create a new database named "magazin2" and import the provided magazin2.sql file.
4. Access: Open your browser and navigate to localhost/FullStack-PHP-Ecom-Cart/index.php.

**Core Features**
* User Authentication: Complete Registration (register.php) and Login (login.php) system using encrypted passwords (password_hash).
* Product Catalog: Dynamic listing of products (e.g., Gaming Laptops, Smartphones) fetched from the database.
* Shopping Cart Management: Integrated system allowing users to add items (addToCart.php), update quantities (updateCart.php), and remove items or empty the cart.
* Order Tracking: Management of customer orders, including status (Delivered, Processing, Shipped) and shipping dates.
* Visitor Tracking: Logging system for page visits, including platform, referrer, and host data.
* Security: Implemented using PHP PDO with prepared statements to prevent SQL Injection.

**Database Schema Details**
The system operates using two primary databases:
* magazin: Stores core tables including "users" (credentials), "clienti" (customer details, addresses, and card info), "produse" (detailed product catalog), and "ordin" (order history).
* magazin2: Specifically manages the e-commerce flow through "tbl_product" and "tbl_cart" tables.

**Tech Stack**
* Development Environment: XAMPP (Apache Server and MariaDB 10.4.32).
* Backend: PHP 8.0.30 using PDO for database operations.
* Frontend: HTML5, CSS3, JavaScript.

---

## RO
**Prezentare Proiect**
Aceasta este o aplicație web completă de tip e-commerce dezvoltată pentru a gestiona un catalog de produse, autentificarea utilizatorilor și un sistem de coș de cumpărături. Este proiectată să gestioneze structuri de date relaționale complexe, de la credențiale de utilizator până la urmărirea comenzilor.

**Configurare și Instalare**
Pentru a rula acest proiect local, urmați aceste cerințe de mediu:
1. Mediu: Copiați folderul proiectului în directorul local XAMPP: C:\xampp\htdocs\.
2. Server: Porniți XAMPP Control Panel și activați serviciile Apache și MySQL.
3. Configurare Bază de Date:
    * Accesați phpMyAdmin (127.0.0.1).
    * Creați o bază de date nouă numită "magazin" și importați fișierul magazin.sql.
    * Creați o bază de date nouă numită "magazin2" și importați fișierul magazin2.sql.
4. Acces: Deschideți browserul și navigați la adresa localhost/FullStack-PHP-Ecom-Cart/index.php.

**Funcționalități Principale**
* Autentificare Utilizatori: Sistem complet de Înregistrare (register.php) și Login (login.php) folosind parole criptate (password_hash).
* Catalog Produse: Afișare dinamică a produselor (ex: Laptop Gaming, Smartphone) preluate din baza de date.
* Management Coș de Cumpărături: Sistem integrat care permite utilizatorilor să adauge articole (addToCart.php), să actualizeze cantitățile (updateCart.php) și să elimine articole sau să golească coșul.
* Urmărire Comenzi: Gestionarea comenzilor clienților, inclusiv starea (Livrat, În procesare, Expediat) și datele de expediere.
* Monitorizare Vizite: Sistem de logare a paginilor vizitate, inclusiv date despre platformă, referrer și host.
* Securitate: Implementare prin PHP PDO cu interogări pregătite pentru a preveni atacurile de tip SQL Injection.

**Detalii Baze de Date**
Sistemul utilizează două baze de date principale:
* magazin: Conține tabele esențiale precum "users" (credențiale), "clienti" (detalii clienți, adrese și info card), "produse" (catalog detaliat produse) și "ordin" (istoric comenzi).
* magazin2: Gestionează specific fluxul de e-commerce prin tabelele "tbl_product" și "tbl_cart".

**Tehnologii Utilizate**
* Mediu de Dezvoltare: XAMPP (Server Apache și MariaDB 10.4.32).
* Backend: PHP 8.0.30 utilizând PDO pentru operațiuni cu bazele de date.
* Frontend: HTML5, CSS3, JavaScript.