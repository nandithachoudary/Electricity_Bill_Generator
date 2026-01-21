# ⚡ Electricity Bill Generator & Management System

>> A web-based application to automate electricity billing, meter reading entry, and online payments, designed to replicate the official TSSPDCL experience.

## 📖 Project Overview
The **Electricity Bill Generator** is a full-stack web application designed to digitize the billing cycle for electricity distribution companies. It replaces manual paper-based systems with a centralized database that handles user registration, monthly meter readings, bill calculation, and online payments.

The system features a **3-Tier Role-Based Access Control (RBAC)** architecture, ensuring secure and specific functionality for Administrators, Field Supervisors, and Consumers.

## Features by Role

### 1. Admin (Manager)
* **User Registration:** Registers new service connections with static details (Service Number, USC, Meter Number, Load, Address).
* **Account Shell:** Creates the initial profile for users to claim via their Service Number.

### 2. Supervisor (Field Agent)
* **Monthly Data Entry:** Inputs the current month's meter reading for a specific Service Number.
* **Smart Bill Generation:**
    * **Auto-Calculation:** Automatically calculates `Units = Current - Previous`.
    * **Rolling Arrears:** If a previous bill is "Unpaid," the system automatically adds that amount to the current month's bill.
    * **Correction Mode:** Detects if a bill for the current month already exists and *updates* it (fixing errors) instead of creating duplicates.

### 3. Customer (End User)
* **Bill History:** View a complete tabular history of all past electricity bills.
* **Thermal Receipt View:** Generates a digital bill that visually replicates the actual **TSSPDCL thermal paper receipt** (CSS styled with monospace fonts).
* **Online Payment:** A "Pay Now" feature for the latest unpaid bill, which instantly updates status and clears arrears.

## Tech Stack
* **Frontend:** HTML5, CSS3 (Custom "Thermal Receipt" styling)
* **Backend:** PHP (Session management, Logic handling)
* **Database:** MySQL (Relational schema linking Users to Monthly Bills)
* **Server:** Apache (via WAMP)

## ⚙️ Installation & Setup

1. **Install XAMPP or WAMP** on your computer.
2. **Clone this repository** into your `htdocs` or `www` folder:
   ```bash
   git clone https://github.com/nandithachoudary/Electricity_Bill_Generator.git
