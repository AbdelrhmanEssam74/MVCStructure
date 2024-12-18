# 🚀 MVCStructure

## 📌 Project Overview

**MVCStructure** is a clean and well-organized implementation of the **Model-View-Controller (MVC)** design pattern. This project promotes **separation of concerns** by dividing application functionality into **Models**, **Views**, and **Controllers**, making your codebase maintainable, scalable, and easy to navigate.

It includes routing, configuration, validation, and asset management to help you build full-featured web applications efficiently.

---

## 📚 Table of Contents

- [Project Overview](##project-overview)
- [Directory Structure](#directory-structure)
- [Directory Overview](#DirectoryOverview)
- [Installation](#installation)
- [Contributing](#contributing)
- [License](#license)

---

## 📁 Directory Structure

Below is the complete directory structure for **MVCStructure**:

```plaintext
.
├── 📁 App/                       # Main application directory
│   ├── 📁 controller/            # Application logic (controllers)
│   └── 📁 models/                # Data logic and database interactions
├── 📁 Config/                    # Application configuration files
├── 📁 database/                  # Database files (e.g., SQLite)
├── 📁 Public/                    # Publicly accessible files
│   ├── index.php                 # Application entry point
│   └── 📁 assets/                # Static assets
│       ├── 📁 css/               # Stylesheets
│       ├── 📁 js/                # JavaScript files
│       ├── 📁 fonts/             # Font files
│       └── 📁 images/            # Images and assets
├── 📁 routes/                    # Route definitions
├── 📁 src/                       # Source code directory
│   ├── 📁 HTTP/                  # HTTP-related classes
│   ├── 📁 support/               # Support utility classes
│   ├── 📁 view/                  # View-related classes
│   ├── 📁 Validation/            # Validation logic
│   │   ├── 📁 Rules/             # Custom validation rules
│   │       ├── 📁 Contract/      # Validation contracts
│   ├── 📁 Database/              # Database management classes
│   │   ├── 📁 Concerns/          # Database concerns
│   │   ├── 📁 Grammars/          # Database grammar logic
│   │   ├── 📁 Managers/          # Database managers
│   │       ├── 📁 Contract/      # Database contracts
│   └── Application.php           # Main application logic
├── 📁 views/                     # View templates
│   ├── 📁 auth/                  # Authentication templates
│   ├── 📁 errors/                # Error pages
│   ├── 📁 layout/                # Layout templates
│   ├── 📁 partials/              # Reusable partial templates
│   └── index.php                 # Main view file
└── README.md                     # Project documentation
```

---

## Directory Overview

The **MVCStructure** project follows the MVC pattern to structure the application, with each major component serving a distinct purpose:

## Entry Point

- **Entry Point (`Public/index.php`)**:The main entry point of the application where all incoming requests are handled. It bootstraps the application and routes requests to the appropriate controllers.

```bash
$ cd Public
$ php -S localhost:8000
```

## Models Directory (App/models/)

- **Models (`App/models/`)**: contains all the classes responsible for handling data logic and database communication. Models interact with the database, perform CRUD operations, and structure the data for the application

```php
// Implement Your Models Using abstract class Model
abstract class Model
{
     /**
     * Create a new row in the database table.
     * @param array $data Key-value pairs representing column names and their respective values.
     * Example: ['column_name' => 'value']
     */
    public static function create(array[])
    
     /**
     * Update existing records in the database.
     * @param string $whereColumn Column name for the WHERE clause.
     * @param mixed $value Value to filter the records by.
     * @param array $data Key-value pairs for columns to be updated.
     * Example: ['column_to_update' => 'new_value']
     */
    public static function update(string $whereColumn, $value, array $data)
    
     /**
     * Delete records from the database.
     * @param string $whereColumn Column name for the WHERE clause.
     * @param mixed $value Value to filter the records by.
     */
    public static function delete(string $whereColumn, $value) 
    
     /**
     * Fetch all records from the database.
     * @return  List of all records.
     */
    public static function all()
    
     /**
     * Fetch specific records based on filter conditions.
     * @param array|string $columns Columns to retrieve (e.g., ["column1", "column2"]) or '*' for all columns.
     * @param array $filter Filter conditions as ["column", "operator", "value"].
     * Example: ["age", ">", "18"]
     * @return  List of filtered records.
     */
    public static function where($columns = '*', array $filter = [])
}
// Example of a User Model
namespace App\Models;

class User extends Model {
    // Create your methods
    public function getAll() {
        // Fetch all users from the database
    }
}
```

## Controllers Directory (App/controller/)

- **Controllers (`App/controller/`)**: Handles the application logic by processing incoming requests, retrieving data from models, and determining the appropriate views to render. Controllers act as intermediaries between models and views.

```php
// Namespace declaration for the controller
namespace App\Controller;

class HomeController {

    /**
     * Handles the logic for the home page.
     *
     * This method prepares data and renders a view. You can pass data
     * to the view using the `extract()` function, enabling variables
     * to be accessible in the view file.
     * access the key in the view file as a variable ($key)
     */
    public function index() {
        // Define the data to be passed to the view
        $data = [
            'key' => 'value'
        ];

        // Render a view file. You can specify the file using:
        // - A direct filename: "filename"
        // - A path within a folder: "folder.filename"
        return View::makeView("filename" , $data); // Single file
        // OR
        return View::makeView("folder.filename" , $data); // File within a folder
    }
}

```

## Source Directory (src/)

The `src/` directory houses the core framework functionality and reusable components:

- **📁 HTTP**: Manages HTTP-related functionality (e.g., requests, responses).
  - _Request.php_ :
  ```php
  // Example of urls
  // you can add your own custom patterns
  $routePatterns =
  [
    $segments[0] . '/' . $segments[1] . '/{Controller}/{method}/{param}',
    $segments[0] . '/' . $segments[1] . '/{param1}/{param2}{...'
  ];
  ```
- **📁 View**: Provides support for view rendering and template management.
- **📁 Validation**: Contains validation logic and rules for form and input validation.

  - _validation.php_

  ```php
  // use validation in your controller
  // create a validator instance
  $validator = new Validation();
  // apply the rules to the validator
  $validator->rules([
  'filedName' => 'RuleName|rule:tableName,column',
  ]);
  // Example
  $validator->rules([
  'email' => 'required|email|email_exists:users,email'
  ]);
  ```

  - _📁 Rules_

    ```php
    //How to create a new rule?
    /*
    1 - create a new class with the rule name and implements the rules interface
    2- implements the two main methods for creating a new rule
    */
    public function apply($field, $value, $data): false|int
    {
        return //Your Logic Here;
    }

    public function __toString()
    {
        return "%s Your Message in Error";
    }
    // $s will be replaced with the filed name

    ```

    - _RulesMap.php_

      ```php
      // This is a map of all the rules
      protected static array $map = [
        'RuleName' => RuleClass::class,
      ]
      // Example
      protected static array $map = [
        'required' => RequiredRule::class,
      ]
      ```

- **📁 Database**: Handles database connections, grammars, and query management.

- **📁 Support**: Additional helper classes or utilities that support the application.

## Config Directory (config/)

- **Config (`config/`)**: contains configuration files for managing environment settings, database connections, and other system parameters.
  - *database.php*
    ```php
    return [
    'default'   => env("DB_DRIVER", ''),
    'localhost' => env("DB_HOST", ''),
    'database'  => env("DB_DATABASE", ''),
    'username'  => env('DB_USERNAME', 'root'),
    'password'  => env('DB_PASSWORD', ''),
    ];
    ```

## Database Directory (database/)

- **Database (`database/`)**: Includes database-related files such as SQLite database files, migrations, or seeds required to structure and initialize the database.

```plaintext
database/
├── SQLite
      └── database.db

```

## Views Directory (views/)

The `views/` Contains user interface templates that render the front end of the application. Views are organized as follows::

- **📁 Layouts**: Contain Main file which contains {{content}} which replaced with the page template

```html
<!-- Example: Layout Template -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?= env('APP_NAME') ?></title>
  </head>
  <body>
    <?php include 'partials/header.php'; ?>
    {{content}}
    <?php include 'partials/footer.php'; ?>
  </body>
</html>
```

- **📁 Partials**: Reusable components like navigation bars and sidebars.
- **📁 Errors**: Templates for displaying error pages (e.g., 404, 500).
- **📁 Authentication**: Templates for login, registration, and authentication flows.

## Routes Directory (routes/)

- **Routes (`routes/`)**: Defines all application routes and maps them to their respective controllers and actions. Routes handle incoming HTTP requests (e.g., GET, POST) and determine which controller logic to execute.
  For instance, adding a new route might look like:

```php
// routes/web.php
// Example: Defining Routes
Route::get('/', [HomeController::class, 'index']);
Route::post('/submit', [FormController::class, 'submit']);
```

This route definition would map a GET request to `/home` to the `index` method in the `HomeController`.

---

## Installation

To set up **MVCStructure** on your local environment, follow these steps:

1. **Clone the Repository**

   Clone the repository to your local environment:

   ```bash
   git clone https://github.com/AbdelrhmanEssam74/MVCStructure.git
   cd MVCStructure
   ```

2. **Install PHP Dependencies**

   Ensure [Composer](https://getcomposer.org/) is installed, then run:

   ```bash
   composer install
   ```

3. **Install Node.js Dependencies**

   Install Node.js dependencies for static assets (e.g., CSS, JavaScript):

   ```bash
   npm install
   ```

4. **Run the Application**

   Navigate to the `Public` directory and start the PHP server:

   ```bash
   cd Public
   php -S localhost:800
   ```

   The application should now be accessible at `http://localhost:800` Or use Your Host.

---

## Contributing

Contributions are welcome! Here’s how to get started:

1. **Fork the Repository** on GitHub.
2. **Create a Feature Branch** locally:
   ```bash
   git checkout -b feature/new-feature
   ```
3. **Commit Your Changes** with clear and concise messages:
   ```bash
   git commit -m "Add new feature"
   ```
4. **Push to Your Branch**:
   ```bash
   git push origin feature/new-feature
   ```
5. **Open a Pull Request** on GitHub.

Please ensure that your code follows best practices and includes documentation for maintainability.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

Thank you for using **MVCStructure**!

## The rest of the documentation will be written soon
