# 🏥 LaraMediCare - Hospital Management System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-11+-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

**A comprehensive, modern Hospital & Clinic Management System built with Laravel 11+**

[Features](#-features) • [Demo](#-demo-credentials) • [Installation](#-installation) • [Screenshots](#-screenshots) • [Tech Stack](#-tech-stack) • [Contributing](#-contributing)

</div>

---

## 📋 Table of Contents

- [About](#-about)
- [Features](#-features)
- [Tech Stack](#-tech-stack)
- [Installation](#-installation)
- [Usage](#-usage)
- [Demo Credentials](#-demo-credentials)
- [Database Schema](#-database-schema)
- [Screenshots](#-screenshots)
- [API Documentation](#-api-documentation)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🎯 About

**LaraMediCare** is a powerful, user-friendly Hospital Management System designed to streamline healthcare operations. Built with Laravel 11+ and Bootstrap 5, it provides separate portals for Patients, Doctors, and Administrators to manage appointments, prescriptions, and patient care efficiently.

### 🌟 Why LaraMediCare?

- ✅ **Easy to Use** - Clean, intuitive interface for all user types
- ✅ **Secure** - Role-based authentication with proper authorization
- ✅ **Scalable** - Built with Laravel best practices and MVC architecture
- ✅ **Responsive** - Mobile-friendly design with Bootstrap 5
- ✅ **Feature-Rich** - Comprehensive functionality for hospital operations
- ✅ **Open Source** - Free to use and modify under MIT license

---

## 🚀 Features

### 👤 Patient Portal
- ✨ **User Registration & Login** - Secure patient account creation
- 📅 **Appointment Booking** - Easy online appointment scheduling
- 👨‍⚕️ **Doctor Selection** - Browse available doctors by specialization
- 📋 **Appointment History** - View past and upcoming appointments
- 💊 **Prescription Management** - Download and view prescriptions (PDF & Text)
- 👤 **Profile Management** - Update personal information and medical details

### 🩺 Doctor Portal
- 📊 **Dashboard** - Overview of daily appointments and statistics
- 📅 **Appointment Management** - View, confirm, and complete appointments
- 📝 **Prescription Creation** - Upload prescriptions (text or PDF)
- ⏰ **Schedule Management** - Set and manage availability hours
- 👥 **Patient Information** - Access patient details and history
- ✅ **Appointment Status** - Update appointment status (pending, confirmed, completed, cancelled)

### 🔐 Admin Portal
- 📈 **Analytics Dashboard** - System-wide statistics and metrics
- 👨‍⚕️ **Doctor Management** - Full CRUD operations for doctor accounts
- 👥 **Patient Management** - Manage patient records and accounts
- 📅 **Appointment Oversight** - View and manage all appointments
- 📊 **Reports** - Generate insights on hospital operations
- ⚙️ **System Configuration** - Manage system settings and preferences

### 🔧 Core Features
- 🔒 **Multi-Role Authentication** - Separate login systems for each role
- 🚫 **Double Booking Prevention** - Smart conflict detection
- 📧 **Email Notifications** - Automated appointment confirmations
- 📁 **File Upload/Download** - Secure prescription file handling
- 🔍 **Search & Filters** - Easy data navigation and filtering
- 📱 **Responsive Design** - Works seamlessly on all devices
- 🛡️ **Data Validation** - Comprehensive input validation and security

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 11+
- **Language:** PHP 8.2+
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Breeze (Custom Multi-Auth)

### Frontend
- **CSS Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.0
- **Template Engine:** Blade
- **JavaScript:** Vanilla JS

### Tools & Libraries
- **Composer** - Dependency Management
- **Artisan** - Laravel CLI
- **Migration** - Database Version Control
- **Eloquent ORM** - Database Abstraction

---

## 📥 Installation

### Prerequisites

Before you begin, ensure you have the following installed:
- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Apache/Nginx Server

### Step-by-Step Guide

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yourusername/laramedicare.git
   cd laramedicare
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laramedicare
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Create Database**
   ```bash
   mysql -u root -p
   CREATE DATABASE laramedicare;
   exit;
   ```

6. **Run Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Set Permissions**
   ```bash
   chmod -R 755 storage
   chmod -R 755 bootstrap/cache
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

10. **Access the Application**
    
    Open your browser and navigate to: `http://localhost:8000`

---

## 💻 Usage

### First Time Setup

After installation, the system comes pre-loaded with demo data:

1. Visit `http://localhost:8000`
2. Select your role (Patient, Doctor, or Admin)
3. Login with demo credentials (see below)
4. Explore the features!

### Creating New Users

**Patients:**
- Can self-register via the Patient Registration page
- Fill in personal and medical information
- Receive immediate access to book appointments

**Doctors:**
- Must be created by Admin users
- Admin provides initial credentials
- Doctor can update profile and set availability

**Admins:**
- Must be created directly via database seeder
- Use `php artisan db:seed` to create default admin

---

## 🔑 Demo Credentials

### Admin Access
```
Email: admin@laramedicare.com
Password: password
```

### Doctor Access
```
Dr. John Smith (Cardiology)
Email: john@laramedicare.com
Password: password

Dr. Sarah Johnson (Pediatrics)
Email: sarah@laramedicare.com
Password: password

Dr. Michael Brown (Orthopedics)
Email: michael@laramedicare.com
Password: password
```

### Patient Access
```
Email: patient1@example.com
Password: password

Email: patient2@example.com
Password: password
```

---

## 🗄️ Database Schema

### Main Tables

**users**
- Stores all user information (patients, doctors, admins)
- Fields: id, name, email, password, role, phone, address, date_of_birth, gender

**doctors**
- Additional doctor-specific information
- Fields: id, user_id, specialization, qualifications, consultation_fee, availability, is_available

**appointments**
- Manages all appointment bookings
- Fields: id, patient_id, doctor_id, appointment_date, appointment_time, status, notes, prescription, prescription_file

### Relationships

```
User (Patient) → hasMany → Appointments
User (Doctor) → hasMany → Appointments
User → hasOne → Doctor (for doctor role)
Appointment → belongsTo → User (Patient)
Appointment → belongsTo → User (Doctor)
```

### ER Diagram

```
┌─────────────┐       ┌──────────────┐       ┌─────────────┐
│    Users    │       │ Appointments │       │   Doctors   │
├─────────────┤       ├──────────────┤       ├─────────────┤
│ id          │──────<│ patient_id   │       │ id          │
│ name        │       │ doctor_id    │>──────│ user_id     │
│ email       │       │ app_date     │       │ special.    │
│ role        │       │ app_time     │       │ qualific.   │
│ phone       │       │ status       │       │ fee         │
│ address     │       │ prescription │       │ available   │
└─────────────┘       └──────────────┘       └─────────────┘
```

---

## 📸 Screenshots

### Landing Page
<img width="363" height="343" alt="main" src="https://github.com/user-attachments/assets/955be190-9d78-408e-9885-e277a23dfc0a" />


### Patient Dashboard : 
<img width="960" height="481" alt="pat-dash new" src="https://github.com/user-attachments/assets/5695a1bc-cb10-4a6e-b912-3a5d9b9f5df7" />
<img width="960" height="479" alt="pat=pro" src="https://github.com/user-attachments/assets/ac0a068f-a859-46e5-8a62-9aa0d01b45f7" />
<img width="958" height="480" alt="pat-book-app" src="https://github.com/user-attachments/assets/1afdf0c9-9a96-45e5-877c-51153ad6252f" />
<img width="960" height="479" alt="pat-app" src="https://github.com/user-attachments/assets/98d185da-77ef-4456-9e89-8f790a954874" />




### Doctor Dashboard :
<img width="960" height="483" alt="doc-dash" src="https://github.com/user-attachments/assets/d387633f-8492-4160-ae4a-b6e5b96f390a" />
<img width="960" height="480" alt="doc-app-details" src="https://github.com/user-attachments/assets/8c8721cf-7945-464c-a516-ecfb8a033170" />
<img width="960" height="479" alt="doc-app-man" src="https://github.com/user-attachments/assets/b9d3bf1a-b2be-4b89-85ff-4159311b5b5c" />



### Admin Dashboard :
<img width="959" height="479" alt="adm-dash" src="https://github.com/user-attachments/assets/f0ec32b0-1364-403a-9b69-abfcf5fc70e7" />
<img width="960" height="479" alt="adm-man-doc" src="https://github.com/user-attachments/assets/4e0ffa7b-5ff6-4ca0-8f8a-ad1f50c222ad" />
<img width="960" height="479" alt="adm-man-apt" src="https://github.com/user-attachments/assets/0623372c-d99e-4754-95c6-ae917d5eec63" />
<img width="960" height="481" alt="adm-man-app" src="https://github.com/user-attachments/assets/61f66b23-6cc5-4852-8984-61944b9ebf04" />



---

## 📚 API Documentation

### Authentication Endpoints

```http
POST /login
POST /logout
POST /patient/register
```

### Patient Endpoints

```http
GET  /patient/dashboard
GET  /patient/appointments
POST /patient/book-appointment
GET  /patient/prescriptions
PUT  /patient/profile
```

### Doctor Endpoints

```http
GET  /doctor/dashboard
GET  /doctor/appointments
GET  /doctor/appointments/{id}
PUT  /doctor/appointments/{id}
GET  /doctor/schedule
PUT  /doctor/schedule
```

### Admin Endpoints

```http
GET    /admin/dashboard
GET    /admin/doctors
POST   /admin/doctors
PUT    /admin/doctors/{id}
GET    /admin/patients
GET    /admin/appointments
```

---

## 🤝 Contributing

Contributions are what make the open-source community amazing! Any contributions you make are **greatly appreciated**.

### How to Contribute

1. **Fork the Project**
2. **Create your Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit your Changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push to the Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open a Pull Request**

### Development Guidelines

- Follow PSR-12 coding standards
- Write clear commit messages
- Add comments for complex logic
- Test your changes thoroughly
- Update documentation as needed

### Reporting Bugs

Found a bug? Please open an issue with:
- Clear description of the problem
- Steps to reproduce
- Expected vs actual behavior
- Screenshots (if applicable)
- Your environment details

---

## 🗺️ Roadmap

- [x] Core appointment system
- [x] Multi-role authentication
- [x] Prescription management
- [ ] Email notifications
- [ ] SMS reminders
- [ ] Payment integration
- [ ] Telemedicine support
- [ ] Mobile app (React Native)
- [ ] Analytics & reporting
- [ ] Multi-language support
- [ ] Dark mode
- [ ] API for third-party integration

---

## 📝 License

Distributed under the MIT License. See `LICENSE` for more information.

```
MIT License

Copyright (c) 2024 LaraMediCare

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
```

---

## 👨‍💻 Author

**WAJIH UL QAMMAR**

- GitHub: [@wajihulqammar](https://github.com/wajihulqammar)
- LinkedIn: [Wajih Ul Qammar](https://www.linkedin.com/in/wajih-ul-qammar/)
- Email: wajiul.qammar@gmail.com

---

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Bootstrap](https://getbootstrap.com) - UI Framework
- [Font Awesome](https://fontawesome.com) - Icons
- [MySQL](https://mysql.com) - Database
- All contributors who help improve this project

---

## ⭐ Show Your Support

Give a ⭐️ if this project helped you! It helps others discover the project.

### Share the Love

<div align="center">

[![GitHub Stars](https://img.shields.io/github/stars/wajihulqammar/laramedicare?style=social)](https://github.com/wajihulqammar/laramedicare/stargazers)
[![GitHub Forks](https://img.shields.io/github/forks/wajihulqammar/laramedicare?style=social)](https://github.com/wajihulqammar/laramedicare/network/members)
[![GitHub Watchers](https://img.shields.io/github/watchers/wajihulqammar/laramedicare?style=social)](https://github.com/wajihulqammar/laramedicare/watchers)

**[⬆ back to top](#-laramedicare---hospital-management-system)**

</div>

---

<div align="center">

**Made by WAJIH UL QAMMAR**

</div>
