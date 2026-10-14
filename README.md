# Laravel E-Commerce Platform

A fully-featured e-commerce web application built with Laravel, designed to provide a seamless shopping experience for customers and a comprehensive management dashboard for administrators.

## 🚀 Features

- **User Authentication:** Secure login, registration, and session management using Laravel Jetstream and Sanctum.
- **Product & Category Management:** Admins can seamlessly add, edit, and organize products into categories.
- **Shopping Cart:** Intuitive cart system allowing users to add, remove, and review items before checkout.
- **Order Management:** Robust order tracking system for both users and administrators.
- **Payment Gateway Integration:** Secure payment processing implemented via the **Stripe API**.
- **Automated Invoicing:** Dynamic generation of downloadable PDF invoices and receipts using DOMPDF.
- **Responsive Modern UI:** Clean, responsive, and fast user interface built with Tailwind CSS and bundled using Vite.

## 🛠️ Tech Stack

- **Backend Framework:** Laravel (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS, Vite
- **Database:** MySQL
- **Payments:** Stripe PHP SDK
- **PDF Generation:** DOMPDF (`barryvdh/laravel-dompdf`)

## 📦 Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone <your-repository-url>
   cd Ecommerce-Laravel
   ```

2. **Install PHP and Node.js dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration:**
   Copy the example environment file and generate a new application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup:**
   Update your `.env` file with your local database credentials (e.g., MySQL):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ecommerce_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Stripe Configuration:**
   Add your Stripe API keys to the `.env` file to enable checkout functionalities:
   ```env
   STRIPE_KEY=your_stripe_public_key
   STRIPE_SECRET=your_stripe_secret_key
   ```

6. **Run Migrations:**
   Create the necessary database tables:
   ```bash
   php artisan migrate
   ```

7. **Start the Development Servers:**
   Run both the Vite server for frontend assets and the Laravel development server:
   ```bash
   npm run dev
   php artisan serve
   ```

## 📂 Project Structure Highlights
- `app/Models/`: Contains models like `User`, `Product`, `Order`, `Cart`, and `Catagory`.
- `app/Http/Controllers/`: Contains `AdminController` for backend management and `HomeController` for the user-facing storefront.

## 📖 Comprehensive Documentation & Workflow
For an in-depth breakdown of all user features, admin dashboard capabilities, database relationships, and Mermaid system workflows, see:
👉 **[DOCUMENTATION.md](DOCUMENTATION.md)**

## 📄 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

