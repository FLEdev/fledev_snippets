<?php
call_user_func(function () {
        echo ' Call user func echo. ';
    });
// returns: Call user func echo.

// -----------------------------------------------------------------------

function run($f) {
    $f();
}

run(function () {
    echo '<br/>' . __FUNCTION__ . ' ' . __FILE__ . ' ' . __CLASS__ . ' end ';
});
// returns: {closure} C:\www\test\index.php end

$test2 = function () {
    echo ' Function as variable ';
};
run($test2);
// returns: Function as variable

// same as the run function without need of extra function implementation:
call_user_func($test2);
// returns: Function as variable

// -----------------------------------------------------------------------

$test3 = function ($param) {
    return 'Entered: ' . $param;
};

echo $test3('clean call parameter');
// returns: Entered: clean call parameter
echo call_user_func($test3, 'call user function');
// returns: Entered: call user function

// -----------------------------------------------------------------------

function generateComparisonFunctionForKey($key) {
    return function ($left, $right) use ($key) {
        if ($left[$key] == $right[$key]) {
            return FALSE;
        } else {
            return ($left[$key] < $right[$key]) ? -1 : 1;
        }
    };
}

$myArray = array(array('name' => 'AAAname', 'age' => 70), array('name' => 'BBBname', 'age' => 25));

$sortByName = generateComparisonFunctionForKey('name');
$sortByAge = generateComparisonFunctionForKey('age');

usort($myArray, $sortByName);
print_r($myArray);
// Array ( [0] => Array ( [name] => AAAname [age] => 70 ) [1] => Array ( [name] => BBBname [age] => 25 ) )

usort($myArray, $sortByAge);
print_r($myArray);
// returns: Array ( [0] => Array ( [name] => BBBname [age] => 25 ) [1] => Array ( [name] => AAAname [age] => 70 ) )

