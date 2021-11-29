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
    <title>Where Go Eat</title>
</head>
<body>
<?php include 'header.inc'; ?>

<div class="p-5 mb-4 rounded-3">

    <?php
    // process search when form is submitted
    // case 1: when searchFieldStar is set: search by query
    // case 2: when searchFieldUserLocationLat is set: search by user's geolocation
    if (isset($_POST["searchFieldStar"]) || isset($_POST["searchFieldUserLocationLat"])) {
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

        // if user does not specify a search term by name, only search by rating
        if ($_POST["searchFieldName"] === "" && $_POST["searchFieldUserLocationLat"] === "") {
            $stmt = $pdo->prepare("SELECT * FROM `restaurant` WHERE `overall_star` >= :star");
            $stmt->bindValue(':star', $_POST["searchFieldStar"]);
        } else if ($_POST["searchFieldName"] !== "") {
            $stmt = $pdo->prepare("SELECT * FROM `restaurant` WHERE `name` LIKE :name");
            $stmt->bindValue(':name', $_POST["searchFieldName"]);
        } else {
            // search by user's geolocation, we only display restaurants whose latitude and longitude within a certain shreshold from user's location
            $stmt = $pdo->prepare("SELECT * FROM `restaurant` WHERE `latitude` BETWEEN :latitude - 1 AND :latitude + 1 AND `longitude` BETWEEN :longitude - 1 AND :longitude + 1");
            $stmt->bindValue(':latitude', $_POST["searchFieldUserLocationLat"]);
            $stmt->bindValue(':longitude', $_POST["searchFieldUserLocationLong"]);
        }

        $stmt->execute();
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // display the search results fetched from db
        if (count($restaurants) > 0) {
            ?>
            <div class="p-5 mb-4 rounded-3">
                <div class="container">
                    <div class="row">
                        <?php
                        foreach ($restaurants as $restaurant) {
                            $restaurant_rating = number_format((float)$restaurant["overall_star"], 2, '.', '');
                            $content = <<<HTML
                                <div class="col-xs-12 col-sm-6 col-md-4 my-2">
                                <div class="card h-100">
                                    <div class="view overlay">
                                        <!-- Image of the restaurant-->
                                        <a href="details.php?id={$restaurant["id"]}"><img class="card-img-top"
                                             src="{$restaurant["image"]}"
                                             alt="Card image cap"></a>
                                        <a href="#!">
                                            <div class="mask rgba-white-slight"></div>
                                        </a>
                                    </div>
                                    <!-- Description of the restaurant-->
                                    <div class="card-body">
                                        <span class="badge bg-danger">{$restaurant_rating}</span>
                                        <h4 class="card-title">{$restaurant["name"]}</h4>
                                        <p class="card-text">{$restaurant["description"]}</p>
                                    </div>
                                </div>
                            </div>
                            HTML;
                            echo $content;
                        } ?>
                    </div>
                </div>
                <!--    div for google map embedded-->
                <div id="map" class="map"></div>
            </div>;
            <script>
                // using google map API to embed markers for each restaurant in the map
                function addMarker(map, position, contentString, link) {
                    const infowindow = new google.maps.InfoWindow({
                        content: `<p>${contentString}</p> <a href="${link}">See Details</a>`
                    });
                    const marker = new google.maps.Marker({
                        position: position,
                        map,
                    });

                    marker.addListener("click", () => {
                        infowindow.open({
                            anchor: marker,
                            map,
                            shouldFocus: false,
                        });
                    });
                }

                function initMap() {
                    const restaurants = JSON.parse('<?php echo json_encode($restaurants);  ?>');
                    const map = new google.maps.Map(document.getElementById("map"), {
                        zoom: 10,
                        // Toronto as the center
                        center: {lat: 43.651070, lng: -79.347015},
                    })
                    restaurants.forEach(restaurant => {
                        addMarker(map, {
                            lat: parseFloat(restaurant.latitude),
                            lng: parseFloat(restaurant.longitude)
                        }, restaurant.name, "details.php?id=" + restaurant.id);
                    })
                }
            </script>
            <script async
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5AeFd4NIdLRRmz4uSraziqEq_Sr1XUXg&callback=initMap">
            </script>
            <?php
        } else {
            // alert when no results can be found
            if ($_POST["searchFieldUserLocationLat"] !== "") {
                echo '<div class="alert alert-danger" role="alert"> No nearby restaurants could be found around: ' . $_POST["searchFieldUserLocationLat"] . ';' . $_POST["searchFieldUserLocationLong"] . ' ' . '. Please try searching by rating or name.</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert"> Records not found. Please try with other search terms.</div>';
            }

            include 'search_form.inc';
        }
    } else {
        include 'search_form.inc';
    }
    ?>
</div>

<?php include 'footer.inc'; ?>

<!--TODO-->
<script src="js/search.js"></script>
</body>
</html>