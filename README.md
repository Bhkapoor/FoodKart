
🍔 FoodKart

A Role-Based Online Food Ordering System built with Core PHP & MySQL

FoodKart is a web-based food ordering platform that connects customers, restaurants, and administrators through a centralized system for restaurant management, food discovery, wishlist, cart, ordering, and payment processing.

The platform follows an admin-controlled food approval workflow, where restaurants can add food items and administrators can approve or reject them before they become visible to customers.

📖 About

FoodKart is a role-based online food ordering system developed using Core PHP, PDO, MySQL, HTML5, CSS3, Bootstrap 5.3.3, JavaScript, and jQuery.

The application is designed around three primary roles:

Role

Responsibilities

👤 Customer

Browse approved food, manage cart and wishlist, checkout, place orders, make payments, and view order history

🏪 Restaurant

Manage restaurant profile, add and manage food items, and handle customer orders

🛡️ Admin

Manage restaurants, review food submissions, approve/reject food, and monitor platform orders

✨ Core Features

👤 Customer

Feature

Description

🔐 Authentication

Registration, login, logout, and password reset

🍔 Food Browsing

Browse food items approved by the administrator

🛒 Cart

Add, remove, and manage food items

❤️ Wishlist

Save preferred food items

💳 Checkout

Enter delivery and payment information

💵 Cash on Delivery

Place orders using the COD payment flow

💳 Razorpay

Make online payments through Razorpay

📦 Orders

Place orders and view order history

👤 Profile

View and manage customer profile

🏪 Restaurant

Feature

Description

🔐 Authentication

Restaurant-owner registration and login

🏪 Profile

Manage restaurant information

📊 Dashboard

Restaurant overview and management

➕ Food Management

Add and edit food items

🗂️ Food Listing

Manage restaurant food

⏳ Approval

View food items pending admin approval

📦 Orders

View customer orders

🔎 Order Details

View customer, delivery, and payment information

🔄 Order Status

Manage order status such as confirm, cancel, and deliver

🛡️ Admin

Feature

Description

📊 Dashboard

Administrative overview

➕ Restaurants

Add and manage restaurants

🏪 Management

Activate or deactivate restaurants

🍔 Food Review

View food submitted by restaurants

⏳ Food Requests

Review pending food submissions

✅ Approval

Approve food items

❌ Rejection

Reject food items

📦 Orders

View and monitor platform orders

🔄 Application Workflow

                         ADMIN
                           │
                ┌──────────┴──────────┐
                │                     │
        Add / Manage            Review Food
         Restaurants            Submissions
                                      │
                              ┌───────┴───────┐
                              │               │
                           APPROVE         REJECT
                              │
                              ▼
                       Food Visible
                       to Customers
                              │
                              ▼
                          CUSTOMER
                              │
                         Browse Food
                              │
                    ┌─────────┴─────────┐
                    │                   │
                 Wishlist              Cart
                                        │
                                        ▼
                                    Checkout
                                        │
                              ┌─────────┴─────────┐
                              │                   │
                             COD              Razorpay
                              │                   │
                              └─────────┬─────────┘
                                        ▼
                                   Order Placed
                                        │
                                        ▼
                                  RESTAURANT
                                        │
                                        ▼
                            Pending → Confirmed
                                        │
                                        ▼
                                    Delivered

🍔 Food Approval Workflow

FoodKart prevents restaurants from directly publishing food items to customers.

Restaurant
    │
    ▼
Add Food Item
    │
    ▼
Pending Approval
    │
    ▼
Admin Reviews Food
    │
    ├──────────────► Reject
    │
    ▼
  Approve
    │
    ▼
Food Visible to Customers

Only food items approved by the administrator are displayed to customers.

📦 Restaurant Order Status

Pending
   ├──► Cancelled
   │
   └──► Confirmed
            │
            ▼
        Delivered

🛠️ Technology Stack

Category

Technology

Frontend

HTML5, CSS3, Bootstrap 5.3.3

Icons

Bootstrap Icons

JavaScript

JavaScript, jQuery

Backend

Core PHP

Database

MySQL

Database Access

PDO

Payment

Razorpay

Package Management

Composer

Local Development

XAMPP

Version Control

Git & GitHub

🗄️ Database Design

