    **// index.php file
The index.php file in the public folder acts as the front controller, bootstrapping the application, initializing session handling, and mapping URLs to specific controller actions based on the request method (GET or POST). This structure enables a clear separation of concerns, making it easier to manage routing and request handling across the application. It's a common pattern in MVC frameworks.


    **// Router.php
The Router.php handles the routing logic and index.php initializes the application and delegates requests based on the defined routes. It keeps the application's entry point clean and focused on high-level bootstrapping, while Router.php takes care of the specifics of routing.

The app.php and database.php files are key components of the application's infrastructure, handling environment configuration and database connection setup, respectively.

    **// app.php File
The app.php file is responsible for bootstrapping the application. It uses the Dotenv library to load environment variables from a .env file, making it a secure place to store sensitive information like database credentials without hardcoding them into the source code. This is a common practice for configuring applications across different environments (development, testing, production) without changing the code. After loading the environment variables, it includes the funciones.php and database.php files to make their functionality available application-wide. Lastly, it initializes the connection to the database using the ActiveRecord pattern, which is a popular approach for interacting with database records in an object-oriented manner.

    **// database.php File
The database.php file establishes a connection to the MySQL database using the mysqli_connect function. It retrieves database connection details (host, user, password, and database name) from environment variables, which is a secure approach to manage sensitive information. The script checks the connection, and if it fails, it outputs an error message with details for debugging purposes. This setup ensures that the application can interact with the database securely and efficiently.

    **// funciones.php file.
This is a utility file that offers several important functionalities across the platform, including:

* Path Constants: Defines constants for image and document directories, making it easier to manage file storage paths.
* Debugging: Provides a debugging function for outputting variable information, useful for development and debugging.
* HTML Sanitization: Offers an s function to escape HTML characters, which is crucial for preventing XSS (Cross-Site Scripting) attacks by sanitizing user input or any output that might include HTML.
* Redirection: Includes functions for redirecting users, such as redireccionar, which validates an ID from the query string before redirecting, and various functions to check the user's authentication and authorization level (isAuth, isAdmin, isComprador, isMusico) before allowing access to certain pages or functionalities.
* Page and User State Helpers: Functions like pagina_actual and pagina_admin help manage UI states, such as highlighting the active menu item. The sesionActiva function redirects users to the appropriate dashboard based on their role.
* Localization and Internationalization: chooseLanguage and tt functions manage language selection and translation, enabling support for multiple languages by loading translations from a JSON file.

    **// Models Folder
The models folder contains the classes that represent the application's data and business logic. These models interact with the database to retrieve, insert, update, and delete data. In an MVC architecture, models encapsulate the application's state and the business rules that govern access to and updates of this state.

The models in the application extend the ActiveRecord class mentioned in the app.php file, providing an ORM-like layer for working with database records in an object-oriented way.
It includes methods for business logic associated with the specific entities in the application, such as users, albums, songs, etc. It also uses relationships (e.g., one-to-many, many-to-many) to define interactions between different entities in the system.

    **// ActiveRecord.php
The ActiveRecord.php file is a foundational piece for the model layer, implementing the Active Record design pattern. This pattern is a popular approach in object-relational mapping (ORM), facilitating direct interaction between the application's objects and the database tables.

--Key Features of ActiveRecord Class:
* Database Connection: The class uses a static property to hold the database connection, ensuring that all instances of ActiveRecord or its children can access the database without needing to establish a new connection each time.

* Table Mapping: Static properties like $tabla and $columnasDB are used to map the class to a specific database table and its columns, respectively. This mapping allows the class to abstract database operations for any table by overriding these properties in child classes.

* Error Handling and Validation: The class provides mechanisms for setting and getting alerts ($alertas), which can be used for error handling and form validation.

* CRUD Operations: Implements methods for creating (crear), reading (consultarSQL, all, find, etc.), updating (actualizar), and deleting (eliminar) records. These methods abstract the SQL operations, making it easier to work with database records in an object-oriented way.

* Utility Methods: Includes methods for sanitizing attributes before saving to the database (sanitizarAtributos), synchronizing in-memory objects with database records (sincronizar), and handling file uploads and deletions specifically for images and documents (setImagen, borrarImagen, setDocumento, borrarDocumento).

* Query Building: Offers flexible query capabilities, including fetching all records, records by ID, conditional fetching based on column values (where, whereAll), ordered fetching (allOrderBy, allOrderDesc, allOrderAsc), and even support for custom SQL queries.

    **// Controllers Folder
