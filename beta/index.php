<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Demo (Hello world edition)</title>

        <link href="vendor/bootstrap.min.css" rel="stylesheet">
        <link href="ui.css" rel="stylesheet">

        <!-- jQuery -->
        <script src="vendor/jquery.min.js"></script>
    
        <!-- Bootstrap JS -->        
        <script src="vendor/bootstrap.bundle.min.js"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script> -->
        
        <!-- thumbnail grid -->
        <script src="thumbnail-grid.js"></script>

        <!-- input validator -->
        <script src="input-validator.js"></script>

        <!-- sql to thumbnail grid interop -->
        <script src="sql-backend.php"></script>


    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-12 sticky-top">
                    <form class="d-flex mx-auto my-4 col-lg-6" id="search-form" method="post" action="index.php">
                        <input type="text" class="form-control" id="search-box" placeholder="Find images with a given tag" name="searchbox">
                        <button class="btn btn-primary" id="search-button" type="submit">Search</button>
                        <!-- <button class="btn btn-secondary" id="everything-button">See everything</button> -->
                    </form>
                    <form class="d-flex mx-auto my-4 col-lg-6" id="control-form">
                        <?php
                        // check if user is logged in
                        session_start();
                        if (isset($_SESSION["user_id"]))
                        {
                            // the following buttons should only appear when user is signed in
                            echo '<a href="logout.php" class="btn btn-light">Logout</a>';
                            echo '<button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#save-new-image-modal">Save New Image</button>';
                        }
                        else
                        {
                            // the following buttons should only appear when user is logged out
                            echo '<a href="create-account.php" class="btn btn-light">Create Account</a>';
                            echo '<a href="login.php" class="btn btn-light">Log in</a>';
                        }
                        ?>
                    </form>
                    
                </div>
            </div>
        </div>

        <!-- Save New Image Modal -->
        <div class="modal fade" id="save-new-image-modal" tabindex="-1" aria-labelledby="save-new-image-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="save-new-image-modal-label">Save a new image</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                        <form id="save-new-image-modal-form" method="post" action="index.php">
                            <div class="mb-3">
                                <label for="image-url" class="col-form-label">Image URL:</label>
                                <input type="text" class="form-control" id="image-url-modal-input-field" name="imageurl_input" required>
                            </div>
                            <div class="mb-3">
                                <label for="image-tags" class="col-form-label">Specify tags for this image (use , to delimit):</label>
                                <textarea class="form-control" id="image-tags" name="imagetags_input" required></textarea>
                            </div>
                            <div id="modal-info-area"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Image Modal -->
        <div class="modal fade" id="manage-image-modal" tabindex="-1" aria-labelledby="manage-image-modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5" id="manage-image-modal-label">Delete this image?</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="manage-image-modal-form" method="post" action="index.php">
                            <div class="mb-3">
                                <label for="image-url" class="col-form-label">Image URL:</label>
                                <input type="text" class="form-control" id="manage-image-modal-url-input-field" name="manage_imageurl_input" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-danger">Delete</button> <!-- todo -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tags column -->
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="tags-column">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Tags</h2>
                                <ul class="list-group tag-list" id="the-tag-list">
                                    <!-- generated from thumbnail-grid.js -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Thumbnail grid -->
        <div class="container-fluid">
            <div class="row" id="thumbnail-grid">
                <!-- generated from thumbnail-grid.js -->
            </div>
        </div>

        <script>validate_image_url();</script>

        <!-- php -->
        <?php
        //echo "";
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            //echo "<script>console.log(\"JS Console Log from PHP: Query string contains: '$query'\");</script>"; // <-- works, note the escape slashes
            //echo "<script>console.log('$query');</script>"; // <-- works
            // trying $sql_command here in lieu of $query leads to issues b/w single and double quotes but it should work in theory
            
            $db_host = "localhost";
            $db_username = "cen4010sp23g03";
            $db_password = "ASpring#2023";
            $db_name = "cen4010sp23g03";
            $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
            if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }

            if ($_POST["imageurl_input"] && $_POST["imagetags_input"])
            {
                // TODO: validate input for image_url

                $image_url = $_POST["imageurl_input"];
                $image_tags = $_POST["imagetags_input"];

                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!"; // shouldn't really happen as the plan is make save image function work only when session token is set
                    exit;   
                }
                $userid = $_SESSION["user_id"]; // matches user_id found in SQL DB

                // get sha256 hash of image found at url and filename based on url
                $image_sha256 = hash('sha256', file_get_contents($image_url)); // seems to return the same value each time

                $sql_cmd = "INSERT INTO images (user_id, image_hash, url, tags) VALUES ('$userid', '$image_sha256', '$image_url', '$image_tags')";
                $result = mysqli_query($db, $sql_cmd);
                if (!$result)
                {
                    echo 'Error when inserting: ' . mysqli_error($db);
                }


            }
            else if($_POST["manage_imageurl_input"])
            {
                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!";
                    exit;
                }

                $userid = $_SESSION["user_id"];
                $image_url = $_POST["manage_imageurl_input"];

                $result = mysqli_query($db, "DELETE FROM images WHERE url = '$image_url'");

                // TODO: show friendly message informing of successful deletion
            }
            else if ($_POST["searchbox"])
            {
                session_start();
                if(!isset($_SESSION["user_id"]))
                {
                    echo "User is not logged in!"; // shouldn't happen...
                    exit;
                }

                $userid = $_SESSION["user_id"];
                $query = $_POST["searchbox"];
            
                $result = mysqli_query($db, "SELECT * FROM images WHERE user_id = '$userid' AND tags LIKE '%" . $query . "%'");
                $rows = array();
                while($row = mysqli_fetch_assoc($result)) { $rows[] = $row; }
                if (!$rows) { echo "<script>console.log('rows php variable was empty!');</script>"; }
    
                $b64 = base64_encode(json_encode($rows));
                echo "<script>process_sql('$b64');</script>";
            }   
        }
        ?>
    </body>
</html>