FoodKart uses 9 MySQL tables to manage users, restaurants, food items, carts, wishlists, orders, payments, images, and authentication-related data.

Table

Purpose

users

Stores customer, restaurant-owner, and admin accounts

restaurants

Stores restaurant information and owner relationship

foods

Stores restaurant food items

cart

Stores customer cart items

wishlist

Stores customer wishlist items

orders

Stores order, delivery, and payment information

order_item

Stores individual items belonging to an order

food_images

Stores food image records

password_resets

Stores password reset information

Database Relationships

users
 ├── restaurants ─────► foods
 │                         │
 │                         └── food_images
 │
 ├── cart ───────────────► foods
 │
 ├── wishlist ───────────► foods
 │
 └── orders ─────────────► order_item ─────► foods

Key Relationships

A user can own a restaurant.

A restaurant can contain multiple food items.

A user can have multiple cart entries.

A user can have multiple wishlist entries.

A user can place multiple orders.

An order can contain multiple order items.

Each order item references a food item.

Food and restaurant records are connected through restaurant_id.

Food images are associated with food records.

Password reset information is maintained separately.

📁 Project Structure

FoodKart/
│
├── admin/                  # Admin module
│
├── restaurant/             # Restaurant module
│
├── user/                   # Customer module
│
├── process/                # Form processing and business logic
│
├── includes/               # Shared components and session handling
│
├── assets/
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
│
├── uploads/
│   ├── foods/              # Food images
│   ├── profiles/           # Profile images
│   └── restaurants/        # Restaurant images
│
├── config/                 # Database configuration
│
├── database/               # Database resources
│
├── index.php               # Application entry point
├── composer.json           # Composer dependencies
├── composer.lock           # Locked dependency versions
├── .gitignore
└── README.md

⚙️ Installation & Setup

1. Clone the Repository

git clone https://github.com/Bhkapoor/FoodKart.git

2. Move the Project

Place the project inside the XAMPP htdocs directory:

C:\xampp\htdocs\

3. Start XAMPP

Start the following services:

Apache
MySQL

4. Create the Database

Open phpMyAdmin:

http://localhost/phpmyadmin

Create a database for FoodKart and import the SQL file:

database/db.sql

If your SQL file is located elsewhere in the project, import the corresponding .sql file provided with the project.

5. Configure Database Connection

Configure the database connection in the project's configuration file.

Example:

$host = "localhost";
$username = "root";
$password = "";
$database = "foodkart";

Note: Database credentials should not be committed to GitHub. Keep your local configuration file excluded through .gitignore.

6. Install Composer Dependencies

From the project directory:

composer install

7. Configure Razorpay

Add your Razorpay API credentials to your local configuration.

Never commit Razorpay secret keys or other sensitive credentials to GitHub.

8. Run the Application

Open the project in your browser:

http://localhost/FoodKart/

💳 Payment Integration

FoodKart supports two payment methods:

Cash on Delivery

Cart
  │
  ▼
Checkout
  │
  ▼
COD
  │
  ▼
Order Placed

Razorpay

Cart
  │
  ▼
Checkout
  │
  ▼
Razorpay
  │
  ▼
Payment
  │
  ▼
Order Placed

Razorpay is integrated to provide online payment functionality during checkout.

🔐 Security

FoodKart follows basic application security practices including:

Role-based access for Admin, Restaurant, and Customer

PDO-based database access

Separate database configuration

Sensitive configuration excluded through .gitignore

Razorpay credentials kept outside the public repository

Authentication-based access to protected functionality

Password reset functionality

🚀 Future Enhancements

🔔 Real-time notifications

⭐ Restaurant and food ratings/reviews

🔎 Advanced food search and filtering

📍 Location-based restaurant discovery

📦 Real-time order tracking

📊 Advanced admin analytics

📱 Mobile-focused improvements

💬 Customer and restaurant communication

🧾 Downloadable order invoices

🎯 Project Highlights

Role-based architecture for Admin, Restaurant, and Customer

Admin-controlled food approval workflow

Restaurant food management

Customer wishlist and cart functionality

COD and Razorpay payment options

Complete food ordering workflow

MySQL database with PDO

Composer dependency management

Bootstrap-based responsive interface

Separate dashboards for different user roles

👩‍💻 Author

Bharti Kapoor

GitHub: Bhkapoor
