# Vehicle Reservation System - README

## Introduction

This web application is designed to manage and monitor vehicle reservations within a company. It supports features such as:

-   Admin-initiated vehicle reservations.
-   Multi-level approval workflows.
-   Dashboard with graphical insights.
-   Exportable periodic reports (Excel).

---

## Credentials

| Role       | Username  | Password |
| ---------- | --------- | -------- |
| Admin      | admin     | admin    |
| Approver 1 | ucing     | approver |
| Approver 2 | yusriyahf | approver |

---

## Requirements

-   **PHP**: Version 8.2 or above
-   **Database**: MySQL 10.4
-   **Framework**: Laravel 10.x
-   **Frontend**: Bootstrap 5
-   **Other Tools**:
    -   Composer (PHP dependency manager)

---

## Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/yusriyahf/technical_test_sekawan.git
```

### 2. Navigate to the Project Directory

```bash
cd technical_test_sekawan
```

### 3. Install Backend Dependencies

```bash
composer install
```

### 4. Configure the Environment File

-   Duplicate `.env.example` and rename it to `.env`.
-   Update the following variables:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=technical_test_sekawan
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

### 6. Seed the Database (Optional)

This will populate the database with sample data:

```bash
php artisan db:seed
```

### 7. Start the Development Server

```bash
php artisan serve
```

### 8. Access the Application

-   Open your browser and navigate to `http://localhost:8000`.

---

## Features

### Admin Features

-   Create, edit, and delete vehicle reservations.
-   Assign drivers and approvers for each reservation.
-   View detailed logs of vehicle usage and approval history.

### Approval Workflow

-   Multi-level approval process (at least two levels required).
-   Approvers can approve or reject reservations through the application.

### Dashboard

-   Visualize vehicle usage trends using charts.

### Export Reports

-   Generate periodic reservation reports in Excel format.

---

## Logging

The application logs critical actions and events, such as:

-   User logins and logouts.
-   Reservation creation, updates, approvals, and rejections.

---

## Technology Stack

### Backend

-   **Framework**: Laravel 10.x
-   **Database**: MySQL 8.0
-   **PHP Version**: 7.4 or above

### Frontend

-   **Framework**: Bootstrap 5
-   **Charts**: Chart.js

### Additional Tools

-   **Excel Export**: Maatwebsite

---

## Usage Guide

### Admin

1. Login using admin credentials.
2. Navigate to the "Booking" section.
3. Create a new reservation by selecting a vehicle, assigning a driver, and specifying approvers.

### Approvers

1. Login using approver credentials.
2. Go to the "Booking" section.
3. Review reservation details and approve or reject requests.
