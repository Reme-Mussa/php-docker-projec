# PHP Docker Project

## Overview
This project is a PHP application running in a Docker container. It uses the `php:8.0-apache` image for the PHP service and the `mysql:5.7` image for the MySQL database service. The application is structured to allow easy development and deployment using Docker.

## Directory Structure
```
php-docker-project
├── docker-compose.yml
├── src
│   ├── index.php
│   └── anotherfile.php
├── html
│   └── styles.css
└── README.md
```

## Setup Instructions

1. **Clone the Repository**
   Clone this repository to your local machine.

2. **Navigate to the Project Directory**
   Open a terminal and navigate to the project directory:
   ```
   cd php-docker-project
   ```

3. **Build and Start the Containers**
   Use Docker Compose to build and start the containers:
   ```
   docker-compose up -d
   ```

4. **Access the Application**
   Open your web browser and go to `http://localhost`. You should see the PHP application running.

5. **Database Access**
   The MySQL database can be accessed on port `3306`. Use the following credentials:
   - **Username:** root
   - **Password:** example
   - **Database Name:** exampledb

## Usage
- The main entry point of the application is `src/index.php`.
- Additional PHP functionality can be added in `src/anotherfile.php`.
- CSS styles for the application are defined in `html/styles.css`.

## Contributing
Feel free to contribute to this project by submitting issues or pull requests. 

## License
This project is licensed under the MIT License.