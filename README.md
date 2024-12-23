# 🚀 MVCStructure

## 📌 Project Overview

**MVCStructure** is a clean and well-organized implementation of the **Model-View-Controller (MVC)** design pattern. This project promotes **separation of concerns** by dividing application functionality into **Models**, **Views**, and **Controllers**, making your codebase maintainable, scalable, and easy to navigate.

It includes routing, configuration, validation, and asset management to help you build full-featured web applications efficiently

---

## 📚 Table of Contents

- [📌 Project Overview](#-project-overview)
- [📂 Directory Structure](#-directory-structure)
- [📜 Directory Overview](#-directory-overview)
- [📥 Installation](#-installation)
- [🤝 Contributing](#-contributing)

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

## 📜 Directory Overview

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
  - *📁 Grammars.php*: Handles grammars and query management for database based on database driver
    ```plaintext
    ├── MySQLGrammar.php
    ├── SQLiteGrammar.php
    ```
  - *📁 Managers.php*:  
    - *📁 Contracts* :
        ```plaintext
            ├── DatabaseManager.php  $interface of DatabaseManager 
        ```
    
    ```plaintext
    ├── MySQLManager.php
    ├── SQLiteManager.php
    ```

    - **📁 Support**: Additional helper classes or utilities that support the application.
      - ***Arr.php***:
        The `Arr.php` file contains the Arr class,
        a utility for performing advanced operations on arrays and array-like objects.

        - **Key Features**:
          - **Subset Operations**:
            - `only`: Extracts specific keys and their values from an array.
            - `except`: Removes specific keys and their values from an array.
          - **Key Management**:
            - `set`: Sets a value in an array using dot notation for nested keys.
            - `add`: Adds a value to the array if the key does not already exist.
            - `forget`: Removes keys from an array using dot notation.
          - **Key Existence**:
             - `accessible`: Checks if a value is array-like (ArrayAccess or plain array).
             - `exists`: Checks if a key exists in an array or ArrayAccess object.
             - `has`: Verifies the presence of nested keys in an array.
        
          - **Value Retrieval**:
            - `get`: Retrieves a value from an array using dot notation for nested keys.
            - `first`: Gets the first element of an array, optionally filtered by a callback.
            - `last`: Gets the last element of an array, optionally filtered by a callback.
            Array Manipulation:
      - ***EmailHelper.php:***
        The `EmailHelper.php` file provides a class designed to facilitate email sending using the PHPMailer library. It simplifies the process of configuring SMTP and sending emails with customizable options.
        - *Key Features:*
          - *SMTP Configuration:*
            - Configures the mailer to use Gmail's SMTP server (`smtp.gmail.com`) with secure communication (`ENCRYPTION_STARTTLS`).
            - Utilizes SMTP authentication with a default sender email (`Your Gmail Sender`).
            - Sets the default port for sending emails (`587`).
          - *Default Settings:*
            - Predefines the sender email address and name (`Sender Name`).
             - Configures the mailer to send HTML emails by default.
          - *Email Sending:*
            - `sendEmail($to, $subject, $body)`:
              - Sends an email to the specified recipient.
              - Accepts the recipient's email address, subject line, and message body as parameters.
              - Automatically sets the character set to UTF-8 and enables HTML content.
              - Provides error handling with detailed error messages if email sending fails.
      - ***Hash.php***
        The `Hash.php` file provides a utility class for handling password hashing, verification, and token generation. This class ensures secure password storage and easy validation for authentication systems.
        - *Key Features*:
          - Password Hashing:
            - Utilizes the `PASSWORD_BCRYPT` algorithm for secure password hashing.
          - Password Verification:
            - Compares a `plain-text` password with its `hashed` counterpart to confirm validity.
          - Token Generation:
            - Generates a unique token using `SHA-1` encryption and a timestamp.
        - *Method*
          - `hash($password)`: string
            - Hashes the given password using the `PASSWORD_BCRYPT` algorithm
            - ```php
              $hashedPassword = Hash::hash('myPassword');  
              ```
          - `verify($password, $hashedPassword)`:
            - Verifies that a plain-text password matches its hashed version.
            ```php
            $isValid = Hash::verify('myPassword', $hashedPassword);
            ```
          - `makeToken($value)`: string
            - Creates a unique token by hashing the input value concatenated with the current timestamp using the `SHA-1` algorithm.
            ```php
            $token = Hash::makeToken('uniqueValue'); 
            ```
      - ***Helpers.php***
        - The `Helpers.php` file contains a collection of utility functions designed to streamline common operations within the application. These functions enhance developer productivity by simplifying tasks like configuration management, request handling, environment variable access, and more.
          - *Key Features*
            - Environment Variables
              - `env`: Retrieves the value of an environment variable with a fallback option.
            - Dynamic Value Resolution 
              - `value`: Evaluates a closure or returns the value directly.
            - Path Utilities 
              - `base_path`: Returns the base directory of the project. 
              - `view_path`: Provides the path to the views' directory. 
              - `config_path`: Provides the path to the configuration files directory.
            - Session and Request Handling 
              - `old`: Retrieves the previous value of a form field from session flash data. 
              - `request`: Handles HTTP requests and retrieves input data. 
              - `backRedirect`: Redirects the user to the previous page.
            - Application Management 
              - `app`: Returns the singleton instance of the Application class. 
              - `config`: Retrieves or sets configuration values.
            - Redirects 
              - `RedirectToView`: Redirects the user to a specified path.
            - String and Class Utilities 
              - `class_basename`: Returns the base class name, stripping namespace information. 
              - `bcrypt`: Hashes passwords using the application's hashing utility.
            - Date and Time 
              - `getCurrentDate`: Returns the current date and time formatted as specified.
            - Authentication Code 
              - `GenerateAuthCode`: Generates a random 6-digit authentication code.
          - Detailed Method Descriptions 
            - `env($key, $value = null)`
              - Retrieves the value of an environment variable or a default value if not set. 
            - `value($value)`
              - Resolves a closure or returns the value directly. 
            - `base_path()`
              - Returns the base directory path of the project.
            - `view_path()`
              - Returns the path to the views' directory. 
            - `old($key)`
              - Retrieves the previous value of a form field from session flash data. 
            - `request($key = null)`
              - Retrieves specific input data from an HTTP request.
            - `backRedirect()`
              - Redirects the user to the previous page. 
            - `app()`
              - Provides the singleton instance of the application.
            - `class_basename($class)`
              - Strips namespaces to return the base name of a class.
            - `bcrypt($password)`
              - Hashes a plain-text password for secure storage.
            - `config_path()`
              - Returns the path to the configuration files directory.
            - `config($key = null, $default = null)`
              - Retrieves or sets application configuration values.
            - `RedirectToView($path)`
              - Redirects the user to a specific application path.
            - `getCurrentDate($selector = "Y:m:d h:s:i")`
              - Returns the current date and time formatted as per the selector.
            - `GenerateAuthCode()`
              - Generates a secure 6-digit random authentication code.
      - ***Sessions.php***
        - The `Sessions.php` file defines the `Sessions` class, which provides a robust framework for managing session data and flash messages in a PHP application. It simplifies session handling by offering methods to store, retrieve, and manage data, ensuring clean and efficient session operations.
          - *Key Features*
            - Flash Message Handling
              - Flash messages persist for a single request and are automatically removed afterward.
              - Methods include setting, retrieving, and checking flash messages.
            - Session Data Management 
              - Provides methods to set, retrieve, check, and remove session variables. 
              - Ensures clean session handling by marking flash messages for removal after usage.
            - Automatic Cleanup 
              - Flash messages marked for removal are automatically cleared during the destructor process.
            - Session Initialization 
              - Automatically starts the session if it has not been started already.
          - *Detailed Method Descriptions*
            - `__construct()`
              - Initializes the session and marks flash messages for removal after their first retrieval.
            - Flash Message Methods
              - `setFlash($key, $message)`: Stores a flash message with a specified key and value.
              - `getFlash($key)`: Retrieves the value of a flash message by its key.
              - `hasFlash($key)`: Checks if a flash message exists for the specified key.
            - Session Variable Methods
              - `set($key, $value)`: Sets a session variable with a key-value pair.
              - `get($key)`: Retrieves the value of a session variable by its key.
              - `exists($key)`: Checks if a session variable exists for the specified key.
              - `remove($key)`: Deletes a session variable by its key.
            - Flash Message Cleanup 
              - `removeFlashMessages()`: Removes flash messages marked for deletion. 
              - Invoked automatically by the destructor to maintain session cleanliness.
            - `__destruct()`
              - Automatically removes expired flash messages when the class is destroyed.
      - ***Str.php***
        - The `str.php` file defines the `str` class, which provides utility methods for string manipulation. The class focuses primarily on converting strings between singular and plural forms, as well as handling case transformations. It incorporates rules for regular pluralization and singularization, irregular word mappings, and uncountable words that do not change in form.
        - Key Features
          - Pluralization and Singularization 
            - Converts words between singular and plural forms based on defined regular expressions and mappings. 
            - Handles irregular words with predefined mappings. 
            - Supports uncountable words that remain the same in both forms. 
          - String Transformation 
            - Converts a string to lowercase. 
          - Customization and Extendability 
            - Easily extendable arrays for custom pluralization and singularization rules. 
            - Configurable list of uncountable words.
        - **Class Details**
          - Properties
            - `$plural`
              - An array of regular expressions and replacements for pluralizing words. 
              - Examples:
                - `quiz` → `quizzes` 
                - `mouse` → `mice` 
                - `child` → `children`
            - `$singular`
              - An array of regular expressions and replacements for singularizing words. 
              - Examples:
                - `quizzes` → `quiz`
                - `mice` → `mouse`
                - `children` → `child`
            - `$irregular`
              - A mapping of irregular singular and plural forms. 
              - Examples:
                - `person` → `people` 
                - `man` → `men`
            - `$uncountable`
              - A list of words that do not change between singular and plural forms. 
              - Examples:
                - `sheep`, `series`, `information`
          - ***Methods***
            - `lower($string): string`
              - Converts a string to lowercase. 
              - **Example Usage:**
                - ```php
                  str::lower("HelloWorld"); // Output: "helloworld"
                  ```
            - `plural($string): string`
              - Converts a string to its plural form using the following steps:
                - Checks if the word is uncountable; returns as-is if true. 
                - Matches against irregular word mappings. 
                - Applies regular pluralization rules using defined patterns.
                - **Example Usage:**
                - ```php
                  str::plural("child"); // Output: "children"
                  str::plural("mouse"); // Output: "mice"
                  ```
            - `singular($string): string`
              - Converts a string to its singular form using the following steps:
                - Checks if the word is uncountable; returns as-is if true.
                - Matches against irregular word mappings.
                - Applies regular singularization rules using defined patterns.
                - **Example Usage:**
                - ```php
                  str::singular("children"); // Output: "child"
                  str::singular("mice"); // Output: "mouse"
                  ```                  
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

## 📥 Installation

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

## 🤝 Contributing

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


Thank you for using **MVCStructure**!
