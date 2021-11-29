<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="viewport" content="width = device-width, initial-scale = 2.3, user-scalable = no"/>
    <meta name="viewport" content="width = device-width, initial-scale = 2.3, minimum-scale = 1, maximum-scale = 5"/>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <title>Submit A New Restaurant</title>
</head>
<body>
<?php include 'header.inc'; ?>

<?php
require 'vendor/autoload.php';

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === FALSE) {
    echo '<div class="alert alert-danger" role="alert">Please sign in first before submitting new restaurants to the site</div>';;
    die();
}
if (isset($_POST["name"])) {
    // process new restaurant submission
    define("DB_HOST", "localhost");
    define("DB_NAME", "4ww3");
    define("DB_CHARSET", "utf8");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");

    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
            DB_USER, DB_PASSWORD
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $ex) {
        exit($ex->getMessage());
    }
    // upload the image file to s3
    // generate random uuid as file name to avoid possible filename collision
    $file_name = uniqid();

    $temp_file = $_FILES['image']['tmp_name'];

    $s3Client = new Aws\S3\S3Client([
        'region' => 'us-east-1',
        'version' => 'latest',
        'credentials' => [
                //TODO: use as env var
            'key' => 'AKIAV64CCC5FUEAG5VG7',
            'secret' => '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',
        ]
    ]);

    $result = $s3Client->putObject([
        'Bucket' => '4ww3wheretoeat',
        'Key' => $file_name,
        'SourceFile' => $temp_file
    ]);

    $stmt = $pdo->prepare("INSERT INTO `restaurant` (`name`, `description`, `latitude`, `longitude`, `image`) VALUES (:name, :description, :latitude, :longitude, :image)");

    $stmt->bindValue(':name', $_POST["name"]);
    $stmt->bindValue(':description', $_POST["description"]);
    $stmt->bindValue(':latitude', $_POST["lat"]);
    $stmt->bindValue(':longitude', $_POST["lon"]);
    // store image url into db as s3 prefix + img file name
    $stmt->bindValue(':image', "https://4ww3wheretoeat.s3.amazonaws.com/" . $file_name);
    $stmt->execute();

    echo '<div class="alert alert-success" role="alert">Restaurant successfully submitted</div>';
    include 'submit_form.inc';

} else {
    // display the submission form
    include 'submit_form.inc';
}
?>
<?php include 'footer.inc'; ?>

<script src="js/submission.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>