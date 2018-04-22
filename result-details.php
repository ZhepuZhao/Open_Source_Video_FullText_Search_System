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
        
        // check the $_GET variable
        $videoid = $_POST['videoid'];
        
        // prepare the statement
        $details_query = "select * from p2records WHERE videoid = (:videoid)";
        $stmt = $dbh->prepare($details_query);
        // $details_field = $videoid;
        $params = array('videoid'=>$videoid);
        $stmt->execute($params);
        
        while ($results = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $title = $results['title'];
            $genre = $results['genre'];
            $keywords = $results['keywords'];
            $duration = $results['duration'];
            $color = $results['color'];
            $sound = $results['sound'];
            $sponsor = $results['sponsorname'];
            
            echo "<div id = \"detail\" class=\"card bg-light mb-3 sticky-top\" style=\"max-width: 25rem;\">";
            echo "<div class=\"card-header\" style='font-size: 12px'><b>$title</b></div>";
            echo "<div class=\"card-body\">";
            echo "<li><b style='font-size: 12px'>Genre: " . "</b>" . "<i style='font-size: 12px'>" . $genre . "</i></li>";
            echo "<li><b style='font-size: 12px'>Keywords: " . "</b>" . "<i style='font-size: 12px'>" . $keywords . "</i></li>";
            echo "<li><b style='font-size: 12px'>Duration: " . "</b>" . "<i style='font-size: 12px'>" . $duration . "</i></li>";
            echo "<li><b style='font-size: 12px'>Color: " . "</b>" . "<i style='font-size: 12px'>" . $color . "</i></li>";
            echo "<li><b style='font-size: 12px'>Sound: " . "</b>" . "<i style='font-size: 12px'>" . $sound . "</i></li>";
            echo "<li><b style='font-size: 12px'>Sponsor: " . "</b>" . "<i style='font-size: 12px'>" . $sponsor ."</i></li>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>