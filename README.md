# News Application

This is a simple news application built with jQuery DataTables, Ajax, and Google Fonts APIs. The application has a controller named `NewsController` with two functions: one for opening the index page and another for fetching data from a given URL. The HTML, CSS, JS, and Ajax are written in the `views/news/index` file.

## Features

- **Search**: Search functionality implemented using jQuery DataTables.
- **Sort**: Sorting of data columns using jQuery DataTables.
- **Pagination**: Paginated display of data using jQuery DataTables.

## Installation

To set up this project, follow the steps below:

### Prerequisites

- PHP 7.4 or higher
- Composer

### Steps

1. **Clone the repository:**

   ```bash
   git clone https://github.com/roni836/NewsBlog

2. **Install PHP dependencies:**

    ```bash
    - composer install

3. **Serve the application:**

    ```bash
    - php artisan serve


### Packages Used

    jQuery DataTables: v1.11.4
    Ajax: For asynchronous data fetching
    Google Fonts APIs: For custom fonts

### Project Structure

**Controllers:**

**NewsController:** - Handles the logic for the news application.

    - index(): Opens the index page.
    - getData(): Fetches data from the given URL.

**Routes:**

Defined in routes/web.php.

    - Route::get('/', [NewsController::class, 'index']);
    - Route::get('/get-data', [NewsController::class, 'getData']);

**Views:**

    -Located in resources/views/news/index.blade.php.
    This file contains the HTML, CSS, JS, and Ajax code for the application.

