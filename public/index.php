<?php 
    $currentPage="home";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Αρχική</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <style>
        .speciallink{
            display: block;
            background-color: rgb(235, 235, 235);
            font-size: 2.5rem;
            text-align: center;
            margin:auto;
            width: 15rem;
            padding: 0.5rem;
            border-radius: 1.5rem;
        }
        .text1{
            margin-bottom: 6rem;
        }
    </style>
</head>
<body>
    <div class="content" id="content">
        <?php include('header.php'); ?>
        <p class="text1">Βρείτε το σπίτι των ονείρων σας.</p>
        <p class="text1">Ό,τι σπίτι και να θέλετε.</p>
        <p class="text1"><u>Το έχουμε!</u></p>
        <a href="houses.html" class="speciallink">Ξεκίνείστε</a>
    </div>
</body>
</html>
