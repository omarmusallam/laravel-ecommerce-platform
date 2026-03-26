# Laravel E-Commerce Platform

A Laravel-based e-commerce application built to manage products, shopping cart workflows, checkout processes, order handling, payment integration, and administrative operations.

This project demonstrates practical experience in building a complete e-commerce system with both customer-facing features and backend management tools.

---

## Project Status

Core e-commerce workflows, checkout processes, payment integration, and order management are implemented. The project is being continuously refined as part of my professional portfolio.

---

## Overview

This project was developed as a full-featured e-commerce platform that supports product browsing, shopping cart management, checkout flow, order lifecycle handling, and role-based administration.

It combines business workflow logic, payment-related processes, and backend administration into a single Laravel-based web application.

---

## Key Features

- Product and category management
- Shopping cart system
- Checkout workflow
- Order and order item management
- Stripe payment integration
- Admin dashboard
- API support
- Role-based access control
- Wishlist and review system
- Customer account flow
- Product import/export support
- Multi-language support
- Delivery and order tracking logic

---

## Tech Stack

- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Frontend:** Blade, JavaScript, Tailwind CSS
- **Authentication:** Laravel auth / Sanctum
- **Payments:** Stripe
- **Authorization:** Roles, abilities, and policies
- **Architecture:** Web + API support, jobs, events, listeners

---

## Main Modules

### Customer Side
- Browse products
- View categories and product details
- Add products to cart
- Complete checkout flow
- Track orders
- Manage wishlist and reviews

### Admin Dashboard
- Manage products and categories
- Monitor orders
- Handle payment-related operations
- Control store settings
- Manage delivery and business workflows

### Payment & Order System
- Checkout processing
- Stripe payment integration
- Order creation and tracking
- Payment callbacks / webhooks
- Order lifecycle handling

### API Layer
- API endpoints for selected store features
- Authenticated access where required
- Integration support for frontend or external consumers

---

## Highlighted Technical Areas

This project demonstrates practical experience in:

- Laravel e-commerce development
- Shopping cart and checkout implementation
- Payment gateway integration
- Order lifecycle management
- Admin dashboard development
- API development and authentication
- Role-based access control
- Business workflow implementation
- Jobs, events, and listeners
- Product import/export handling

---

## Installation

```bash
git clone https://github.com/omarmusallam/laravel-ecommerce.git
cd laravel-ecommerce
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
