# Women in FinTech - Full Stack Platform

## 🇺🇸 Project Overview
**Women in FinTech** is a comprehensive web application developed to empower women in the financial technology sector. It provides tools for networking, professional development, and community engagement through a robust member management system and resource hub.

###  Installation & Setup
To run this project locally, ensure you follow these environment requirements:
1.  **Environment:** Move the project folder to your local XAMPP installation path: `C:\xampp\htdocs\`.
2.  **Server:** Start **Apache** and **MySQL** services from the XAMPP Control Panel.
3.  **Database:** * Access `phpMyAdmin` (127.0.0.1).
    * Create a new database named `women_fintech`.
    * Import the provided `.sql` file to set up the tables and sample data.
4.  **Access:** Open your browser and navigate to `localhost/FullStack-PHP-Women-Fintech/index.php`.

###  Key Features
* **Member Directory (CRUD):** Complete system to add, view, edit, and delete professional profiles.
* **Resource Hub:** Categorized library for articles, videos, podcasts, and downloadable PDF materials.
* **Event Management:** System for listing online/offline events, user registrations, and reviews.
* **Mentorship Program:** Automated mentorship request system with status tracking (Accepted/Pending/Rejected).
* **Jobs Board:** Professional listing with advanced filtering by job type (Full-time, Remote, etc.) and direct application tracking.
* **Security:** Implemented using **PHP PDO** for prepared statements to prevent SQL Injection.

###  Database Schema (MariaDB)
The relational database includes the following core tables:
* `members`: Stores user profiles, roles (Admin/Mentor/Member), and professional info.
* `events` & `event_registrations`: Handles event logistics and attendee tracking.
* `jobs` & `job_applications`: Manages career opportunities.
* `mentorship_requests`: Facilitates the matching system.
* `notifications`: Real-time status updates for users.

---

## 🇷🇴 Prezentare Proiect
**Women in FinTech** este o platformă web completă dezvoltată pentru susținerea și promovarea femeilor în tehnologia financiară. Oferă resurse educaționale, oportunități de networking și un sistem avansat de management al carierei.

###  Configurare și Instalare
1.  **Mediu:** Copiați folderul proiectului în `C:\xampp\htdocs\`.
2.  **Server:** Porniți modulele **Apache** și **MySQL** din XAMPP.
3.  **Baza de Date:** Importați fișierul `.sql` în `phpMyAdmin` sub baza de date `women_fintech`.
4.  **Acces:** Accesați `localhost/FullStack-PHP-Women-Fintech/index.php`.

###  Funcționalități Principale
* **Management Membri:** Sistem CRUD complet pentru gestionarea profilurilor profesionale.
* **Hub de Resurse:** Acces la articole, tutoriale video și materiale descărcabile (PDF).
* **Evenimente:** Înregistrare la workshop-uri și conferințe (online/offline) cu sistem de feedback.
* **Program de Mentorat:** Matching între mentori și mentee cu tracking de progres.
* **Jobs Board:** Listare locuri de muncă cu filtrare avansată și aplicare directă.

###  Tehnologii Utilizate
* **Backend:** PHP 8.0.30 (PDO).
* **Bază de date:** MariaDB 10.4 (XAMPP).
* **Frontend:** HTML5, CSS3, Bootstrap 4.5.2, JavaScript.
* **Editor:** Visual Studio Code.