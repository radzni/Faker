<?php
/**
 * Fake Data Generator for Database
 * 
 */

// Require Composer's autoloader
require 'vendor/autoload.php';

// Use the Faker library
use Faker\Factory as Faker;

// Database connection parameters
$host = 'localhost';
$dbname = 'ph_company';
$username = 'root';
$password = 'root';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create a Faker instance with Philippine locale
    $faker = Faker::create('en_PH');
    
    // Clear existing data - using DELETE instead of TRUNCATE to avoid foreign key issues
    // Delete in reverse order of dependencies
    echo "Clearing existing data...\n";
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DELETE FROM transaction");
    $pdo->exec("DELETE FROM employee");
    $pdo->exec("DELETE FROM office");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    
    echo "Generating fake data...\n";
    
    // Generate Office data (50 rows)
    $officeIds = [];
    $stmt = $pdo->prepare("INSERT INTO office (id, name, contactnum, email, address, city, country, postal) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    echo "Generating Office data (50 rows)...\n";
    for ($i = 1; $i <= 50; $i++) {
        $officeId = $i;
        $officeName = $faker->company;
        $contactNum = $faker->phoneNumber;
        $email = $faker->companyEmail;
        $address = $faker->streetAddress;
        $city = $faker->city;
        $country = 'Philippines';
        $postal = $faker->postcode;
        
        $stmt->execute([$officeId, $officeName, $contactNum, $email, $address, $city, $country, $postal]);
        $officeIds[] = $officeId;
        
        if ($i % 10 == 0) {
            echo "  Generated $i offices\n";
        }
    }
    
    // Generate Employee data (200 rows)
    $employeeIds = [];
    $stmt = $pdo->prepare("INSERT INTO employee (id, lastname, firstname, office_id, address) VALUES (?, ?, ?, ?, ?)");
    
    echo "Generating Employee data (200 rows)...\n";
    for ($i = 1; $i <= 200; $i++) {
        $employeeId = $i;
        $lastName = $faker->lastName;
        $firstName = $faker->firstName;
        $officeId = $faker->randomElement($officeIds); // Random selection from existing office IDs
        $address = $faker->address;
        
        $stmt->execute([$employeeId, $lastName, $firstName, $officeId, $address]);
        $employeeIds[] = $employeeId;
        
        if ($i % 50 == 0) {
            echo "  Generated $i employees\n";
        }
    }
    
    // Generate Transaction data (500 rows)
    $stmt = $pdo->prepare("INSERT INTO transaction (id, employee_id, office_id, datelog, action, remarks, documentcode) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    echo "Generating Transaction data (500 rows)...\n";
    $currentDate = new DateTime();
    
    for ($i = 1; $i <= 500; $i++) {
        $transactionId = $i;
        $employeeId = $faker->randomElement($employeeIds); // Random selection from existing employee IDs
        
        // Get the office_id of the selected employee
        $stmtGetOffice = $pdo->prepare("SELECT office_id FROM employee WHERE id = ?");
        $stmtGetOffice->execute([$employeeId]);
        $employeeOfficeId = $stmtGetOffice->fetchColumn();
        
        // Randomly decide whether to use employee's office or another office
        $officeId = $faker->boolean(70) ? $employeeOfficeId : $faker->randomElement($officeIds);
        
        // Generate a random date up to 2years in the past (not future)
        $datelog = $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s');
        
        $actions = ['Create', 'Read', 'Update', 'Delete', 'Approve', 'Reject', 'Submit', 'Review'];
        $action = $faker->randomElement($actions);
        
        $remarks = $faker->sentence(10);
        $documentCode = strtoupper($faker->bothify('DOC-####-???'));
        
        $stmt->execute([$transactionId, $employeeId, $officeId, $datelog, $action, $remarks, $documentCode]);
        
        if ($i % 100 == 0) {
            echo "  Generated $i transactions\n";
        }
    }
    
    echo "Data generation completed successfully!\n";
    echo "Generated 50 offices, 200 employees, and 500 transactions.\n";
    
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>