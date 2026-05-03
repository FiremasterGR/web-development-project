<?php
  $servername="localhost";
  $username="root";
  $password="";
  $conn=new mysqli($servername, $username, $password);
  if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
  }
  $databaseName="ServerDatabase1";
  $sql="CREATE DATABASE IF NOT EXISTS `$databaseName`";
  if (!$conn->query($sql)){
    die("Database creation error: " . $conn->error);
  }
  $conn->select_db($databaseName);
  $sql="CREATE TABLE IF NOT EXISTS users(
  usertoken VARCHAR(255) NULL,
  expirydate DATETIME NULL,
  username VARCHAR(15) NOT NULL,
  password VARCHAR(30) NOT NULL,
  phone INT NOT NULL,
  email VARCHAR(320) NOT NULL,
  PRIMARY KEY (username)
  )";
  if ($conn->query($sql) != TRUE){
    die("Σφάλμα στη βάση δεδομένων:\n" . $conn->error);
  }
  $sql="SHOW FULL TABLES IN `$databaseName` WHERE Table_type = 'SEQUENCE' AND `Tables_in_$databaseName` = 'shared_id'";
  $result=$conn->query($sql);
  if ($result->num_rows == 0){
    $sql="CREATE SEQUENCE shared_id START WITH 1 INCREMENT BY 1";
    if (!$conn->query($sql)){
      die("Error creating sequence: " . $conn->error);
    }
  }
  $sql="CREATE TABLE IF NOT EXISTS assetsid(
  id INT UNSIGNED NOT NULL PRIMARY KEY DEFAULT (NEXT VALUE FOR shared_id)
  )";
  if (!$conn->query($sql)){
    die("Error creating assetsid: " . $conn->error);
  }
  $sql="CREATE TABLE IF NOT EXISTS residentials(
  id INT UNSIGNED NOT NULL,
  username VARCHAR(15) NOT NULL,
  sellorrent BOOLEAN NOT NULL,
  bargainright BOOLEAN NOT NULL,
  TK INT NOT NULL,
  TM INT NOT NULL,
  cost INT NOT NULL,
  bathrooms INT NOT NULL,
  bedrooms INT NOT NULL,
  apartmentnum INT NOT NULL,
  floors VARCHAR(5) NOT NULL,
  city VARCHAR(50) NOT NULL,
  area VARCHAR(50) NOT NULL,
  address VARCHAR(50) NOT NULL,
  type VARCHAR(50) NOT NULL,
  PRIMARY KEY (address, TK, floors, city, area, apartmentnum),
  FOREIGN KEY (username) REFERENCES users(username),
  FOREIGN KEY (id) REFERENCES assetsid(id)
  )";
  if (!$conn->query($sql)){
    die("Error creating residentials: " . $conn->error);
  }
  $sql="CREATE TABLE IF NOT EXISTS commercials (
  id INT UNSIGNED NOT NULL,
  username VARCHAR(15) NOT NULL,
  sellorrent BOOLEAN NOT NULL,
  bargainright BOOLEAN NOT NULL,
  TK INT NOT NULL,
  TM INT NOT NULL,
  cost INT NOT NULL,
  floors VARCHAR(5) NOT NULL,
  city VARCHAR(50) NOT NULL,
  area VARCHAR(50) NOT NULL,
  address VARCHAR(50) NOT NULL,
  type VARCHAR(50) NOT NULL,
  PRIMARY KEY (address, TK, floors, city, area),
  FOREIGN KEY (username) REFERENCES users(username),
  FOREIGN KEY (id) REFERENCES assetsid(id)
  )";
  if ($conn->query($sql) != TRUE){
    die("Σφάλμα στη βάση δεδομένων:\n" . $conn->error);
  }
  $sql="CREATE TABLE IF NOT EXISTS images(
  assetsid INT UNSIGNED NOT NULL,
  imagecontent VARCHAR(1000) NOT NULL,
  imagename VARCHAR(100) NOT NULL,
  imageid INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  FOREIGN KEY (assetsid) REFERENCES assetsid(id)
  )";
  if ($conn->query($sql) != TRUE){
    die("Σφάλμα στη βάση δεδομένων:\n" . $conn->error);
  }
?>