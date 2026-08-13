# 🚗 Car Loan Payment Tracker

A **Progressive Web App (PWA)** for tracking car installment loan payments, built with Laravel and Vue.js.

This is a **personal test project** created to explore building a modern PWA with Laravel, Vue.js, and Inertia.js.

## ✨ Features

### 🚘 Car & Loan Details

Capture and manage important information about your car installment loan:

* Car brand
* Car model
* Dealer details
* Down payment
* Monthly installment amount

### 📊 Dashboard

Get an overview of your car loan payment progress:

* 💰 Total amount paid
* 📅 Number of months paid
* 🧾 Payment history
* 💵 Remaining balance
* 📆 Remaining months

The dashboard provides a quick summary of your current loan status and payment progress.

### 💳 Payment Tracking

Record each car loan payment with detailed information:

* Payment amount
* Payment month
* Payment year
* Payment date
* Payment method
* Payment receipt upload

Receipts can be uploaded and stored alongside the corresponding payment record for easier reference.

### ⚙️ Settings

Manage your account and application preferences:

* Update your profile information
* Toggle the visibility of selected dashboard information
* Manage personal preferences

## 📱 Progressive Web App

The application is built as a **Progressive Web App (PWA)**, allowing it to provide a mobile-friendly experience while still being accessible through a web browser.

The goal is to make tracking car loan payments convenient from both desktop and mobile devices.

## 🛠️ Tech Stack

* **Laravel** — Backend
* **Vue.js** — Frontend
* **Inertia.js** — Server-side routing and communication between Laravel and Vue
* **PWA** — Progressive Web App functionality

## 🏗️ Architecture

The application uses **Laravel + Inertia.js + Vue.js**:

```text
┌──────────────────────┐
│       Vue.js         │
│      Frontend        │
└──────────┬───────────┘
           │
           │ Inertia.js
           ▼
┌──────────────────────┐
│       Laravel        │
│       Backend        │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│       Database       │
└──────────────────────┘
```

## 🚀 Getting Started

### Requirements

Make sure you have the following installed:

* PHP
* Composer
* Node.js
* npm
* A database supported by Laravel

### Installation

Clone the repository:

```bash
git clone <repository-url>
```

Navigate to the project directory:

```bash
cd <project-directory>
```

Install PHP dependencies:

```bash
composer install
```

Install frontend dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure your database and other environment variables in `.env`.

Run database migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

In another terminal, start the Vite development server:

```bash
npm run dev
```

## 📱 PWA

The application can be installed on supported devices as a Progressive Web App, providing a more app-like experience for managing your car loan payments.

## 🎯 Project Purpose

This project was created as a **personal test project** to experiment with:

* Laravel application development
* Vue.js frontend development
* Inertia.js
* Progressive Web Apps
* Payment tracking and data visualization
* Receipt/file uploads
* Responsive mobile-first interfaces

## 🔮 Future Improvements

Potential features that could be added in the future:

* Payment reminders
* Multiple car/loan support
* Monthly payment notifications
* Loan payment charts
* Export payment history
* Receipt management
* Automatic payment calculations
* Dark mode

## 📄 License

This project is a personal test project and is not intended as a financial or loan management service.

---

**Car Loan Payment Tracker — Keep track of your payments. Know your balance. 🚗💳**

<img width="543" height="637" alt="CLPTPWALOGIN" src="https://github.com/user-attachments/assets/30e66a30-4936-4a47-8e1d-6d43a8bb5b95" />

<img width="996" height="2160" alt="CLPTPWA" src="https://github.com/user-attachments/assets/84d51b0b-5f80-4e4b-b0be-2f6893c56c8f" />


