<div class="p-5 mb-4 rounded-3">
    <div class="container">
        <h1 class="display-5 fw-bold">Submit A New Restaurant</h1>
        <p class="col-md-8 fs-4">Found a new restaurant that is not in our database? Feel free to add your favorite one
            into the system!</p>
        <!--        Using a bootstrap form to facilitate new restaurant submission-->
        <form method="post" action="submit.php" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="submissionFieldName" class="form-label">Restaurant Name</label>
                <input type="text" class="form-control" id="submissionFieldName" aria-describedby="searchFieldNameHelp"
                       required name="name">
                <div class="form-text">
                    Name of the restaurant
                </div>
            </div>
            <!--            Description of restaurant-->
            <div class="mb-3 form-floating">
                <textarea class="form-control" placeholder="Description of the restaurant"
                          id="floatingTextarea" required name="description"></textarea>
                <label>Enter the description of the restaurant here</label>
            </div>
            <!--            Use type of number to constraint the location of restaurant to be correct -->
            <div class="mb-3">
                <label for="submissionFieldLat" class="form-label">Latitude</label>
                <input type=number step=any class="form-control" id="submissionFieldLat"
                       aria-describedby="searchFieldNameHelp" required name="lat">
                <div class="form-text">
                    The latitude of the restaurant's location
                </div>
            </div>
            <div class="mb-3">
                <label for="submissionFieldLon" class="form-label">Longitude</label>
                <input type=number step=any class="form-control" id="submissionFieldLon"
                       aria-describedby="searchFieldNameHelp" required name="lon">
            </div>
            <div class="mb-3">
                <button type="button" onclick="getLocation()" id="autofillLocationButton"
                        class="btn btn-outline-info">Autofill Using Current Location
                </button>
            </div>
            <!--            File upload for an image of the given restaurant-->
            <div class="mb-3">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" id="formFile" required name="image">
                <div class="form-text">
                    Upload an image of the restaurant
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </form>
    </div>
</div>