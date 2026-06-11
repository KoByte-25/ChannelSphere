# ChannelSphere

ChannelSphere is an order-and-delivery management platform that connects customers with multiple distribution companies (such as water delivery services) and coordinates real-time delivery and tracking between customers, companies, and drivers. It provides a unified web interface where customers place orders, companies manage fleets and assignments, and drivers confirm deliveries, all synchronized with live map tracking. [web:1354][web:1355][web:1360][web:1361]

---

## Table of Contents

- [Overview](#overview)
- [Key Features](#key-features)
- [User Roles](#user-roles)
  - [Customer](#customer)
  - [Distribution Company](#distribution-company)
  - [Driver / Delivery Person](#driver--delivery-person)
- [Order Lifecycle](#order-lifecycle)
- [Pages and Navigation](#pages-and-navigation)
  - [Customer Pages](#customer-pages)
  - [Company Pages](#company-pages)
  - [Driver Pages](#driver-pages)
- [Filtering and Search](#filtering-and-search)
- [Example Workflow](#example-workflow)
- [Future Improvements](#future-improvements)

---

## Overview

ChannelSphere allows customers to order products (for example, water bottles) from different distribution companies on a single website. It helps those companies assign orders to their delivery vehicles and enables drivers to see and complete their deliveries in real time. [web:1354][web:1361]

Core ideas:

- One platform for **multiple companies**.
- Customers choose **which company** to buy from.
- Companies manage **delivery vehicles**, capacity, and routes.
- Drivers see assigned orders only when the company dispatches a vehicle.
- Everyone can see **order status** and **live location** (when on delivery).

---

## Key Features

- **Multi-company marketplace**  
  Customers can choose from many distribution companies (e.g., water bottle distributors) when placing orders.

- **Account-based access**  
  - Customers must create an account to order and track deliveries.  
  - Companies must create an account to receive and manage orders.  
  - Drivers access only the orders assigned to their delivery vehicle.

- **Order management**  
  - Customers: place, view, and (in certain states) cancel orders.  
  - Companies: receive orders, assign them to available vehicles, and track their progress.  
  - Drivers: see assigned orders and confirm delivery.

- **Delivery vehicle management**  
  Companies can add delivery vehicles, set capacities, check availability, and dispatch vehicles.

- **Real-time map tracking**  
  For orders on delivery and for vehicles that are currently delivering, users can see real-time locations on a map.

- **Order history and filtering**  
  Delivered orders are stored in dedicated pages with date search and quick filters like “Today” and “All time”.

---

## User Roles

### Customer

Customers are end users who place orders and track their deliveries.

Main capabilities:

- Create an account and sign in.
- Browse and select products (e.g., water bottles).
- Choose from which company they want to buy.
- Place orders and see them on the **Order Items** page.
- Cancel orders **only while they haven’t been loaded onto a delivery vehicle**.
- Track delivery in real time once the order is on a vehicle.
- View completed deliveries on the **Delivered Orders** page.
- Search orders by date and use quick filters like “Today” and “All time”.

### Distribution Company

Distribution companies (e.g., water distribution companies) fulfill customer orders and manage delivery operations.

Main capabilities:

- Create a company account and sign in.
- Receive new customer orders.
- Add delivery vehicles with details like name/identifier and capacity.
- Assign undelivered orders to **available** vehicles, respecting capacity.
- Dispatch vehicles by clicking **“Deliver orders”**.
- See which vehicles are delivering and which are available.
- Track delivering vehicles on a map via **“See location”**.
- View on-delivery orders on the **On Delivery** page.
- View completed company deliveries on the **Delivered** page.
- Search orders by date and use quick filters like “Today” and “All time”.

### Driver / Delivery Person

Drivers and delivery people handle the actual delivery to customers.

Main capabilities:

- See orders for their assigned vehicle **only after** the company clicks **“Deliver orders”** for that vehicle.
- For each order, click **“Delivered”** after successfully delivering it to the customer.
- When all orders for a vehicle are delivered, the driver sees an **“I’ve returned”** button:
  - Clicking this confirms that the vehicle has returned to the company.
  - This changes the vehicle back to **Available**, so the company can load new orders onto it.

---

## Order Lifecycle

Typical order states in ChannelSphere:

1. **New / Pending**  
   - The customer has placed an order.
   - The order is not yet assigned to a vehicle.
   - Customer **can cancel** at this stage.

2. **Assigned (Queued on Vehicle)**  
   - The company assigns the order to an **available** delivery vehicle that still has capacity.
   - The vehicle has not been dispatched yet.
   - Customer **can still cancel**, because the vehicle is not yet delivering.

3. **On Delivery**  
   - The company clicks **“Deliver orders”** for the vehicle.
   - The vehicle is now delivering and becomes **unavailable** for new assignments.
   - The order is considered **on delivery**.
   - Customer **can no longer cancel**.
   - Customer sees a **“See location”** button to track the vehicle in real time.

4. **Delivered**  
   - The delivery person taps **“Delivered”** for that order.
   - The order moves to the customer’s **Delivered Orders** page.
   - It also appears on the company’s **Delivered** page.

5. **Vehicle Return**  
   - When all orders on a vehicle are delivered:
     - The driver sees an **“I’ve returned”** button.
     - Clicking it changes the vehicle’s status to **Available** again.

---

## Pages and Navigation

### Customer Pages

- **Order Items**  
  - Shows active (not yet delivered) orders.  
  - Includes actions such as:
    - “Cancel order” (only when order is not yet on a delivering vehicle).
    - “See location” (when the order is on delivery and bound to a vehicle).  

- **Delivered Orders**  
  - Lists all orders that have been delivered to the customer.  
  - Supports:
    - Search by date.
    - Quick filters like “Today” and “All time”.

### Company Pages

- **Dashboard / Orders Overview**  
  - Shows new orders and undelivered orders awaiting assignment.

- **Vehicles / Fleet Management**  
  - Add delivery vehicles via a form (name/ID, capacity, etc.).
  - See each vehicle’s status: **Available** or **Delivering**.
  - Check which orders are currently assigned to each vehicle.
  - Use **“Deliver orders”** to dispatch a vehicle.

- **On Delivery**  
  - Lists all orders currently on delivery (i.e., on actively delivering vehicles).
  - Allows viewing vehicle locations on a map via **“See location”**.

- **Delivered**  
  - Lists all completed deliveries for the company.
  - Includes search by date and quick filters such as “Today” and “All time”.

### Driver Pages

- **Active Deliveries**  
  - Shows all orders assigned to the driver’s vehicle once the company has dispatched it (after “Deliver orders”).
  - For each order:
    - The delivery person can mark **“Delivered”** when it reaches the customer.

- **Return Confirmation**  
  - When there are no more orders left on the vehicle:
    - The driver sees the **“I’ve returned”** button.
    - Clicking it sets the vehicle status back to **Available** for the company.

---

## Filtering and Search

ChannelSphere uses consistent filtering to simplify finding orders:

- **Search by date**  
  - Users can search orders within a selected date or date range.

- **Quick filters**  
  - **Today**: show orders created or updated on the current day.
  - **All time**: show the full history of orders without date restriction.

These quick filters help both customers and companies quickly switch between a daily view and a full-history view without manually adjusting dates.

---

## Example Workflow

A typical scenario might look like this:

1. **Customer** logs in and orders a water bottle from “BlueRiver Water Company”.  
2. The **company** logs in, sees the new order in the undelivered queue, and assigns it to “Truck 2” (a delivery vehicle) that has free capacity.  
3. Once enough orders are loaded, the company clicks **“Deliver orders”** for Truck 2.  
4. The **driver** of Truck 2 opens their interface and sees all orders loaded on Truck 2.  
5. The **customer** sees the order status change to **On delivery**, and can click **“See location”** to view Truck 2 on a live map.  
6. The **delivery person** delivers the order and taps **“Delivered”** for that order.  
7. The order moves to the customer’s **Delivered Orders** page and the company’s **Delivered** page.  
8. After all orders for Truck 2 are delivered, the **driver** taps **“I’ve returned”**, making Truck 2 **Available** again for new orders.

---

## Future Improvements

Possible future enhancements for ChannelSphere include:

- **Notifications**  
  - Email/SMS/push notifications for status changes (order confirmed, out for delivery, delivered).

- **Ratings and feedback**  
  - Customers rate companies and delivery experiences.

- **Advanced reporting**  
  - Analytics dashboards for companies (delivery times, vehicle utilization, order volume).

- **Role-based permissions**  
  - Finer separation between company admins, dispatchers, and drivers.

- **Multi-language support**  
  - Localized UI for different regions.

---

*This README describes the core concepts and workflows of ChannelSphere. You can extend it with installation, deployment, and technical details (stack, environment variables, database schema) as your implementation evolves.* [web:1354][web:1355][web:1360][web:1363]