This folder contains comprehensive controllers that handles various aspects of authentication and user account management within the application, actions related to user profiles and settings via an API approach,  the rendering of different dashboard views based on user roles or permissions, handles both musical and artistic contracts, manage promotional materials, such as images or videos, for the application's main slider on the homepage, music modules facilitating artist management, album, singles and songs functionalities. It includes methods for user login, registration, password resets, account confirmation, and more, which are fundamental functionalities for maintaining a secure and user-friendly web application.

    **//main-layout.php
The main-layout.php file serves as the primary layout template for the application. This layout is a critical component of the view layer in the MVC architecture, defining the common structure and elements that will be present across various pages of the application.

    **//admin-layout.php
The admin-layout.php file is tailored for the admin section of the application, providing a specialized layout that includes administrative functionalities. This layout shares some similarities with the main-layout.php but is distinctively designed for the administrative interface, emphasizing management features and administrative tools.

    **//musica-layout.php
The musica-layout.php file is tailored for the music section, specifically designed for users involved in the music industry, such as musicians or music label managers. This layout shares structural similarities with the admin-layout.php but is specifically oriented towards the music section, incorporating elements and functionalities relevant to music management.

    **//header.php
The header.php file serves as the global header template for the application, included in various layouts to ensure a consistent top navigation experience across the site. It's designed to be flexible, accommodating both authenticated and unauthenticated users with conditional content

    **//admin-sidebar.php
The admin-sidebar.php template provides a sidebar navigation menu specifically for the admin section, allowing easy access to various administrative functionalities. It's a crucial component for enhancing the user experience by offering a structured and intuitive navigation system.

    **//header-dashboard.php
The header-dashboard.php file serves as the dashboard-specific header template, designed to enhance the user experience for logged-in users by providing a personalized greeting, navigation options, and language selection.

    **//main-sidebar.php
The main-sidebar.php template provides a primary navigation sidebar, featuring a set of icons for quick access to key sections such as home, search, cart, and categories. Additionally, it includes a dropdown menu for accessing help and FAQ pages.

    **//loading-screen.php
The loading-screen.php template defines a custom loading screen, which is initially hidden (display:none;) and shown during page load or while waiting for asynchronous operations to complete. The design creatively spells out "Filmtono" with individual letters animated or styled to enhance the visual appeal during the loading process. 

    **//footer.php
The footer.php template provides a comprehensive footer, encompassing various elements that enhance the user experience and accessibility of the site.

    **//src folder
This folder contains the javascript, scss, and images used in development. Everything is compiled into the public folder for the website to read.

    **//app.scss
The app.scss file serves as the primary entry point for compiling Sass (Syntactically Awesome Style Sheets) into CSS, organizing and modularizing the stylesheets for different parts of the application. By using the @use rule, it includes various SCSS files or directories, ensuring that styles from each of these parts are properly imported and applied.

    **//_index.scss
The index.scss file inside the scss folders uses the @forward rule, which is a part of the Sass module system introduced in Dart Sass. This rule makes it possible to organize and manage Sass styles more effectively by forwarding styles from individual files through a single entry point. 

    **//app.js 
The app.js serves as the entry point for the application's JavaScript, importing and instantiating an App class from ./UI/App.js. This pattern indicates that the App class acts as a central coordinator or initializer for components or logic.

    **//admin.js and filmtono.js
The admin.js and filmtono.js files shows a structured approach to handling different sections or functionalities, each importing and instantiating an App class from different directories (./admin/App.js and ./filmtono/App.js). This setup means that the application is divided into distinct modules or areas, likely serving different user roles or application states, such as an admin interface and a main user interface.

    **//language.js
The language.js module handles language selection functionality, leveraging the modularized DOM selectors imported from selectores.js.

    **//UI.js 
The UI.js module provides a comprehensive suite of UI interactions, encompassing functionality for dropdown menus, password visibility toggling, a main slider mechanism, among others.

    **//views folder
This folder contains all the pages of the website. They are rendered through the Router method (found in the Router.php file), using a controller method. All the relations for rendering can be found in the index.php file (located in /public/index.php)

    **//index.php
This is the entry point of the website. Through this file the views are rendered using the Router method, the controller, and the view.

    **//lang.JSON
This file contains all the content from the website in english and spanish. This file is read and processed and the code contains the variables set on it, so the html can display the language according to the selection.

    **//alerts.JSON
It has the same functionality as the lang.json file but for the content rendered from javascript.

    **//countries.json
This file contains information regarding all the countries voer the world to not depend on an external API for retreiving information

    **//contracts.json
This file has the same functionality as lang.json and alerts.json. It renders the information coming from the contracts to be rendered through the contract classes

    **//classes folder
This folder contains different methods for sending emails for contacts and buyers, create pdfs for the contracts, etc.