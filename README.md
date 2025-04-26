# 🌿 Leave Management System

A modern Leave Management System built with **Laravel**, **Livewire**, and **Tailwind CSS**. This application allows administrators to manage employee leave requests, generate reports, and support multi-language (including RTL for Arabic) — all within a clean and interactive dashboard.

---

## 🚀 Features

- 🧑‍💼 **Admin/Employee roles** with separate dashboards
- ✉️ **Leave Requests** (submit, validate, approve, reject)
- 📊 **Leave Summary Reports** (with PDF export)
- 🔍 **Search & Filtering** with Livewire
- 🌐 **Multi-language** support (English / Arabic with RTL)
- 🧪 **Feature, Unit, and Livewire Component Tests**
- 🧪 **Model Factories** for dummy data
- 🎯 Clean component-based architecture using Livewire
- ☁️ Optional step towards API-based client-server architecture

---

## 📦 Requirements

Make sure your environment meets the following:

- PHP >= 8.1
- Composer
- Laravel >= 10
- Node.js & npm
- MySQL / PostgreSQL
- Git

---

## ⚙️ Installation

```bash
# 1. Clone the project
git clone https://github.com/your-username/leave-management-system.git
cd leave-management-system

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install && npm run build

# 4. Copy and configure your .env file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your database in .env
# DB_DATABASE=your_db
# DB_USERNAME=your_user
# DB_PASSWORD=your_password

# 7. Run migrations and seeders
php artisan migrate --seed

# 8. Serve the app
php artisan serve
