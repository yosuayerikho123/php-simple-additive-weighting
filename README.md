# PHP Simple Additive Weighting
This is just a simple additive weighting created with php

### Examples
Add some data you want
```php
require_once "SimpleAdditiveWeighting.php";

// set to TRUE if you don't want the weight more than 1
// it will throw an error if the weight is more than 1
SimpleAdditiveWeighting::rejectWeightIfMoreThanOne(true);

// add some data
SimpleAdditiveWeighting::addData([
    150, 500, 200, 350
], 0.25, SimpleAdditiveWeighting::CRITERIA_COST);

SimpleAdditiveWeighting::addData([
    15, 200, 10, 100
], 0.15, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

SimpleAdditiveWeighting::addData([
    2, 2, 3, 3
], 0.30, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

SimpleAdditiveWeighting::addData([
    2, 3, 1, 1
], 0.25, SimpleAdditiveWeighting::CRITERIA_COST);

SimpleAdditiveWeighting::addData([
    3, 2, 3, 2
], 0.05, SimpleAdditiveWeighting::CRITERIA_BENEFIT);
```

Then you must normalize and calculate the data
```php
SimpleAdditiveWeighting::normalize();
SimpleAdditiveWeighting::calculate();
```

Then you can get the result
```php
$result = SimpleAdditiveWeighting::result();
var_dump($result);

// the result with some data above will be
// array(4) 
// { 
//      [0] => float(0.636) 
//      [1] => float(0.541) 
//      [2] => float(0.796) 
//      [3] => float(0.765) 
// }
```

If you want to get normalization result (after it normalize), you can do with this
```php
SimpleAdditiveWeighting::normalize();
var_dump(SimpleAdditiveWeighting::normalizationResult());
```

You can sort ascending or descending the result
```php
$ascending = SimpleAdditiveWeighting::sort(SimpleAdditiveWeighting::SORT_ASC);
var_dump($ascending);

// the result will be
// array(4) 
// { 
//      [0] => float(0.541) 
//      [1] => float(0.636) 
//      [2] => float(0.765) 
//      [3] => float(0.796) 
// }

$descending = SimpleAdditiveWeighting::sort(SimpleAdditiveWeighting::SORT_DESC);
var_dump($descending);

// the result will be 
// array(4) 
// { 
//      [0] => float(0.796) 
//      [1] => float(0.765) 
//      [2] => float(0.636) 
//      [3] => float(0.541) 
// }
```

Don't forget to clear the data if you want to calculate again
```php
SimpleAdditiveWeighting::clear();
```

### Full Code
```php
SimpleAdditiveWeighting::rejectWeightIfMoreThanOne(true);

SimpleAdditiveWeighting::addData([
    150, 500, 200, 350
], 0.25, SimpleAdditiveWeighting::CRITERIA_COST);

SimpleAdditiveWeighting::addData([
    15, 200, 10, 100
], 0.15, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

SimpleAdditiveWeighting::addData([
    2, 2, 3, 3
], 0.30, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

SimpleAdditiveWeighting::addData([
    2, 3, 1, 1
], 0.25, SimpleAdditiveWeighting::CRITERIA_COST);

SimpleAdditiveWeighting::addData([
    3, 2, 3, 2
], 0.05, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

SimpleAdditiveWeighting::normalize();
SimpleAdditiveWeighting::calculate();

$result = SimpleAdditiveWeighting::result();
var_dump($result);
```