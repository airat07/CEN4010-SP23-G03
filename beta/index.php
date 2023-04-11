<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta charset="UTF-8" />
        <!-- https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP -->
        <meta
            http-equiv="Content-Security-Policy"
            content="default-src 'self'; script-src 'self'"
        />
        <meta
            http-equiv="X-Content-Security-Policy"
            content="default-src 'self'; script-src 'self'"
        />

        <title>Demo (Hello world edition)</title>

        <link href="vendor/bootstrap.min.css" rel="stylesheet">
        <link href="ui.css" rel="stylesheet">


    </head>

    <?php

    $db_host = getenv('DB_HOST');
    $db_username = getenv('DB_USERNAME');
    $db_password = getenv('DB_PASSWORD');
    $db_name = getenv('DB_NAME');

    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //$query = $_POST["searchbox"];
        //$sql_command = "SELECT * FROM images WHERE tags LIKE '%$query%'";
        echo '<script>console.log("call from php successful!");</script>';

    }


    ?>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-12 sticky-top">
                    <form class="d-flex mx-auto my-4 col-lg-6" id="search-form" method="post" action="index.php">
                        <input type="text" class="form-control" id="search-box" placeholder="Search" name="searchbox">
                        <button class="btn btn-primary" id="search-button" type="submit">Search using a tag</button>
                        <button class="btn btn-secondary" id="everything-button">See everything</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="tags-column">
                    <!-- Tags list will be added here dynamically -->

                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">tags</h2>
                                <ul class="list-group tag-list" id="the-tag-list">
                                    <!-- to be dynamically generated -->
                                </ul>
                            </div>
                        </div>


                    </div>
                </div>

        </div>

        <div class="container-fluid">
                
            <div class="row" id="thumbnail-grid">
                <!-- Thumbnail grid will be added here dynamically -->
                    
                

            </div>
                
            
        </div>
          

        <!--
        <div class="container">
            <div class="row">
                <div class="col-sm-2"><h1>Column one</h1></div>

                <div class="col-sm-10">
                    <h1>Column two</h1>
                    
                    <div class="row" id="image-grid">
                    </div>


                </div>
            </div>

        </div>
        -->

        <!-- jQuery -->
        <script src="vendor/jquery.min.js"></script>
    
        <!-- Bootstrap JS -->
        <script src="vendor/bootstrap.bundle.min.js"></script>
        
        <!-- thumbnail grid test code -->
        <!--<script src="thumbnail-grid.js"></script>-->

    </body>
</html>
