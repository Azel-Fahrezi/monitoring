<br />
<div id="readme-top" align="center">
![image](https://github.com/user-attachments/assets/736fcacd-1b8b-46b5-866a-e451bc4814c9)



<h3 align="center">Aplikasi Monitoring Temuan SPI</h3>

  <p align="center">
    Aplikasi Monitoring Temuan SPI.
    <br />
  </p>
</div>

### Built With

- CI4

### Prerequisites

Penting! install bahan dibawah ini:

- composer
- phpmyadmin (xampp,laragon)
- php-8+
- php-ext: mbstring & intl
- terminal/cmd (administrator/root)

### Installation

- Install Dependencies |
  Jika terjadi error, hapus composer.lock terlebih dahulu
  ```sh
  composer install
  ```
- Create Database
  ```sh
  php spark db:create sipjp
  ```
- Migrate Database or Refresh
  ```sh
  php spark migrate
  ```
  ```sh
  php spark migrate:refresh
  ```
- Seeding Database:table Superadmin
  ```sh
  php spark db:seed Superadmin
  ```
  username: superadmin
  password: superadmin
- Run App
  ```sh
  php spark serve
  ```
