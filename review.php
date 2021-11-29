<?php
session_start();
// when logged-in user posts a review, it will submit the form with following post fields
if (isset($_POST["review"]) && isset($_POST["rating"]) && isset($_POST["restaurant_id"])) {
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
    // insert a new review in to DB
    $stmt = $pdo->prepare("INSERT INTO `review` (`restaurant_id`, `star`, `detail`, `reviewer`) VALUES (:restaurant_id, :star, :detail, :reviewer)");
    $stmt->bindValue(':restaurant_id', $_POST["restaurant_id"]);
    $stmt->bindValue(':star', $_POST["rating"]);
    $stmt->bindValue(':detail', $_POST["review"]);
    // obtain logged-in username from session
    $stmt->bindValue(':reviewer', $_SESSION['username']);
    $stmt->execute();

    // we also need to update the restaurant's overall rating for it to be reflected in the search results
    $stmt = $pdo->prepare("SELECT * FROM `review` WHERE `restaurant_id` = :restaurant_id ");
    $stmt->bindValue(':restaurant_id', $_POST["restaurant_id"]);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $review_count = count($reviews);

    // get the restaurant's current overall rating
    $stmt = $pdo->prepare("SELECT * FROM `restaurant` WHERE `id` = :restaurant_id");
    $stmt->bindValue(':restaurant_id', $_POST["restaurant_id"]);
    $stmt->execute();
    $restaurant = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]; // this is guaranteed to be valid

    // for now we are using simple formula to update: new rating = ((old rating * old review count) + new rating) / new review count
    $updated_rating = ($restaurant["overall_star"] * ($review_count - 1) + $_POST["rating"]) / ($review_count);

    $stmt = $pdo->prepare("UPDATE `restaurant` SET `overall_star` = :updated_rating WHERE `id` = :restaurant_id");
    $stmt->bindValue(':restaurant_id', $_POST["restaurant_id"]);
    $stmt->bindValue(':updated_rating', $updated_rating);
    $stmt->execute();

    // redirect to the detail page (serve as refresh)
    header("Location: details.php?id=" . $_POST["restaurant_id"]);
    die();
}
?>