// replace '-' with '_'
str.replace(/\-/g, '_');

// function that checks if the value or key exist in one level array - object
function inObject(srchValue, tmpObj) {
    for (x in tmpObj) {
        if (tmpObj[x] == srchValue || x == srchValue) {
            return true;
        }
    }
    return false;
}

// check if type undefined. Alternative would be if($valName){ }
if (typeof Drupal.settings.someValue !== 'undefined') {
}

// check if arrray contains value or key function:

function inObject(srchValue, tmpObj) {
    for (x in tmpObj) {
        if (tmpObj[x] == srchValue || srchValue == x) {
            return true;
        }
    }
    return false;
}

var tmp_arr = {'one': 'two'};

// the following call returns true
if (inObject('one', tmp_arr)) {
    alert(' found one! ');
}


// Short form for document ready:

$(function () {
    // DOM Ready - do your stuff
});

// Check if element exists (should be used at each action/event):
if ($('#the_identifying_tag').length > 0) {
    // do stuff specifically for this tag
}

// Output data into the console of your browser. At Firefox start FireBug > Console tab:
console.log('your comment here');

// Get content of an html element:
$("#dynamic_content").html();

// Get the parrent element id (use this for actual):
console.log($('#any_div_id').parrent().attr('id'));

// Do something for each specified elements:
$('gross_tag').find('img').each(function () {
    // Set the image tag any attribute
    $(this).attr('alt', 'Image description');
});

// Add content to element:
// clear and add the content to element
$("#dynamic_content").text('the new content for the page');
// add to existent the content to element
$("#dynamic_content").append('<a href="#">new link</a>');

// PHP's foreach in jQuery:
var myArray = new Array['one', 'two', 'three'];
for (x in myArray) {
    console.log(myArray[x]);
}

// Get random value:
// get random value from 3-9
var random_val = Math.floor((9 - 1) * Math.random()) + 3;

// Browser detection:
var browsers_arr = new Array('iPad', 'iPhone', 'iPod');
if (jQuery.inArray(navigator.platform, browsers_arr) > 0) {
    window.location = '<a href="http://some_other.url">http://some_other.url</a>';
}

//Simple Ajax call:
$.ajax({
    type: "POST",
    data: {name: "John", location: "Boston"},
    url: '<a href="http://site_url.com">http://site_url.com</a>',
    // timeout in ms to wait for the answer
    timeout: 2000,
    success: function (html) {
        // after success do
        console.log(html);
    },
    // on status code 404 - failure
    statusCode: {
        404: function () {
            console.log("page not found");
        }
    }
});


// function for cleaining - handling px and % sizes.
function cleanWidth(reqWidth){
    var retVal = false;
    if(reqWidth.substr(-2) == 'px'){
        retVal = parseInt(reqWidth.substr(0, reqWidth.length-2));
    }
    else if(reqWidth.substr(-1) == '%'){
        retVal = parseInt(reqWidth.substr(0, reqWidth.length-1));
    }
    return retVal;
}

// URL Query search parser
function parseSearch(focusQuery){
    var query = window.location.search.substring(1);
    var searchPieces = query.split('&');
    for(var x in searchPieces){
        if( searchPieces[x].indexOf(focusQuery) >= 0){
            return ({'ident' : searchPieces[x].split('=')[0], 'chunks' : searchPieces[x].split('=')[1].split('_')});
        }
    }
    return false;
}


// Drupal recommended document ready:
(function ($) {
    $(document).ready(function() {
        // add your JS code in here
    });
}(jQuery));


// Drupal t function in jQuery
var transl_str = Drupal.t("Hello world!");

// Drupal jQuery functions
// clear all JavaScript added so far.
drupal_static_reset('drupal_add_js');

// any php array
/*
$temp_arr[] = array(
    'url' => '/any/url',
    'title' => $value->node_title
);

drupal_add_js(array('music' => $temp_arr), 'setting'); */

// Within JS the refference to this array would be:

Drupal.settings.music[0]['url'];