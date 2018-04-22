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
    
        $suggest = $_POST['suggest'];
        if ($suggest != ""){
            // prepare the statement
            $suggest_query = "select * from KeywordSuggest WHERE SuggestPhrase LIKE (:suggest_field) LIMIT 10";
    
            $stmt = $dbh->prepare($suggest_query);
            $suggest_field = $suggest . "%";
            $params = array('suggest_field'=>$suggest_field);
            $stmt->execute($params);
    
            while ($results = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $suggest_phrase = $results['SuggestPhrase'];
                echo $suggest_phrase . "<br>";
            }
        } else {
            echo "No suggest topic yet!";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    ?>