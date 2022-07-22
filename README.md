# library-bild-be

Back-end development for the library-bild project (https://github.com/dumaaas/library-bild) built with Laravel framework + MySQL + Blade.

## 📚 Online library

Online Library is an Automated Library System that handles the various functions of the library. It provides a complete solution to the library management software.

### Features of Online Library:
 
 -  Integration of all records of students
 -  Manage the records systematically
 -  It can track any information online
 -  Manage all information online
 -  Easy to maintain records
 -  It leads to fast book entry

### Advantages of Online Library:

 -  It is user-friendly software
 -  It helps in maintaining records
 -  One can track any information through this system
 -  Searching is easy in the online library system
 -  Users can check the availability of a particular book online
 -  It increases the efficiency
 -  It saves human effort and time
 -  It reduces the chances of error
 -  It acts as an anti-theft

### The user role "Librarian" includes: 

 - overview of users
 - adding/deleting users
 - overview of books
 - adding/deleting/editing books
 - overview of rented, returned books (for a single users, for a single book, for all books)
 - overview of overdue books (for a single users, for a single book, for all books)
 - overview of active and archived reservations (for a single users, for a single book, for all books)
 - access to dashboard where he can see and filter with activities, latest reservation and book activity statistics
 - can reserve a book
 - can cancel the reservation
 - can rent a book
 - can return a book
 - can write off a book

### The user role "Administrator" includes:

 - inherits everything from the librarian 
 - overview of librarians
 - adding/deleting librarians
 - overview of genres, categories, bindigs, formats, languages, publisher, scripts
 - adding/deleting/editing all of the above
 - updating general policies for the book

### The user role "User" includes: 

 - overview of books
 - can reserve a book
 - can rent a book

This role will be developed with the mobile application.

## :man_technologist: How to install?

Run following snipets

 - cd /path/to/workspace/directory 
 - git clone https://github.com/dumaaas/library-bild-be.git 
 - cd library-bild-be 
 - composer install
 - copy .env.example .env(for linux users:'cp .env.example .env')
 - php artisan key:generate
 - open .env file enter required fields for database connection
 - start MySQL
 - php artisan migrate
 - php artisan storage:link
 - php artisan db:seed
 - php artisan serve

In seeder files you can find user credentials to log in. Every user has it s own dashboard and it should be pretty intuitive to use.

## 🚀 Tech/framework 

* Laravel
* MySQL
