<HTMl>
<head>

    <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

    <!-- Custom Css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

include_once 'header.php';
include_once 'verify.php';

?>
<h4 style="padding-left: 20px">You made following changes uptill now</h4>
<table id="history-table" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>PlaceID</th>
        <th>Attribute</th>
        <th>Value</th>
        <th>DateTime</th>
    </tr>
    </thead>
    <tbody id="history-content"></tbody>
</table>
</body>

<!-- Latest compiled and minified JQuery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Datatables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA7xY6JgrR-hAOLs1ZmZU9vCoFNb_YQ7qI"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.get("api/History/History.php", {key: "GET"}, function(response) {
            var history = JSON.parse(response);
            var content = "";
            for(var i in history) {
                content += "<tr>";
                content += "<td>"+history[i].place_id+"</td>";
                content += "<td>"+history[i].attribute_name+"</td>";
                content += "<td>"+history[i].attribute_value+"</td>";
                content += "<td>"+history[i].dtm+"</td>";
                content += "</tr>";
            }
            $("#history-content").html(content);
            $('#history-table').DataTable();
        });
    });

</script>
</HTMl>
