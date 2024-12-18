<p align="center"><a href="https://laravel.com" target="_blank"></a>

<img src="https://github.com/user-attachments/assets/9dd28a75-d3bc-4042-941d-fa51f2644fd7" width=400>
    
</p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>
# Laravel Library Management System

## Description

This Laravel-based Library Management System is a comprehensive solution for managing books, users, and borrowing processes in a library setting. It provides features for both administrators/staff and regular users, making it easy to catalog books, manage borrowings, and explore new titles.

## Features

- User authentication and role-based access control (Admin, Petugas, Peminjam)
- Book management (Add, Edit, Delete, View)
- Category, Publisher, and Rack management
- User management
- Borrowing process management
- Fine calculation and payment system
- Book exploration using ISBN API
- Responsive design with Tailwind CSS
- Dynamic sidebar for easy navigation

### Admin/Petugas Features
- Dashboard with statistics and charts
- Manage books, categories, publishers, and racks
- Approve or reject borrowing requests
- Manage user accounts
- Explore and add new books using ISBN API

### User Features
- Browse and search for books
- View book details
- Request to borrow books
- View borrowing history
- Pay fines (if applicable)

## Technologies Used

- Laravel 11
- PHP 8.1+
- MySQL
- Tailwind CSS
- Chart.js (for dashboard visualizations)
- Midtrans payment gateway integration

## Installation

1. Clone the repository:
   ```shell
   git clone https://github.com/Arya-f4/laravelperpus.git
   ```
2. Install the project repository:
   ```
   cd laravelperpus
   composer install
   ```
3. Run the project repository:
   ```
   php artisan serve && npm run dev
   ```
4. Run Migration and seeding :
   ```
   php artisan migrate:fresh --seed
   ```
5. Run Storage link :
   ```
   php artisan storage:link
   ```
    
