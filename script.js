var map;
var markers = [];
var infowindow;
var service;
var map_center = new google.maps.LatLng(37.0902, -95.7129);
var current_loc = "";
var user_cookie;
var user_name;
var counter = 0;
var placeInterval;
var attr_count = 0;
var attr_type = [];

function initialize() {

    $.post('api/Users/Users.php', { key: 'SETCOOKIE'}, function(response) {
        var user_data = JSON.parse(response);
        user_cookie = user_data.guest;
        user_name = user_data.user;
        if(user_name != "") {
            $("#user").html("Welcome "+user_name);
        } else {
            $("#user").html("Welcome "+user_cookie);
        }
    });

    $.get('api/Attributes/Attribute.php', { key: 'GET'}, function(response) {
        var data = JSON.parse(response);
        var attributes = data.attributes;
        var content = "";
        attr_count = attributes.length;
        for(var i in attributes) {
            content += '<div class="col-md-12">';
            attr_type[i] = [];
            attr_type[i].type = attributes[i].attribute_type;
            attr_type[i].name = attributes[i].attribute_name;
            attr_type[i].id = attributes[i].attribute_id;
            if(attributes[i].attribute_type == 'switch') {
                content += '<div class="col-md-6"><label>' + attributes[i].attribute_name + '</label></div><div class="col-md-6"><label class="switch"> <input type="checkbox" id="attr_' + i + '"> <div class="slider round"></div> </label></div>';
            } else if(attributes[i].attribute_type == 'dropdown') {
                content += '<div class="col-md-6"><label>' + attributes[i].attribute_name + '</label></div><div class="col-md-6"><select id="attr_' + i + '">';
                var values = attributes[i].attribute_value.split(",");
                content += '<option value="">Select One</option>';
                for(var i in values) {

                    content += '<option value="'+values[i]+'">'+values[i]+'</option>';
                }
                content += '</select></div>';
            }
            content += '</div><br/>';
        }
        $('#all-attr').html(content);
    });
    var mapOptions = {
        center: map_center,
        zoom: 4
    };

    google.maps.visualRefresh = true;

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    service = new google.maps.places.PlacesService(map);

    infowindow = new google.maps.InfoWindow();

    var searchAdr = (document.getElementById('searchAdr'));
    var autocomplete = new google.maps.places.Autocomplete(searchAdr);
    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            return;
        }
        map.setCenter(place.geometry.location);
        current_loc = place.geometry.location;
        map.setZoom(14);
    });

}

function getPlaces() {
    var request = [];
    request.location = current_loc;
    request.radius = 5000;
    request.types = ['establishment'];
    var keyword = $("#searchName").val();
    if(keyword != "") request.keyword = keyword;
    service.nearbySearch(request, callback);
}

function callback(results, status, pagination) {
    if (status != google.maps.places.PlacesServiceStatus.OK) {
        clearOverlays();
    } else {
        createMarkers(results);
    }
}
function clearOverlays() {
    for(var i=0;i<markers.length;i++) {
        markers[i].setMap(null);
    }
    markers.length = 0;
    counter = 0;
}
function createMarkers(places) {
    clearOverlays();
    var attr_filters = getAttrFilters();
    placeInterval = setInterval(function() {
    if(counter == 20) {
        clearInterval(placeInterval);
        $("#searchPanel").collapse('hide');
    }
    $.get('api/Places/Places.php', { key: 'GET', place_id: places[counter].place_id, filters: JSON.stringify(attr_filters)}, function(response) {
        if(response == 'PEPSI') {
            var mark_image = new google.maps.MarkerImage(
                "img/markers/pepsi.png",
                null, /* size is determined at runtime */
                null, /* origin is 0,0 */
                null, /* anchor is bottom center of the scaled image */
                new google.maps.Size(32, 32)
            );
        } else if(response == 'COKE') {
            var mark_image = new google.maps.MarkerImage(
                "img/markers/coke.png",
                null, /* size is determined at runtime */
                null, /* origin is 0,0 */
                null, /* anchor is bottom center of the scaled image */
                new google.maps.Size(32, 32)
            );
        } else if(response == 'OTHER') {
            var mark_image = new google.maps.MarkerImage(
                "img/markers/other.png",
                null, /* size is determined at runtime */
                null, /* origin is 0,0 */
                null, /* anchor is bottom center of the scaled image */
                new google.maps.Size(32, 32)
            );
        } else {
            var mark_image = new google.maps.MarkerImage(
                "img/markers/simple.png",
                null, /* size is determined at runtime */
                null, /* origin is 0,0 */
                null, /* anchor is bottom center of the scaled image */
                new google.maps.Size(32, 32)
            );
        }

        markers[counter] = new google.maps.Marker({
            map: map,
            title: places[counter].name,
            id: places[counter].place_id,
            name: counter,
            icon: mark_image,
            position: places[counter].geometry.location
        });

        google.maps.event.addListener(markers[counter], "rightclick", function (event) {
            editAttribute(this.id, this.name);
        });

        google.maps.event.addListener(markers[counter], "click", function (event) {
         getContent(this.id);
        });
        counter++;
    });
}, 20);
}
function editAttribute(place_id, counter) {
    $.get('api/Attributes/Attribute.php', { key: 'GET', place_id: place_id}, function(response) {
        var data = JSON.parse(response);
        var content = "";
        var attributes = data.attributes;
        var place = data.place;
        for(var i in attributes) {
            var current_val = "";
            for(var j in place) {
                if(place[j].attribute_id == attributes[i].attribute_id) {
                    current_val = place[j].attribute_value;
                }
            }
            content += '<div class="col-md-12">';
            if(attributes[i].attribute_type == 'switch') {
                var checked = "";
                if(current_val == 'true') {
                    checked = "checked";
                }
                content += '<div class="col-md-3"><label>' + attributes[i].attribute_name + '</label></div><div class="col-md-9"><label class="switch"> <input type="checkbox" id="attr_' + attributes[i].attribute_id + '" onclick="saveAttribute('+counter+', this.id, this.checked)" '+checked+'> <div class="slider round"></div> </label></div>';
            } else if(attributes[i].attribute_type == 'dropdown') {
                var option = current_val;
                content += '<div class="col-md-3"><label>' + attributes[i].attribute_name + '</label></div><div class="col-md-9"><select id="attr_' + attributes[i].attribute_id + '" onchange="saveAttribute('+counter+', this.id, this.value)">';
                var values = attributes[i].attribute_value.split(",");
                for(var i in values) {
                    var selected = "";
                    if(values[i] == current_val) {
                        selected = "selected";
                    }
                    content += '<option value="'+values[i]+'" '+selected+'>'+values[i]+'</option>';
                }
                content += '</select></div>';
            }
            content += '</div><br/>';
        }
        $('#attr-modal-body').html(content);
        $('#AttributeModal').modal('show');
    });
}

