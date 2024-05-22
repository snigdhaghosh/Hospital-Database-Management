# Health Vaccination and Scheduling System
## Project Overview
Coursework Project. <br>
This project is part of the Database Systems course. The aim is to develop a comprehensive database system for Health hospital to manage vaccination and scheduling processes. The project involves creating both a back-end database and a front-end application that interacts with the database to provide necessary functionalities. It follows a two-tier structure following BCNF standards with clear separation between the database and the front-end application. 

## Features
### Key Functionalities
Vaccine Delivery Management: <br>
Update vaccine inventory upon delivery.<br>
Track available and on-hold doses.

Nurse Scheduling: <br>
Schedule nurses for vaccination time slots.<br>
Ensure there is at least one nurse per slot and a maximum of 12.

Vaccination Scheduling:<br>
Allow patients to schedule vaccination appointments.<br>
Ensure availability of vaccine doses for scheduling.

Vaccination Record Keeping:<br>
Record details of each vaccination, including nurse, time, vaccine type, and dose.<br>
User Roles and Permissions

Admin:<br>
Register, update, and delete nurses.<br>
Manage vaccine inventory.<br>
View nurse and patient information.

Nurse:<br>
Update personal information.<br>
Schedule and cancel time slots.<br>
Record vaccinations.

Patient:<br>
Register and update personal information.<br>
Schedule and cancel vaccination appointments.<br>
View vaccination history.

## Technical Specifications
### Front-End
Implemented as a local server web interface.<br>
Technologies: JavaScript, PHP, CSS.

### Back-End
SQL databases: MySQL, phpMyAdmin.
