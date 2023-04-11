<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uploadDir = 'images/';
    $uniqueName = uniqid($_POST['name'], true);
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $file = $uniqueName . "." . $extension;
    $uploadFile = $uploadDir . basename($file);
    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
    $maxFileSize = 1000000;
    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou gif ou webp ou Png !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <form action="/form.php" method="post" enctype="multipart/form-data">
        <label for="name">Name: </label>
        <input type="text" name="name" id="name" required>
        <label for="imageUpload">Upload an profile image</label>
        <input type="file" name="avatar" id="imageUpload" />
        <button name="send">Send</button>
    </form>
    <div class="img">
        <?php if ($_SERVER['REQUEST_METHOD'] === "POST") : ?>
            <?= $_POST['name'] . " : " ?>
            <img src="<?= $uploadDir . $file ?>">
        <?php endif ?>
    </div>
</body>

</html>