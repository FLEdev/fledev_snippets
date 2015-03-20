// array object
var my_multid_arr = [
    { 'foo': 'first foo', 'bar' : 'first bar'},
    { 'foo': 'second foo', 'bar' : 'second bar'},
    { 'foo': 'third foo', 'bar' : 'find me'},
    { 'foo': 'fourth foo', 'bar' : 'fourth bar'},
];
// search procedure:

var array = my_multid_arr.filter(function (srch) { return srch.bar == 'find me' });

// Off topic:
// Alternative Array definition in JavaScript:

var myCars=['first', 'second', 'third'];
