<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>ACE</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php
    $servername = "webdb.uvm.edu";
    $username = "omarshal_reader";
    $password = "vrd3s8tUJcNg";
    $dbname = "OMARSHAL_hackvt";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully<br>";

    function filter_libraries($conn) {
      $sql = "SELECT * FROM `Libraries` WHERE 1";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_makerspaces($conn) {
      $sql = "SELECT * FROM `Makerspaces` WHERE 1";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_user($conn) {
      $sql = "SELECT * FROM `User` WHERE 1";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_infant($conn) {
      $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Infant Capacity` > 0";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_toddler($conn) {
      $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Toddler Capacity` > 0";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_preschool($conn) {
      $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Preschool Capacity` > 0";
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_school_age($conn) {
      $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired School Age Capacity` > 0";
      $result = $conn -> query($sql);
      return $result;
    }
    function plot_childcare_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
        $count = 0;
          while($row = $result->fetch_assoc()) {
            if($count>84){
              echo "marker_function(" . get_lat($row["Location 1"]) .
               ', ' . get_lng($row["Location 1"]) .
                ", '" . str_replace("'","",str_replace('"',"",$row["Provider Name"])) .
                 "', '" . str_replace("'","",str_replace('"',"",$row["Address 1"])) .
                  "', '" . str_replace('"',"",$row["Phone Number"]) .
                   "', '" . "<a href = \"mailto:" .
                    str_replace('"',"",$row["Email Address"]) .
                     "\">" . str_replace('"',"",$row["Email Address"]) .
                      "</a>');" . "\n";
            } else { $count++; }
          }
        }
    }
    function plot_library_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
        $count = 0;
          while($row = $result->fetch_assoc()) {
            if($count!=0){
              echo 'marker_function(' . get_lat($row["Location"]) . ", " . get_lng($row["Location"]) . ', "' . $row["Library"] . '", "' . str_replace('"',"",$row["Street Address"]) . '", "' . str_replace('"',"",$row["Phone Number"]) . '");' . "\n";
              } else { $count=420; }
          }
        }
    }
    function plot_makerspace_or_user_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
        $count = 0;
          while($row = $result->fetch_assoc()) {
            if($count!=0){
              echo "geocode_function('" . $row["Address"] . "', '" . $row["Name"] . "', '<a href=\"" . $row["Website"] . "\" target = \"_blank\">" . $row["Website"] . "</a>')" . "\n";
              } else { $count=420; }
          }
        }
    }
    function get_lat($input) {
      $value = explode("(",$input);
      $value = explode(")",$value[1]);
      $value = explode(", ",$value[0]);
      $lat = $value[0];
      $lng = $value[1];
      
      return $lat;
    }
    function get_lng($input) {
      $value = explode("(",$input);
      $value = explode(")",$value[1]);
      $value = explode(", ",$value[0]);
      $lat = $value[0];
      $lng = $value[1];
      return $lng;
    }
    ?>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ACE</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            
            <li><a href="#about">About Us</a></li>
            <!--
            <li><a href="#contact">Contact</a></li>
            -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>ACE: Advancing Childhood Education</h1>
        <p class="lead">Find nearby libraries and child care centers in Vermont</p>
      </div>

      <div class = "checkbox-whole">
        <form action = "index.php" method = "post">
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "library" <?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "library") echo "checked='checked'"; ?>>Libraries</label>
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "space" <?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "space") echo "checked='checked'"; ?>>Hackerspace</label>
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "infant" <?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "infant") echo "checked='checked'"; ?>>Infant Care</label>
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "toddler" <?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "toddler") echo "checked='checked'"; ?>>Toddler Care</label>
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "prek" <?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "prek") echo "checked='checked'"; ?>>Pre-K</label>
          <label class = "checkbox"><input type = "radio" name="pinsView" value = "school"<?php if(isset($_POST['pinsView']) && $_POST['pinsView'] == "school") echo "checked='checked'"; ?>>School Age</label>
          <label class = "submit"><input type = "submit" value = "Submit">
        </form>
      </div>

      <div id="map"></div>
<br/><br/><br/><br/><br/><br/><br/>
      <div class = "starter-template">
        <a name = "about"></a>
      </div>
    

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    <script>
    var map;
    var marker;

      function initMap() {
        geocoder = new google.maps.Geocoder();
        var address = 'killington vt'

        var uluru = {lat: -25.363, lng: 131.044};
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          //center: uluru
        });

        //address recognition
        geocoder.geocode({'address': address}, function(results, status){
          if(status == google.maps.GeocoderStatus.OK){
            map.setCenter(results[0].geometry.location);
            /*var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });*/
          } else {
              alert('Error finding address: ' + status);
          }
        });

        /*
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
*/
        //current location

        if(!!navigator.geolocation){
          navigator.geolocation.getCurrentPosition(function(position){
            var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var infowindow = new google.maps.InfoWindow({
              map: map,
              position: geolocate,
              content:
              '<p class = "location-window">Current Location</p>'
            });
            map.setZoom(12);
            map.setCenter(geolocate);
          });
        }

  <?
      if($_POST['pinsView'] == "library") {
        plot_library_rows(filter_libraries($conn));

      } else if($_POST['pinsView'] == "space") {
          plot_makerspace_or_user_rows(filter_makerspaces($conn));

      } else if($_POST['pinsView'] == "infant") {
          plot_childcare_rows(filter_infant($conn));

      } else if($_POST['pinsView'] == "toddler") {
          plot_childcare_rows(filter_toddler($conn));

      } else if($_POST['pinsView'] == "prek") {
        plot_childcare_rows(filter_preschool($conn));

      } else if($_POST['pinsView'] == "school") {
        plot_childcare_rows(filter_school_age($conn));
      }
    ?>
      }
      function geocode_function(address, name, website) {
        var contentString = name.concat("<br>".concat(address.concat("<br>".concat(website))));
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function(results, status) {
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
          if(status == google.maps.GeocoderStatus.OK){
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location,
              title: name
            });
            marker.addListener('click', function() {
              infowindow.open(map, marker);
            })        
          } else {
              alert('Geocode broke boi: ' + status);
          }
      });
      }
      function marker_function(latt, looong, name, address, phone, email='') {
        var coordinate = {lat: latt, lng: looong};
        var contentString = name.concat("<br>".concat(address.concat("<br>".concat(phone.concat("<br>".concat(email))))));
        var infowindow = new google.maps.InfoWindow({
          content: contentString
        });
            var marker = new google.maps.Marker({
              map: map,
              position: coordinate,
              title: name
            });
            marker.addListener('click', function() {
              infowindow.open(map, marker);
            })        
      }

 
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYdzeJmc1XXUcu7nbFPh_E_7OakOy0sQQ&callback=initMap">
    </script>
  </body>
</html>