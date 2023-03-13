<?php

require "config.php";

session_start();

$msg = 'Upload Your Files to Get their Links';

if (isset($_POST['submit'])) {

    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $filesize = $_FILES['uploadfile']['size'];
    $folder = "./image/" . $filename;
    $folderlink = "image/" . $filename;


    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";

    $link .= "://";

    $link .= $_SERVER['HTTP_HOST'];

    $link .= $_SERVER['REQUEST_URI'];

    $link .= $folderlink;

    $sql = "INSERT INTO files (name,file_size,link) VALUES ('$filename','$filesize','$link')";

    mysqli_query($con, $sql);

    if (move_uploaded_file($tempname, $folder)) {
        $msg = "Your Link is : <a href='" . $link . "'>" . $link . " </a>";
    } else {
        echo "<h3>  Failed to upload image!</h3>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDFtoLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container col-6">
        <form method="post" class="mx-auto text-center" enctype="multipart/form-data">
            <h1 class="mb-5 text-center">Upload Your Documents</h1>
            <div class="col-9 mx-auto text-center">
                <input class="form-control" type="file" accept=".pdf" name="uploadfile"><br>
            </div>
            <div class="col-3 mt-3 mx-auto text-center ">
                <button type="submit" class="btn form-control btn-success" name="submit">Upload</button>
            </div>
        </form>
        <hr>
        <div class="link m-3 text-dark text-center">
            <p><?php echo $msg ?></p>
        </div>
    </div>
</body>

</html>