<?php
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "YOUR_OATH_KEY_HERE",
    'oauth_access_token_secret' => "YOUR_OATH_SECRET_HERE",
    'consumer_key' => "YOUR_CONSUMER_KEY",
    'consumer_secret' => "YOUR_CONSUMER_SECRET"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ 
$url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
$requestMethod = 'POST';

/** POST fields required by the URL above. See relevant docs as above 
$postfields = array(
    'screen_name' => 'usernameToBlock', 
    'skip_status' => '1'
);

/** Perform a POST request and echo the response 
$twitter = new TwitterAPIExchange($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest(); **/

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
$getfield = '?username=YOUR_USERNAME';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$twitter -> setGetfield($getfield) -> buildOauth($url, $requestMethod) ;
$json = $twitter -> performRequest();


//echo $json;


$array = json_decode($json,TRUE);
?>



<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
      html { height: 100% }
      body { height: 100%; margin: 0; padding: 0 }
      #map-canvas { height: 100% }
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY&sensor=false">
    </script>
    <script type="text/javascript">
        function initialize() {
            var geo = new google.maps.Geocoder;
            var address = "Mumbai";
            var myLatLng
           geo.geocode({'address':address},function(results, status){
                if (status == google.maps.GeocoderStatus.OK) {              
                    myLatLng = results[0].geometry.location;
                    //alert(myLatLng);
                    // Add some code to work with myLatLng              

                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
           // var mycenter = new google.maps.LatLng();
            var newcenter = new google.maps.LatLng(19.031, 73.097);
            var mapOptions = {
                center: newcenter,
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map-canvas"),
              mapOptions);
            var marker1 = new google.maps.Marker({
                position: newcenter
            });
            //var info = "<?php print($array[0]["text"]);?>"
            var infowindow = new google.maps.InfoWindow({
              content:"Hello, I Live here."
              });

            
            
            marker1.setMap(map);
            infowindow.open(map,marker1);
            marker2.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
      <div style="width:1000px; margin: auto;">
           <h1 style="text-align: center"> Web Mashup, REST using PHP</h1>
          <div id="map-canvas" style="width:680px;height:500px; float: left; margin: auto"></div>
          <div style="width:300px;height:500px; float: right;">
              <h2>TWITTER TIMELINE</h2>
          <?php
                $i=0;
                while ($i!=5){
                   echo "<p>";
                   echo $array[$i]["text"];
                   echo "</br><b>";
                   echo $array[$i]["user"]["name"];
                   echo "</b></p>";
                   $i++;
                }
            ?>
          </div>
      </div>
  </body>
</html>
