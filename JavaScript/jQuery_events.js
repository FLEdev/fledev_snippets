// Document ready shorter notation
$(function() {
    // Handler for .ready() called.
});

// Classic Document ready:
(function ($) {
    $(document).ready(function() {
        // your action
    }); // Document Ready end
}(jQuery));

$(window).load(function() {
    (function($) {
        // your code after window loaded
    })(jQuery);
});


// element click
$('#clickme').click(function() {
    console.log('Click event');
});

// hover event
$('#the_listening_tag').hover(
    function () {
        // do action when going over area
    },
    function () {
        // do action when leaving mouse the area
    }
);

// select box value change

$('.letter_space').change(function() {
    console.log($(this).find("option:selected").val());
});

// radio button change

$("input[name='radio_button_name']").change(function(){
    console.log($("input[name='radio_button_name']:checked").val());
});

$('.li>a').click(function(e){
    // this will stop that elements in the further structure be called
    e.stopPropagation();
    // this will prevent the default click, hover or any other action
    e.preventDefault();
});