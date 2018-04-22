<?php
    session_start();
    // check if user logged out or haven't logged in before
    if (!isset($_SESSION['valid_user'])) {
        echo '<script type="text/javascript">location.href = "login.php";</script>';
    }
?>

<?php
    try {
        // connect database
        $h = "pearl.ils.unc.edu";
        $u = "webdb_zhepu";
        $d = "webdb_zhepu";
        $p = "ZZP2017@unc";
        $dbh = new PDO("mysql:host=$h;dbname=$d",$u,$p);
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $dbh->setAttribute( PDO::ATTR_EMULATE_PREPARES, false);
        
        // check the $_GET['search'] variable
        if (isset($_GET['search'])){
            $search = $_GET['search'];
        } else {
            $search = null;
        }
        
        // prepare the search query statement
        $search_query = "select * from p2records WHERE MATCH (title, description, keywords) against (:search_field)";
        if ($search != null) {
            $stmt = $dbh->prepare($search_query);
            $search_field = $search;
            $params = array('search_field'=>$search_field);
            $stmt->execute($params);
        } else {
            // if nothing sends to the server, show all the data
            $search_default_query = "select * from p2records";
            $stmt = $dbh->query($search_default_query);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Open Video</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="signin.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Google JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        .jumbotron{
            background-image: url("search.jpg");
            background-repeat: no-repeat;
            background-size: 1200px 400px;
        }
    </style>
    <script>
        $(document).ready(function(){
            // search box
            $("#i1").keyup(function () {
                $("#a1").attr("href", "?search="+$(this).val());
            });

            // search suggestions
            $("#i1").keyup(function () {
                $.ajax({
                    method: "POST",
                    url: "keyword-suggestions.php",
                    data: {
                        suggest:$(this).val()
                    },
                    dataType: "html",
                    success: function(data){
                        $("#suggest").html(data);
                    }
                });
            });

            // item information presentation
            $(".row a").mouseenter(function () {
                $.post("result-details.php",
                    {
                        videoid: $(this).attr("href").substring(46)
                    },
                    function(data,status){
                        $("#detail").html(data);
                    }
                );
                $("#detail").show();
            });
            
            $(".row").mouseout(function () {
                $("#detail").hide();
            });
        });
    </script>
</head>
<body>

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-4 text-center"></div>
            <div class="col-4 text-center">
                <a class="blog-header-logo text-dark">Welcome,
                    <?php
                        echo "<b>" . $_SESSION['valid_user'] . "</b>";
                    ?></a>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="login.php?login=false">Logout</a>
            </div>
        </div>
    </header>
    <div class="jumbotron">
        <div class="container">
            <h1 class="display-4">Open Video Source</h1>
            <p class="lead">Search the video you like</p>
        </div>
    </div>
    <div class="row">
        <!-- left part: search box-->
        <div class="col-3">
            <form>
                <div class="form-group">
                    <label for="exampleInputEmail1">Search here</label>
                    <input id="i1" class="form-control" type="text">
                    <small class="form-text text-muted">Search the video you want.</small>
                </div>
                <a id="a1" href=""><button type="button" class="btn btn-primary">Search</button></a>
            </form>
            <hr>
            <div class="card bg-light mb-3" style="max-width: 18rem;">
                <div class="card-header">Suggestions</div>
                <div class="card-body">
                    <p id="suggest" class="card-text">Some topics you might like to search.</p>
                </div>
            </div>
        </div>
        <!-- middle part: search results-->
        <div class="col-6">
            <?php
                
                if ($stmt->rowCount() == 0) {
                    // if no search results
                    echo "<div><h5>Sorry, we didn't find the match one.</h5></div>";
                }
                if ($search != null){
                    echo "<div><h5>Showing results for: " . $search . "</h5></div>";
                }
                while ($results = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    $video_id = $results['videoid'];
                    $title = $results['title'];
                    $description = $results['description'];
                    $create_year = $results['creationyear'];
                    $image_url = "http://www.open-video.org/surrogates/keyframes/" . $video_id . "/" . $results['keyframeurl'];
                    
                    // output the search results
                    $video_url = "http://www.open-video.org/details.php?videoid=" . $video_id;
                    echo "<div class='row'>";
                    echo "<div class=\"col-3\">" . "<a href=$video_url target='_blank'><img src=\"$image_url\" class='img-thumbnail'></img>"  . "</a></div>";
                    echo "<div class=\"col-9\">";
                    if ($create_year == 0){
                        echo "<a href=$video_url target='_blank'><h7>" . $title . "</h7>" . " (" . "Creation year not known". ")" . "</a>";
                    } else {
                        echo "<a href=$video_url target='_blank'><h7>" . $title . "</h7>" . " (" . $create_year. ")" . "</a>";
                    }
                    echo "<p>" . $description . "</p>";
                    echo "</div>";
                    echo "</div><hr>";
                }
            ?>
        </div>
        <!-- right part: video details-->
        <div id = "detail" class="col-3"></div>
    </div>
</div>
</body>
</html>