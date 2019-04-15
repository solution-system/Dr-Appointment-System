<?php
if ($address <> "")
{ ?>
   <script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3.3&sensor=false"></script>
   <script type="text/javascript">
   var geocoder, map;
   geocoder = new google.maps.Geocoder();

  function codeAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map, 
            position: results[0].geometry.location
        });
      } 
    });
  }
    $(document).ready(function()
    {
      var myOptions = {
         zoom: 3,
         mapTypeId: google.maps.MapTypeId.ROADMAP
       }
       map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
      codeAddress('<?=$address?>');
    });
   </script>
<?php
}
else if (($map_lat <> "") and ($map_long <> ""))
{ ?>
   <script type="text/javascript" src="https://maps.google.com/maps/api/js?v=3.3&sensor=false"></script>
   <script type="text/javascript">
      $(document).ready(function()
      {
           var myLatlng = new google.maps.LatLng(<?=$map_lat?>, <?=$map_long?>);
           var myOptions = {
             zoom: <?=$zoom;?>,
             center: myLatlng,
             mapTypeId: google.maps.MapTypeId.ROADMAP
           }
           var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    });
   </script>
<?php
}
else
   print '<script type="text/javascript">

$(document).ready(function()
   {
      $("#map_canvas").attr("align", "center");
      $("#map_canvas").attr("valign", "middle");
      $("#map_canvas").height("150");

      $("#map_canvas").html("<img border=0 src=\'/images/map.gif\'>");
 });
</script>
';
?>