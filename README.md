# Health Vaccination and Scheduling System
## Project Overview
Coursework Project
This project is part of the Database Systems course. The aim is to develop a comprehensive database system for Health hospital to manage vaccination and scheduling processes. The project involves creating both a back-end database and a front-end application that interacts with the database to provide necessary functionalities. It follows a two-tier structure following BCNF standards with clear separation between the database and the front-end application. 

## Features
### Key Functionalities
Vaccine Delivery Management:
Update vaccine inventory upon delivery.
Track available and on-hold doses.

Nurse Scheduling:
Schedule nurses for vaccination time slots.
Ensure there is at least one nurse per slot and a maximum of 12.

Vaccination Scheduling:
Allow patients to schedule vaccination appointments.
Ensure availability of vaccine doses for scheduling.

Vaccination Record Keeping:
Record details of each vaccination, including nurse, time, vaccine type, and dose.
User Roles and Permissions

Admin:
Register, update, and delete nurses.
Manage vaccine inventory.
View nurse and patient information.

Nurse:
Update personal information.
Schedule and cancel time slots.
Record vaccinations.

Patient:
Register and update personal information.
Schedule and cancel vaccination appointments.
View vaccination history.

## Technical Specifications
### Front-End
Implemented as a local server web interface.
Technologies: JavaScript, PHP, CSS.

### Back-End
SQL databases: MySQL, phpMyAdmin.
