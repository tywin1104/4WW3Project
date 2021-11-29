<div class="container">
    <h1 class="display-5 fw-bold">Find Nearby Restaurants</h1>
    <p class="col-md-8 fs-4">Using the form below to search for nearby restaurants. You can choose to either use a
        keyword or select a desired rating from the dropdown menu</p>
    <form method="post" action="search.php" id="searchForm">
        <div class="mb-3">
            <!-- hidden fields used for searching based on user's geolocation -->
            <input type="hidden" name="searchFieldUserLocationLat" id="searchFieldUserLocationLat">
            <input type="hidden" name="searchFieldUserLocationLong" id="searchFieldUserLocationLong">
            <!--                Search  restaurant by name-->
            <label for="searchFieldName" class="form-label">By Name</label>
            <input type="text" name="searchFieldName" class="form-control" id="searchFieldName"
                   aria-describedby="searchFieldNameHelp">
            <div id="searchFieldNameHelp" class="form-text">Please enter the name of the restaurant you want to
                search for
            </div>
        </div>
        <div class="mb-3">
            <div>
                <label class="form-label">By Rating</label>
            </div>
            <!--                Search restaurant by rating-->
            <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                    name="searchFieldStar">
                <option value="1" selected>>= 1 stars</option>
                <option value="2">>= 2 stars</option>
                <option value="3">>= 3 stars</option>
                <option value="4">>= 4 stars</option>
                <option value="5">>= 5 stars</option>
            </select>
            <div class="form-text">You can also select to only show results with desired rating
            </div>
        </div>
        <!--            Submit the query-->
        <button type="button" onclick="getLocation()" id="searchByLocationButton" class="btn btn-primary btn-lg">
            Search By Current Location
        </button>
        <button type="submit" class="btn btn-primary btn-lg">Search By Query</button>
    </form>
</div>