# 🏠 HomeDome: Welcome to the Home of Home Products

[![Website Live](https://img.shields.io/badge/Live_Site-HomeDome-FF6600?style=for-the-badge)](https://cs2team58.cs2410-web01pvm.aston.ac.uk/)

**HomeDome** is a modern, minimalist e-commerce marketplace designed specifically for first-time homeowners. Furnishing a new building can be overwhelming, so we built a platform that cuts out the noise. No unnecessary pages, no friction; just a smooth, efficient shopping experience to get your space sorted. 

Whether you're looking for appliances, furniture, kitchenware, home decor, or lighting, HomeDome operates on the principle of equivalent exchange: you give us your clicks, we give you a seamlessly furnished home.

## 📸 Preview
<img width="1919" height="990" alt="Screenshot 2026-03-26 150410" src="https://github.com/user-attachments/assets/1b4139d0-206e-4434-a08c-3dc9244a4078" />





## ✨ Core Features

* **Frictionless Shopping:** Tailored UX/UI for younger, first-time buyers with short attention spans. Get in, find what you need, check out.
* **Categorized Inventory:** Browse effortlessly through Appliances, Furniture, Kitchenware, Home Decor, and Lighting.
* **Admin Dashboard:** A dedicated portal for site administrators to manage user accounts, monitor stock levels, oversee customer orders, and update product listings.
* **Secure Authentication:** Robust user login and registration powered by Laravel's built-in security features.

## 🛠 Tech Stack

Our Team of 7 developers utilized the following technologies to bring HomeDome to life:

**Backend:**
* **PHP / Laravel:** Chosen for its advanced security features, scalability, and the Eloquent ORM for seamless database management.
* **MySQL:** Relational database handling users, orders, and complex product relationships.

**Frontend:**
* **HTML5, CSS3, JavaScript:** For a responsive, dynamic user interface.
* **Vite / NPM:** Asset bundling and frontend compilation.

**Version Control & Hosting:**
* **GitHub:** Agile team collaboration and version control.

## ⚙️ Installation & Setup

Want to run HomeDome locally? Just follow these steps to get your local environment running:

### Prerequisites
Make sure you have **PHP**, **Composer**, **Node.js/NPM**, and **MySQL** installed on your machine.

### Step-by-Step Guide

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/your-username/homedome.git](https://github.com/your-username/homedome.git)
   cd homedome
   ```
2. **Install PHP dependencies (Laravel):**
 ```bash
        composer install
   ```
3.**Install Frontend dependencies (Node/Vite):**
```bash
       npm install
   ```
4.**Set up your environment variables:**
```bash
       cp .env.example .env
   ```
5.**Generate the application key:**
```bash
      php artisan key:generate
   ```
6.**Run database migrations:**
```bash
     php artisan migrate --seed
   ```
7.**Awaken the servers:**
**You will need two terminal windows open for this.**
Terminal 1:
```bash
     php artisan serve
   ```
Terminal 2:
```bash
   npm run dev
   ```

## Contributors

<table>
  <tr>
    <td align="center">
      <a href="https://github.com/amanjit805">
        <img src="https://avatars.githubusercontent.com/amanjit805" width="100px;" alt="Amanjit"/><br />
        <sub><b>Amanjit Singh</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/hoonathan521-commits">
        <img src="https://avatars.githubusercontent.com/hoonathan521-commits" width="100px;" alt="Nathan"/><br />
        <sub><b>Nathan Hoo</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/muhammed2226">
        <img src="https://avatars.githubusercontent.com/muhammed2226" width="100px;" alt="muhammed"/><br />
        <sub><b>Muhammed Afjar</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Najwanlaskar">
        <img src="https://avatars.githubusercontent.com/Najwanlaskar" width="100px;" alt="najwan"/><br />
        <sub><b>Najwan Laskar</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/sima693">
        <img src="https://avatars.githubusercontent.com/sima693" width="100px;" alt="ahmed abdulrahman"/><br />
        <sub><b>Ahmed Abdulrahman</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/spiteman1">
        <img src="https://avatars.githubusercontent.com/spiteman1" width="100px;" alt="Donell"/><br />
        <sub><b>Donell Zhanje</b></sub>
      </a>
    </td>
    <td align="center">
      <a href="https://github.com/Ashvinth04">
        <img src="https://avatars.githubusercontent.com/Ashvinth04" width="100px;" alt="Ashvinth"/><br />
        <sub><b>Ashvinth Anandavel</b></sub>
      </a>
    </td>
  </tr>
</table>
