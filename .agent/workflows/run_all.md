---
description: How to run the entire Business Management System
---

# Running the Business Management System

This project consists of three services that need to run concurrently.

## 1. Prerequisites
- **MySQL**: Ensure MySQL is running and a database named `business_management` exists.
- **Go**: Version 1.19+
- **PHP**: Version 8.1+ with Composer
- **Node.js**: Version 16+

## 2. Start Go Backend (API)
The backend must start first as other services depend on it.
```bash
cd backend_go
go run main.go
```
*Port: 8080*

## 3. Start Laravel Admin (CMS)
```bash
cd admin_laravel
composer install
php artisan key:generate
php artisan serve
```
*Port: 8000*

## 4. Start Node.js Integration (Automation)
```bash
cd integration_node
npm install
npm start
```
*Port: 3000*

## Troubleshooting
- **Auth Issues**: Ensure `JWT_SECRET` is identical in both `backend_go/.env` and `admin_laravel/.env` (if applicable) or that the Laravel app is correctly hitting the Go `/auth/login` endpoint.
- **DB Connection**: Check `.env` files in `backend_go` and `admin_laravel`.
