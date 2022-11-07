<?php
require "db.php";
$pdo = new \PDO(DSN, USER, PASS);

if (!empty($_FILES['files']['name'][0])) {

    $files = $_FILES['files'];
    $fileName = $_POST['name'];
    $fileTag = $_POST['tag'];
    $fileDescription = $_POST['description'];
    $convert = $_POST['convert'];

    $uploaded = array();
    $failed = array();

    $allowed = array('jpg', 'jpeg', 'png', 'webp');

    foreach ($files['name'] as $position => $file_name) {

        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];
        $file_error = $files['error'][$position];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        if (in_array($file_ext, $allowed)) {

            if ($file_error === 0) {

                if ($file_size <= 2097152) /* 2mb */ {

                    $file_name_new = uniqid('IMG-', true) . '.' . $file_ext;
                    $file_destination = 'uploads/' . $file_name_new;

                    if (move_uploaded_file($file_tmp, $file_destination)) {

                        $uploaded[$position] = $file_destination;

                        $query = "INSERT INTO images(name, tag, description, images) VALUES (:name, :tag, :description,:images)";
                        $statement = $pdo->prepare($query);

                        $statement->bindValue(':name', $fileName, \PDO::PARAM_STR);
                        $statement->bindValue(':tag', $fileTag, \PDO::PARAM_STR);
                        $statement->bindValue(':description', $fileDescription, \PDO::PARAM_STR);
                        $statement->bindValue(':images', $file_name_new, \PDO::PARAM_STR);
                        $statement->execute();

                        $upload = $statement->fetchAll();
                    } else {
                        $failed[$position] = "[{$file_name}] failed to upload.";
                    }
                } else {
                    $failed[$position] = "[{$file_name}] is too large.";
                }
            } else {
                $failed[$position] = "[{$file_name}] failed to upload {$file_error}.";
            }
        } else {
            $failed[$position] = "[{$file_name}] file extension '{$file_ext}' is not allowed.";
        }
    }

    /* if (!empty($uploaded)) {
        echo "your file is uploaded";
        //print_r($uploaded);
    } */

    if (!empty($failed)) {
        print_r($failed);
    }
} else {
    echo 'no files';
}

$convertDir = 'convert/' . $file_name_new;

if (exif_imagetype($file_destination) == IMAGETYPE_PNG && $convert === 'webp') {

    $image = imagecreatefrompng($file_destination);
    imagewebp($image, str_replace('png', 'webp', $convertDir));
} elseif (exif_imagetype($file_destination) == IMAGETYPE_JPEG && $convert === 'webp') {

    $image = imagecreatefromjpeg($file_destination);
    imagewebp($image, str_replace('jpg', 'webp', $convertDir));
} elseif (exif_imagetype($file_destination) == IMAGETYPE_WEBP && $convert === 'png') {

    $image = imagecreatefromwebp($file_destination);
    imagepng($image, str_replace('webp', 'png', $convertDir));
} elseif (exif_imagetype($file_destination) == IMAGETYPE_WEBP && $convert === 'jpg') {

    $image = imagecreatefromwebp($file_destination);
    imagejpeg($image, str_replace('webp', 'jpg', $convertDir));
} else {
    echo "can't convert it";
}

var_dump($file_name_new);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
</head>

<body>
    <div>
        <a link href="/">back</a>
    </div>
    <div>
        <a link href="view.php">galery</a>
    </div>
</body>

</html>