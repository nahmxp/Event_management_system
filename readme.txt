 Event Management System (EMS)

## Overview
The Event Management System (EMS) is a web-based platform built using PHP, MySQL, and Bootstrap. It allows users to manage events, attendees, and their registrations, while providing an admin interface for CRUD operations, attendee management, and report generation.

## Features
- **User Authentication**: Users can register, log in, and access the system with role-based access (admin or regular user).
- **Event Management**: Admin users can create, edit, delete, and view events.
- **Attendee Registration**: Users can register for events. Admins can view and manage registrations.
- **CSV Report Generation**: Admins can download CSV reports of attendees for each event.

## Technologies Used
- PHP
- MySQL (XAMPP for local development)
- Bootstrap (Frontend)
- Password Hashing (for user authentication)

## Setup Instructions
1. Clone the repository or download the project files.
2. Import the provided SQL database file (`database.sql`) into your MySQL server.
3. Configure your database connection in `db.php` file.
4. Set up a local server using XAMPP or any LAMP stack.
5. Access the system via `http://localhost/ems/` in your web browser.

##AJAX and Search Functionality
--AJAX Functionality
Dynamic Event Viewing: When the user clicks "View" or a search result, an AJAX request fetches event details and displays them in a modal without reloading the page.
Admin Privileges: Admin users see extra buttons (Edit, Delete, Download CSV) in the modal.
Files Involved:

--dashboard.php (JavaScript for AJAX)
--event/viewevent.php (Fetch event details)

##Search Functionality
--Real-Time Search: As the user types, matching events are shown below the search box.
Instant Viewing: Clicking a suggestion shows event details in a modal.
Files Involved:

--dashboard.php (Search box and AJAX)
--event/searchevent.php (Search logic)

##Technical Flow:

--Search: User types in the search box, AJAX fetches matching events.
--View Event: Clicking a result or "View" triggers an AJAX call to show event details.

## Database Design
- **users**: Stores user data (ID, name, email, password, role).
- **events**: Stores event data (ID, name, description, date, time, event type, capacity).
- **attendees**: Stores attendee data (ID, event ID, name, email, phone number, registration date).

## github Link
- https://github.com/nahmxp/Event_management_system

## Live Link
- http://revenxr.free.nf/Event_management_system/

## Accessing the System
- Admin login: `ahmed.noortaz1@gmail.com` / `adminpassword:123`
- Regular user login: `ahmed.noor@gmail.com` / `userpassword:1234`

## Security Practices
- Passwords are securely hashed using PHP’s `password_hash()` function.
- Prepared statements are used to prevent SQL injection.
- User input is validated and sanitized to ensure security.

## Hosting and Accessibility
This project is currently hosted on a local server. You can try the system locally by following the setup instructions.

## Contributions
Feel free to fork the repository and contribute to improving the system. For any issues or suggestions, please open an issue on the GitHub repository.

---

You can adjust the credentials and specific instructions based on your setup.
