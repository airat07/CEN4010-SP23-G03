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
        
        <!-- thumbnail grid -->
        <script src="thumbnail-grid.js"></script>

        <!-- sql to thumbnail grid interop -->
        <script src="sql-backend.php"></script>


    </head>
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

        <!-- php -->
        <?php
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

            $query = $_POST["searchbox"];
            
            $result = mysqli_query($db, "SELECT * FROM images WHERE tags LIKE '%" . $query . "%'");
            $rows = array();
            while($row = mysqli_fetch_assoc($result)) { $rows[] = $row; }
            if (!$rows) { echo "<script>console.log('rows php variable was empty!');</script>"; }

            $b64 = base64_encode(json_encode($rows));
            echo "<script>process_sql('$b64');</script>";
        }


        ?>



        

    </body>
</html>
