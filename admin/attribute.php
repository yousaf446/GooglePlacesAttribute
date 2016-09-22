<?php include_once 'settings.php'; ?>
<HTMl>
<head>

    <link href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Datatables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>

    <style>
        #overlay {
            position: fixed;
            z-index: 1000;
            background-color: #f8f8f8;
            display: none;
            opacity: .75;
            filter: alpha(opacity=75);
            width: 100%;
            height: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<?php include_once 'header.php'; ?>
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#AttributeModal">
    Add New Attribute
</button>
<h4 style="padding-left: 20px">Attributes</h4>
<table id="attribute-table" class="display" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Name</th>
        <th>Value</th>
        <th>Status</th>
        <th>DateTime</th>
    </tr>
    </thead>
    <tbody id="attribute-content"></tbody>
</table>

<div class="modal fade" tabindex="-1" role="dialog" id="AttributeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <br/>
                <h4 class="modal-title head-style-attr">Attribute</h4>
            </div>
            <div id="overlay">
                <table width="100%" height="100%">
                    <tr><td valign="middle"><img src="../img/squares.gif" class="middle-img" width="80px" height="80px"/><p>Processing</p></td></tr>
                </table>
            </div>
            <div class="modal-body" style="height:200px">
                <div class="col-md-12">
                    <label class="col-md-3">Name</label>
                    <input type="text" class="form-control col-md-9" name="attribute_name" id="attribute_name" />
                </div>
                <div class="col-md-12">
                    <label class="col-md-3">Type</label>
                    <select name="attribute_type" id="attribute_type" class="form-control">
                        <option value="">Select One</option>
                        <option value="switch">Switch</option>
                        <option value="dropdown">Dropdown</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="col-md-3">Value</label>
                    <input type="text" class="form-control col-md-9" name="attribute_value" id="attribute_value" placeholder="Enter comma separated values"/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveAttribute()">Save</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>

<!-- Latest compiled and minified JQuery -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Datatables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.get("../api/Attributes/Attribute.php", {key: "GETALL"}, function(response) {
            var attribute = JSON.parse(response);
            var content = "";
            for(var i in attribute) {
                var status = (attribute[i].attribute_status == 1) ? 'ACTIVE' : 'DELETED'
                content += "<tr>";
                content += "<td>"+attribute[i].attribute_name+"</td>";
                content += "<td>"+attribute[i].attribute_value+"</td>";
                content += "<td>"+status+"</td>";
                content += "<td>"+attribute[i].attribute_dtm+"</td>";
                content += "</tr>";
            }
            $("#attribute-content").html(content);
            $('#attribute-table').DataTable();
        });
    });

    function saveAttribute() {
        var attribute_name = $("#attribute_name").val();
        var attribute_type = $("#attribute_type").val();
        var attribute_value = $("#attribute_value").val();

        if(attribute_name != "" || attribute_type != "") {
            $.post("../api/Attributes/Attribute.php", {key: "ADD", attribute_name: attribute_name,
                attribute_type: attribute_type, attribute_value: attribute_value}, function(response) {
                $('#AttributeModal').modal('hide');
            })
        }
    }

</script>

</HTMl>
