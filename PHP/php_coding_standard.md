PHP:
Intendation: Tab = 2x Spaces. Each row is extra intended regarding curly brackets "{}".
```
¶ = space

If
if¶($condition1
    || $condition2
    || $condition3)¶{
¶¶action1;
}¶elseif ($condition1
       || $condition2)
       && $condition3
       && $condition4
)¶{
¶¶]action2;
}¶else¶{
¶¶]defaultaction;
}
```

Switch:

```
switch¶(condition)¶{
case 1:
¶¶action1;
¶¶break;
case 2:
¶¶action2;
¶¶break;
default:
¶¶defaultaction;
¶¶break;
}
```

Try catch:
```
foreach($dsns as $dsn)¶{
    try¶{
        $this->connectDB($dsn);
        return;
    }¶catch¶(Example_Datasource_Exception $e)¶{
        // Some warning/logging code recording the failure
        // to connect to one of the databases
    }
}
```
Variables
```
$short         = foo($bar);
$long_variable = NULL;
$string = 'Foo'¶.¶$bar;
$this->callSomeFunction('param1',     'second',        TRUE);
$this->callSomeFunction('parameter2', 'third',         FALSE);
$this->callSomeFunction('3',          'verrrrrrylong', NULL);

// global variables should include package name as first.
global $PEAR_destructor_object_list

// Constant
define('SOME_CONSTANT', FALSE);

// private definition
$_status;
_myMethod();
private methodName()¶{}
private int variable_name = NULL;

// protected definition
<span class="simpara">protected $some_var</span>
<span class="simpara">protected function initTree()</span>

// no special definition = public
```

Methods
```
function¶functName()¶{
  return(TRUE);
}

$someObject->someFunction("some", "parameter")
    ->someOtherFunc(23, 42)
    ->andAThirdFunction();
// Naming Functions
buildSomeWidget();

$some_array = array(
    'foo'  =>¶'bar',
    'spam' =>¶TRUE,
);

class Foo_Bar
{
    //!!! Classes name are Named_Like_That.
    // functions with the same name as the class name - constructors have first lowercase character.
}
```
Comments

```
/*
¶*
¶* This is the first row describing the function
¶* The function definition is underneath
¶*
*/
```

// First the comment then the code definition

Drupal exceptions:
Variable names are lowercase, separated by underscore.
Alternate control statement syntax for templates

```
<?php if (!empty($item)): ?>
  <p><?php print funct_call($parameter_name); ?></p>
<?php endif; ?>

<?php foreach ($items as $item): ?>
  <p><?php print $item_name; ?></p>
<?php endforeach; ?>
```