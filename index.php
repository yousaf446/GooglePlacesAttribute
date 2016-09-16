<HTMl>
<head>

    <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Custom Css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include_once 'header.php'; ?>
<div class="panel panel-default panel-style">
    <div class="panel-heading" role="tab" id="headingOne">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#searchPanel" aria-expanded="false" aria-controls="searchPanel">
                Search
            </a>
        </h4>
    </div>
    <div id="searchPanel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
            <div class="col-md-12">
            <div class="col-md-6">
                    <div class="col-md-4">
                        <label>Search By Address</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="searchAdr" placeholder="Enter Address" />
                    </div>
            </div>
            </div>
            <br/><br/>
            <div class="col-md-12">
            <div class="col-md-6">
                <div class="col-md-4">
                    <label>Search By Name</label>
                </div>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="searchName" placeholder="Enter Keyword" />
                </div>
            </div>
            </div>
            <br/><br/>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="col-md-4">
                        <label>Search By Attribute</label>
                    </div>
                    <div class="col-md-8" id="all-attr">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button class="btn btn-primary" onclick="getPlaces()" id="searchPlaces">Search</button>
            </div>
        </div>
    </div>
</div>
<div id="map"></div>

<div class="modal fade" tabindex="-1" role="dialog" id="AttributeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <br/>
                <h4 class="modal-title head-style-attr">Place Attributes</h4>
            </div>
            <div id="overlay">
                <table width="100%" height="100%">
                    <tr><td valign="middle"><img src="img/squares.gif" class="middle-img" width="80px" height="80px"/><p>Processing</p></td></tr>
                </table>
            </div>
            <div class="modal-body" id="attr-modal-body"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="infoModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <br/>
                <div id="mod_header"></div>
            </div>
            <div class="modal-body" style="padding:0px !important;height:auto !important;" id="mod_body"></div>
            <div class="modal-footer" id="mod_footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>

<!-- Latest compiled and minified JQuery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyA7xY6JgrR-hAOLs1ZmZU9vCoFNb_YQ7qI"></script>

<script type="text/javascript" src="script.js"></script>
</HTMl>
