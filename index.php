<?php
require_once "SimpleAdditiveWeighting.php";

SimpleAdditiveWeighting::rejectWeightIfMoreThanOne(true);

// C1
SimpleAdditiveWeighting::addData([
    0.5, 0.8, 1, 0.2, 1
], 0.3, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

// C2
SimpleAdditiveWeighting::addData([
    1, 0.7, 0.3, 1, 0.7
], 0.2, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

// C3
SimpleAdditiveWeighting::addData([
    0.7, 1, 0.4, 0.5, 0.4
], 0.2, SimpleAdditiveWeighting::CRITERIA_BENEFIT);

// C4
SimpleAdditiveWeighting::addData([
    0.7, 0.5, 0.7, 0.9, 0.7
], 0.15, SimpleAdditiveWeighting::CRITERIA_COST);

// C5
SimpleAdditiveWeighting::addData([
    0.8, 1, 1, 0.7, 1
], 0.15, SimpleAdditiveWeighting::CRITERIA_COST);

SimpleAdditiveWeighting::normalize();
SimpleAdditiveWeighting::calculate();

var_dump(SimpleAdditiveWeighting::normalizationResult());

var_dump(SimpleAdditiveWeighting::result());

SimpleAdditiveWeighting::clear();

echo "<br/>";
echo "<br/>";
echo "<hr/>";
echo "<br/>";

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

var_dump(SimpleAdditiveWeighting::sort(SimpleAdditiveWeighting::SORT_DESC));