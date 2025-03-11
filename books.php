<?php
//by Joseph
require 'vendor/autoload.php';

$faker = Faker\Factory::create();
$genres = ['Fiction', 'Mystery', 'Science Fiction', 'Fantasy', 'Romance', 'Thriller', 'Historical', 'Horror'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fake Book Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Fake Book Records</h2>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                    <th>Summary</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < 15; $i++): ?>
                <tr>
                    <td><?= $faker->sentence(3) ?></td>
                    <td><?= $faker->name ?></td>
                    <td><?= $genres[array_rand($genres)] ?></td>
                    <td><?= rand(1900, 2024) ?></td>
                    <td><?= $faker->isbn13 ?></td>
                    <td><?= $faker->paragraph ?></td>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
