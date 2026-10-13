# Inventory & Stock Management System - RESTful API

A robust RESTful API for inventory management and warehouse stock mutation tracking built with Laravel, featuring JWT (JSON Web Token) authentication and Role-Based Access Control (RBAC).

---

## Tech Stack
- **Framework**: Laravel 11 / 12 (PHP 8.2+)
- **Database**: MySQL 8.0+
- **Authentication**: JWT Auth (`php-open-source-saver/jwt-auth`)
- **Testing**: PHPUnit / Feature Tests
- **Coding Standard**: PSR-12 (Laravel Pint)

---

## Getting Started

### 1. Clone & Navigate to Directory
```bash
cd backend
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration (.env)
Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```

Ensure your database credentials in `.env` match your local MySQL configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key & JWT Secret
```bash
php artisan key:generate
php artisan jwt:secret
```

### 5. Run Migrations & Seeders
This command creates the database schema and seeds 36 demo user accounts, 15 categories, 15 suppliers, 25 catalog products, and 20 stock mutation transaction records:
```bash
php artisan migrate --seed
```

> **Alternative SQL Dump**: If you prefer not to run seeders, a complete SQL dump file is available at `database/dump.sql` and can be imported directly via phpMyAdmin or MySQL CLI.

### 6. Start Local Development Server
```bash
php artisan serve
```
The backend API is now running at: `http://localhost:8000`

---

## Demo Accounts for Testing

All demo accounts use the same uniform password: `password`

| Role | Demo Email | Primary Permissions |
| :--- | :--- | :--- |
| **Superadmin** | `superadmin@demo.com` | Full access, user & staff management (admin & staff accounts) |
| **Admin** | `admin@demo.com` | Full CRUD for master products, categories, suppliers, and stock mutations |
| **Staff** | `staff@demo.com` | View catalog & record incoming/outgoing stock mutations |

---

## Running Automated Feature Tests
This project comes with 26 automated feature test scenarios covering JWT authentication, product CRUD, RBAC, dashboard valuation, and mutation transactions:

```bash
php artisan test
```

---

## API Endpoints Summary (Prefix `/api`)

### Authentication
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `POST` | `/api/register` | Register new user (default role: staff) | Public |
| `POST` | `/api/login` | Login & generate JWT token | Public |
| `GET` | `/api/me` | Current authenticated user profile | JWT Auth |
| `POST` | `/api/logout` | Invalidate current token | JWT Auth |

### Dashboard & Monitoring
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/dashboard/summary` | Real-time asset valuation, estimated market margin, and stock alerts | JWT Auth |

### Master Products & Categories
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/products` | List products (Search, Category filter, Stock status, Pagination) | JWT Auth |
| `GET` | `/api/products/{id}` | Product details | JWT Auth |
| `POST` | `/api/products` | Create new product | Admin / Superadmin |
| `PUT` | `/api/products/{id}` | Update product details | Admin / Superadmin |
| `DELETE` | `/api/products/{id}` | Soft delete product | Admin / Superadmin |
| `GET` | `/api/categories` | List master categories | JWT Auth |
| `GET` | `/api/categories/{id}` | Category details | JWT Auth |
| `POST` | `/api/categories` | Create new category | Admin / Superadmin |
| `PUT` | `/api/categories/{id}` | Update category | Admin / Superadmin |
| `DELETE` | `/api/categories/{id}` | Delete category (relation-protected) | Admin / Superadmin |

### Master Suppliers
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/suppliers` | List suppliers | JWT Auth |
| `GET` | `/api/suppliers/{id}` | Supplier details | JWT Auth |
| `POST` | `/api/suppliers` | Create new supplier | Admin / Superadmin |
| `PUT` | `/api/suppliers/{id}` | Update supplier | Admin / Superadmin |
| `DELETE` | `/api/suppliers/{id}` | Delete supplier | Admin / Superadmin |

### Stock Mutations (Audit Trail)
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/stock-mutations` | Paginated transaction history (IN / OUT) | JWT Auth |
| `POST` | `/api/stock-mutations` | Record stock in (`in`) or stock out (`out`) | JWT Auth (All Roles) |

### User Management (RBAC)
| Method | Endpoint | Description | Access |
| :---: | :--- | :--- | :---: |
| `GET` | `/api/users` | List all user accounts (Paginated) | Superadmin / Admin |
| `GET` | `/api/users/{id}` | User account details | Superadmin / Admin |
| `POST` | `/api/users` | Create user account with assigned role | Superadmin / Admin |
| `PUT` | `/api/users/{id}` | Update role or user profile | Superadmin / Admin |
| `DELETE` | `/api/users/{id}` | Delete user account | Superadmin / Admin |
