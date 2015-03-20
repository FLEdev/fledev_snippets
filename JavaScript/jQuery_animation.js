//Toggle with nice swing of show/hide certain div.
$('#div_id').toggle(
    function(){
        $('.animate_this').animate({marginLeft: '0'}, 1000, 'swing');
    },
    function(){
        $('.animate_this').animate({marginLeft: '-195px'}, 1000, 'swing');
    }
);


// short notation:
// fade in - show element in 3 sec
$('#stars').fadeIn(3000);

// fade out - hide element in 3 sec
$('#stars').fadeOut(3000);

// fade to transparency
$('#stars').fadeTo(<span class="st">"slow",0.4</span>);

// show element in 3 sec
$('#stars').show(3000);

// hide element in 3 sec
$('#stars').hide(2000);

// if showing then hide, if hidden then show
$('#stars').toggle(3000); // these are changing the display css property

// css animation - see the documentation which css properties are supported
$('#the_id_of_div').animate({marginLeft: '-195px'}, 1000, 'swing');


// Animation in specified time interval:
// Start from 1
var counter = 1;
blendIn = function() {
    playBlend = setInterval(function() {
        // do any animation
        $("#bg" + counter).animate( { opacity : 'show'}, 800);
        // repeat 10 times
        if (counter == 10) {
            // finish repeating
            clearInterval(playBlend);
        }
        counter++;
    }, 900);    // play time = 900 - 800, 100 between animation
};
