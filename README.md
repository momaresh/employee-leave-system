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
```

---

## 🧪 Testing

To run tests (feature, unit, Livewire components):

```bash
php artisan test
```

---

## 🧑‍💻 Default Login (Seeded Users)

| Role    | Email               | Password   |
|---------|---------------------|------------|
| Admin   | admin@example.com   | password   |
| Employee| employee@example.com| password   |

You can change or add new users via database or using Tinker.

---

## 🌍 Language & RTL Support

You can switch languages via the top navbar. If Arabic is selected, the layout will automatically switch to RTL mode using Tailwind’s `dir="rtl"` class.

---

## 📁 Folder Structure

- `app/Livewire` - All Livewire components
- `resources/views` - Blade views
- `resources/lang` - Translations
- `tests/Feature` - Feature tests
- `tests/Unit` - Unit tests
- `database/factories` - Model factories

---

## 🧱 Future (Optional)

You can optionally move toward a **client-server architecture** by separating the API (Laravel backend) and frontend (Vue/React or Livewire SPA), following modern practices.

---

## 🤝 Contributing

Pull requests are welcome! Feel free to fork and improve the project.

---

## 📝 License

This project is open-source and available under the [MIT License](LICENSE).

