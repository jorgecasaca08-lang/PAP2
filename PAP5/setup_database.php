<?php
// Database credentials from config
require_once 'includes/config.php';

// SQL queries from db.sql
$sql = "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'user',
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `users` (`username`, `password`, `role`) VALUES
('admin', '$2y$10$v7V3OcZGG2L89dd7ZBKVKu2gV9ei8dkkd/6gncraSjc7zNc03PCGa', 'admin'),
('user', '$2y$10$I.G.2YF2G6E8H8J8K8L8M8N8O8P8Q8R8S8T8U8V8W8X8Y8Z8.a', 'user');

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `portfolio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `cv_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cv_path` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$createdb_sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
if ($conn->query($createdb_sql) === TRUE) {
    echo "Database created successfully\n";
} else {
    echo "Error creating database: " . $conn->error . "\n";
}

$conn->close();

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Execute multi query
if ($conn->multi_query($sql)) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
