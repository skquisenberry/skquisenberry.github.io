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

    <title>Dump Your Child</title>

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
    $username = "omarshal_admin";
    $password = "r2SK86J9SP6t";
    $dbname = "OMARSHAL_hackvt";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully<br>";

    function filter_libraries($conn, $hs_internet) {
      if($hs_internet) {
        $sql = "SELECT * FROM `Libraries` WHERE `Internet Type` = 'high speed'";
      } else {
        $sql = "SELECT * FROM `Libraries` WHERE 1";
      }
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
    function filter_infant($conn, $include_full) {
      if($include_full) {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Infant Capacity` > 0";
      } else {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Infant Vacancies` > 0";
      }
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_toddler($conn, $include_full) {
      if($include_full) {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Toddler Capacity` > 0";
      } else {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Toddler Vacancies` > 0";
      }
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_preschool($conn, $include_full) {
      if($include_full) {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired Preschool Capacity` > 0";
      } else {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Preschool Vacancies` > 0";
      }
      $result = $conn -> query($sql);
      return $result;
    }
    function filter_school_age($conn, $include_full) {
      if($include_full) {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported Desired School Age Capacity` > 0";
      } else {
        $sql = "SELECT * FROM `Childcare` WHERE `Reported School Age Vacancies` > 0";
      }
      $result = $conn -> query($sql);
      return $result;
    }
    function plot_childcare_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              echo 'geocode_function("' . $row["Address 1"] . '");' . "\n";
          }
        }
    }
    function plot_library_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              echo 'geocode_function("' . $row["Street Address"] . '");' . "\n";
          }
        }
    }
    function plot_makerspace_or_user_rows($result) {
      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              echo 'geocode_function("' . $row["Address"] . '")' . "\n";
          }
        }
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
          <a class="navbar-brand" href="#">Child Dump</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <!--
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
            -->
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>Dump yer child</h1>
        <p class="lead">Find nearby libraries and child care centers in Vermont</p>
      </div>

      <div class = "checkbox-whole">
        <form action = "index1.php" method = "post">
          <label class = "checkbox"><input type = "checkbox" name="library">Libraries</label>
          <label class = "checkbox"><input type = "checkbox" name="space">Hackerspace</label>
          <label class = "checkbox"><input type = "checkbox" name="infant">Infant Care</label>
          <label class = "checkbox"><input type = "checkbox" name="toddler">Toddler Care</label>
          <label class = "checkbox"><input type = "checkbox" name="prek">Pre-K</label>
          <label class = "checkbox"><input type = "checkbox" name="school">School Age</label>
          <label class = "checkbox"><input type = "checkbox" name="internet">High Speed Internet</label>
          <label class = "checkbox"><input type = "checkbox" name="vacant">Vanacies</label>
          <label class = "submit"><input type = "submit" value = "Submit">
        </form>
      </div>

      <div id="map"></div>
    

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
              alert('Geocode broke boi: ' + status);
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
      if(isset($_POST['library'])) {
        if(isset($_POST['internet'])) {
          plot_library_rows(filter_libraries($conn, True));
        } else { plot_library_rows(filter_libraries($conn, False)); }

      } else if(isset($_POST['space'])) {
          plot_makerspace_or_user_rows(filter_makerspaces($conn));

      } else if(isset($_POST['infant'])) {
        if(isset($_POST['vacant'])) {
          plot_childcare_rows(filter_infant($conn, False));
        } else { plot_childcare_rows(filter_infant($conn, True)); }

      } else if(isset($_POST['toddler'])) {
        if(isset($_POST['vacant'])) {
          plot_childcare_rows(filter_toddler($conn, False));
        } else { plot_childcare_rows(filter_toddler($conn, True)); }

      } else if(isset($_POST['prek'])) {
        if(isset($_POST['vacant'])) {
          plot_childcare_rows(filter_preschool($conn, False));
        } else { plot_childcare_rows(filter_preschool($conn, True)); }

      } else if(isset($_POST['school'])) {
        if(isset($_POST['vacant'])) {
          plot_childcare_rows(filter_school_age($conn, False));
        } else { plot_childcare_rows(filter_school_age($conn, True)); }
      }
    ?>
      }
      
      function geocode_function(address) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': address}, function(results, status) {
          if(status == google.maps.GeocoderStatus.OK){
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location
            });
            
          } else {
              alert('Geocode broke boi: ' + status);
          }
      });
      }

 
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYdzeJmc1XXUcu7nbFPh_E_7OakOy0sQQ&callback=initMap">
    </script>
  </body>
</html>
