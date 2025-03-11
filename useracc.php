<?php
require 'vendor/autoload.php';

$faker = Faker\Factory::create();

function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake User Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Fake User Accounts</h2>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th> <!-- number ng user -->
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Username</th>
                        <th>Password (SHA-256 Encrypted)</th>
                        <th>Account Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 10; $i++): 
                        $fullName = $faker->name;
                        $email = $faker->unique()->email;
                        $username = strtolower(explode('@', $email)[0]);
                        $password = hash('sha256', $faker->password);
                        $accountCreated = $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s');
                    ?>
                    <tr>
                        <td class="text-center"><?= $i ?></td>
                        <td><?= generateUUID() ?></td>
                        <td><?= htmlspecialchars($fullName) ?></td>
                        <td><?= htmlspecialchars($email) ?></td>
                        <td><?= htmlspecialchars($username) ?></td>
                        <td><?= htmlspecialchars($password) ?></td>
                        <td class="text-center"><?= htmlspecialchars($accountCreated) ?></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>