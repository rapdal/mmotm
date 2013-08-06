<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Divine Souls News</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Gudea" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=RussoOne Regular" />
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Univers" />
    
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

</head>

<body style="overflow: auto;">

    <?php

        // Connects to your Database 
        mysql_connect("localhost", "anytv_dstm", "Any51rox") or die(mysql_error()); 
        mysql_select_db("anytv_divineSoulsUsers") or die(mysql_error());
        
        $result = mysql_query("SELECT * FROM launcherNews ORDER BY -date");

        $dataPresent = mysql_num_rows($result);

        if($dataPresent == 0) { echo "<div class='news-wrapper'><div id='story' style='margin-left:120px; margin-top:15px;'>No News</div></div>"; } else {
        
        while($row = mysql_fetch_array($result))
          { ?>

            <div class="news-wrapper">
          
                <div id="story"><?php echo $row['title']; ?></div><span id="story-dtg"><?php echo $row['date']; ?></span>

                <p id="story-content"><?php echo $row['content']; ?></p>

            </div>

          <?php } } ?>

    </div>

</body>