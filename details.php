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
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>Restaurant Details</title>
</head>
<body>

<?php include 'header.inc'; ?>

<?php
session_start();
if (isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];
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
    } catch (Exception $ex) {
        exit($ex->getMessage());
    }
    // fetch the corresponding restaurant from DB via id
    $stmt = $pdo->prepare("SELECT * FROM `restaurant` WHERE `id` = :id");
    $stmt->bindValue(':id', $restaurant_id);
    $stmt->execute();
    $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // then fetch the list of reviews associated with the given restaurant
    $stmt = $pdo->prepare("SELECT * FROM `review` WHERE `restaurant_id` = :id");
    $stmt->bindValue(':id', $restaurant_id);
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // check to see if such restaurant exists - otherwise throw 404 error message
    if (count($restaurants) > 0) {
        $restaurant = $restaurants[0];
        ?>
        <div class="p-5 mb-4 rounded-3">
            <div class="container">
                <section class="py-5">
                    <div class="container px-4 px-lg-5 my-5">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <picture class="sample-image">
                                    <img class="img-fluid img-thumbnail" src="<?php echo $restaurant["image"] ?>"
                                         alt="sample restaurant image">
                                </picture>
                            </div>
                            <div class="col-md-8">
                                <h1 class="display-5 fw-bolder"><?php echo $restaurant["name"] ?></h1>
                                <!--                        Display the aggregate rating for the restaurant here-->
                                <div class="fs-5 mb-5">
                                    <span>Overall Rating: <?php echo number_format((float)$restaurant["overall_star"], 2, '.', ''); ?></span>
                                </div>
                                <!--                        Mission statement / description of the restaurant-->
                                <p class="lead"><?php echo $restaurant["description"] ?></p>
                                <!--                        A form for users to submit the review using bootstrap forms-->
                                <form method="post" action="review.php">
                                    <!--   we need a hidden input here to pass restaurant_id to the php review submission handler script-->
                                    <input type="hidden" name="restaurant_id" value="<?php echo $restaurant_id ?>">
                                    <textarea class="form-control" placeholder="Write your review here"
                                              id="floatingTextarea" name="review" required></textarea>

                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <!--                                For now the rating is from 1-5 using a select input-->
                                        <select class="form-select form-select-lg mb-3"
                                                aria-label=".form-select-lg example" name="rating" required>
                                            <option value="5" selected>5 stars</option>
                                            <option value="4">4 stars</option>
                                            <option value="3">3 stars</option>
                                            <option value="2">2 stars</option>
                                            <option value="1">1 star</option>
                                        </select>
                                    </div>
                                    <?php
                                    // we want to only allow logged-in users to submit reviews
                                    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE) { ?>
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                    <?php } else { ?>
                                        <button type="submit" class="btn btn-primary" disabled>Sign In To Submit
                                            Review
                                        </button>
                                    <?php } ?>

                                </form>
                            </div>
                        </div>
                        <!--    div for google map embedded-->
                        <div id="individualMap" class="map"></div>
                    </div>
                </section>

                <!--        A list of comments/ reviews for the current restaurant-->
                <?php foreach ($reviews as $review) { ?>
                    <div class="review px-5" itemprop="review" itemscope itemtype="https://schema.org/Review">
                        <div class="row d-flex">
                            <div class="d-flex flex-column pl-3">
                                <h4 itemprop="author"><?php echo $review["reviewer"] ?></h4>
                                <p class="grey-text"><span itemprop="reviewRating"><?php echo $review["star"] ?></span>
                                    stars</p>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <p itemprop="reviewBody"><?php echo $review["detail"] ?></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <?php
    } else {
        echo '<h3> 404: Item Not Found </h3>';
    }
}
?>

<?php include 'footer.inc'; ?>

<script>
    function initMap() {
        // using google map API to embed markers for the current restaurant in the map
        const map = new google.maps.Map(document.getElementById("individualMap"), {
            zoom: 10,
            // Toronto as the center
            center: {lat: 43.651070, lng: -79.347015},
        })
        new google.maps.Marker({
            position: {lat: <?php echo $restaurant["latitude"] ?>, lng: <?php echo $restaurant["longitude"] ?>},
            map,
        });
    }
</script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5AeFd4NIdLRRmz4uSraziqEq_Sr1XUXg&callback=initMap">
</script>

</body>
</html>
