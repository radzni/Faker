<?php

require 'vendor/autoload.php';

use Faker\Factory as Faker;

$host = 'localhost';
$dbname = 'ph_company';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Function to generate random Filipino names
function generateFullName() {
    $firstNames = ['Juan', 'Maria', 'Jose', 'Ana', 'Pedro', 'Luz', 'Ramon', 'Carmen', 'Alfonso', 'Isabel'];
    $lastNames = ['Dela Cruz', 'Santos', 'Reyes', 'Gonzales', 'Bautista', 'Cruz', 'Torres', 'Alvarez', 'Flores', 'Garcia'];

    $firstName = $firstNames[array_rand($firstNames)];
    $lastName = $lastNames[array_rand($lastNames)];

    return "$firstName $lastName";
}

// Function to generate random email address
function generateEmail($fullName) {
    $emailDomains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
    $nameParts = explode(' ', strtolower($fullName));
    $email = implode('.', $nameParts) . '@' . $emailDomains[array_rand($emailDomains)];
    return $email;
}

// Function to generate random phone number
function generatePhoneNumber() {
    return '+63 9' . rand(100000000, 999999999);
}

// Function to generate random birthdate
function generateBirthdate() {
    $start = strtotime('1980-01-01');
    $end = strtotime('2003-12-31');
    $timestamp = mt_rand($start, $end);
    return date('Y-m-d', $timestamp);
}

// Function to generate random job title
function generateJobTitle() {
    $jobTitles = ['Software Engineer', 'Teacher', 'Nurse', 'Accountant', 'Sales Associate', 'Web Developer', 'Graphic Designer', 'Data Analyst', 'Project Manager', 'Marketing Specialist'];
    return $jobTitles[array_rand($jobTitles)];
}

// Number of fake profiles to generate
$numProfiles = 5; 

// Array to hold user profiles
$userProfiles = [];

for ($i = 0; $i < $numProfiles; $i++) {
    $fullName = generateFullName();
    $email = generateEmail($fullName);
    $phone = generatePhoneNumber();
    $birthdate = generateBirthdate();
    $jobTitle = generateJobTitle();

    $userProfiles[] = [
        'fullName' => $fullName,
        'email' => $email,
        'phone' => $phone,
        'birthdate' => $birthdate,
        'jobTitle' => $jobTitle,
    ];

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO user_profiles (full_name, email, phone, birthdate, job_title) VALUES (:fullName, :email, :phone, :birthdate, :jobTitle)");
    $stmt->execute([
        ':fullName' => $fullName,
        ':email' => $email,
        ':phone' => $phone,
        ':birthdate' => $birthdate,
        ':jobTitle' => $jobTitle,
    ]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Fake User Profiles</title>
</head>
<body>

<div class="container mt-5">
    <h2>Fake User Profiles</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone Number</th>
                <th>Birthdate</th>
                <th>Job Title</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userProfiles as $profile): ?>
                <tr>
                    <td><?php echo $profile['fullName']; ?></td>
                    <td><?php echo $profile['email']; ?></td>
                    <td><?php echo $profile['phone']; ?></td>
                    <td><?php echo $profile['birthdate']; ?></td>
                    <td><?php echo $profile['jobTitle']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>