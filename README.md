# Barber Shop Inventory Management System

A full-stack PHP + MySQL web application designed to manage barber shop inventory, including product tracking, stock management, and CRUD operations for inventory items.

Developed as a team project using PHP, MySQL, HTML, and CSS, focusing on database management and backend development.


## Features

### Inventory Management (CRUD System)
- Create, update, and delete products
- Manage full product lifecycle in the system
- Centralized inventory control through a dashboard

### Dashboard Overview
- Displays key inventory information
- Provides a quick overview of stock status
- Helps monitor overall inventory health

### Product Search & Filtering
- Search products by name or keyword
- Filter products by category
- Improves navigation and inventory management efficiency

### Inventory Movements Tracking
- Tracks all stock movements (additions and removals)
- Maintains history of inventory changes per product
- Allows filtering of movement records for better tracking

### Stock Control System
- Updates stock automatically when products are added or removed
- Tracks real-time quantity changes per product

### Low Stock Alert System
- Detects when product quantity falls below minimum threshold
- Automatically sends email alerts for low-stock products
- Helps prevent inventory shortages

## Project Purpose

This system was built to simulate a real-world inventory management solution for a barber shop. Focusing on improving stock control, reducing shortages, and automating inventory tracking processes.

## Inventory Structure

Each product includes the following information:

- **Product Image** – Optional image of the product  
- **Name** – Name of the product  
- **Category** – Product category or type  
- **Quantity** – Current stock amount  
- **Minimum Quantity** – Minimum stock level before triggering low-stock alerts  
- **Price** – Product price  
- **Creation Date** – Automatically generated when the product is added  

## Access Control

The system uses a single authorized administrator account. User registration is not available, and all inventory management operations are restricted to this account.

## Tech Stack

- PHP
- MySQL
- HTML
- CSS

## Screenshots
### Login Page
  Authentication system that allows the authorized admin to securely access the inventory management system.
  <img width="2505" height="1250" alt="image" src="https://github.com/user-attachments/assets/ac900aba-da56-4fd1-a6db-33b3b3a42b07" />

### Dashboard Page
  Central control panel of the system that provides a quick summary of the inventory status.
  <img width="2498" height="1267" alt="image" src="https://github.com/user-attachments/assets/9b84b56d-200f-4376-9ecb-261553406097" />

### Product List
  Display all products registered in the inventory system.
  <img width="2504" height="1266" alt="image" src="https://github.com/user-attachments/assets/29bbb42d-1634-459f-83bc-c8c5d9b8c2ef" />

### Product Forms (Add/Edit)
  Forms used to manage product information in the inventory system.
  <img width="2504" height="1271" alt="image" src="https://github.com/user-attachments/assets/0beedecd-28bc-4595-9d04-2bd858fbe47c" />
  <img width="2498" height="1263" alt="image" src="https://github.com/user-attachments/assets/776269b5-27d8-4380-965c-80c9c3ccf6c8" />

### Inventory Movements
  Logs and tracks all stock changes made to product in the system.
  <img width="2500" height="1259" alt="image" src="https://github.com/user-attachments/assets/f1286ea7-14aa-4269-a847-de051a3a89a7" />