function saveAttribute(counter, attr_id, attr_value) {
    $("#overlay").show();
    var place_id = markers[counter].id;
    $.post('api/Places/Places.php', { key: 'SAVE', place_id: place_id, attribute_id: attr_id, attribute_value: attr_value}, function(response) {
        $("#overlay").hide();
    });
}

function getContent(place_id) {
    var request = {
        placeId : place_id
    };
    var service2 = new google.maps.places.PlacesService(map);

    service2.getDetails(request, function(myplace, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {
            var address = myplace.address_components;
            var name = myplace.name;
            var city;
            var country;
            var format_phone = myplace.formatted_phone_number;
            var internation_phone = myplace.international_phone_number;
            var website = myplace.website;
            var rating = myplace.rating;
            var category = "";
            var format_address = myplace.formatted_address;
            var photo = myplace.photos;
            var open_hour = "";
            if(myplace.opening_hours != undefined){
                var aTime = myplace.opening_hours.weekday_text[0];
                var time = aTime.split(" ");
                for(var i=1 ;i < time.length; i++)
                    open_hour += time[i];
            }
        }
        var header = "";
        header = '<h3 class="modal-title">'+name+'</h3>';
        $('#mod_header').html(header);
        var body = "";
        if(myplace.opening_hours != undefined || rating != undefined)
            body += "<div class='col-md-12'>";
        if(myplace.opening_hours != undefined)
            body += "<div class='col-md-7'>";
        if(myplace.opening_hours != undefined)
            body += "<label style='color:#CC5D11'>Hours: </label><label style='font-size:20px;style='display:inline'> &nbsp"+open_hour+"</label><br/>";
        if(myplace.open_now != undefined || myplace.opening_hours != undefined)
            body += "</div>";
        if(rating != undefined) {
            body += "<div class='col-md-5'>";
            body += '<label style="color:#CC5D11"> Rating: </label><label style="font-size:20px"> &nbsp'+rating+'</label><label style="font-size:10px:display:inline"> / 5</label><br/>';
            body += '</div>';
        } else
            body += "<div class='col-md-5'></div>";
        if(myplace.opening_hours == undefined)
            body += "<div class='col-md-7'></div>";
        if(myplace.opening_hours != undefined || rating != undefined)
            body += "</div>";

        if(photo != undefined) {
            body += "<div class='col-md-12'><div class='col-md-6'><img style='padding-left:15px;height:700px:width:250px' src='"+photo[0].getUrl({'maxWidth': 250, 'maxHeight': 700})+"' /></div><div class='col-md-6'>"
        } else body += "<div class='col-md-12'>";
        if(format_phone != undefined)
            body += '<br/><label style="color:#CC5D11"> Phone: </label><label style="display:inline;font-size:14px"> '+format_phone+'</label>';
        if(format_address != undefined)
            body += '<br/><label style="color:#CC5D11"> Address: </label><label style="display:inline;font-size:14px"> '+format_address+'</label>';
        if(website != undefined)
            body += '<br/><label style="color:#CC5D11"> Website: </label><a href="'+website+'" target="_blank">&nbsp'+website+'</a>';

        var reviews = myplace.reviews;
        if(reviews != undefined) {
            body += '<h4 style="color:#CC5D11"> Reviews </h4>';
            body += '<ul>';
            var stop = false;
            for(var i=0;i<reviews.length;i++) {
                if(i < 2) {
                    if(reviews[i].text != "") {
                        var text = reviews[i].text;

                        var Ares2 = text.split(".");
                        var res1 = Ares2[0] + ".";
                        if(Ares2[0].length < 200)
                            body += '<li>'+res1+'</li>';
                    }
                }
            }
            body += '</ul>';
        }
        if(photo != undefined)
            body += '</div>';
        body += '</div>';
        $('#mod_header').css('background-color','black');
        $('#mod_header').css('color','white');

        $('#mod_body').html(body);

        $('#infoModal').modal('show');
    });
}

function getAttrFilters() {
    var filters = [];
    for(var i=0;i<attr_count;i++) {
        if(attr_type[i].type == 'switch') {
            if($('#attr_'+i).prop('checked')) {
                filters[attr_type[i].id] = 'true';
            }
        } else if(attr_type[i].type == 'dropdown') {
            filters[attr_type[i].id] = $('#attr_'+i).val();
        }
    }
    return filters;
}

google.maps.event.addDomListener(window, 'load', initialize);