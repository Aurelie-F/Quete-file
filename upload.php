<?php
$directory = 'uploads/';
$errors = [];
if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (count($_FILES['files']['name']) > 0) {
        $maxSize = 1000000;
        $extensions = array('png', 'gif', 'jpg');
        for ($i = 0; $i < count($_FILES['files']['name']); $i++) {
            $size = $_FILES['files']['size'][$i];
            $extension = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION);
            if (!in_array($extension, $extensions)) {
                $errors[] = 'Vous devez uploader un fichier de type png, gif, ou jpg...';
            }
            if ($size > $maxSize) {
                $errors[] = 'Le fichier est trop gros...';
            }

            if (empty($errors)) {
                $uploadFile = $directory . uniqid() . '.' . $extension;
                move_uploaded_file($_FILES['files']['tmp_name'][$i], $uploadFile);
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload</title>
</head>
<body>
<?php if(!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input type="file" name="files[]" multiple>
    <button>Submit</button>
</form>
<?php $iteratorFile = new FilesystemIterator($directory); ?>
<ul>
    <?php foreach ($iteratorFile as $fileInfo): ?>
        <li><?= $fileInfo->getFilename(); ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>
