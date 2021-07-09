<?php

class SimpleAdditiveWeighting {
    private static $data = [];
    private static $normalize = [];
    private static $result = [];

    /**
     * Initialize total weight
     *
     * @var float
     */
    private static $totalWeight = 0.0;

    /**
     * A variable option to reject if the weight is more than 1
     *
     * @var bool
     */
    private static $rejectWeightIfMoreThanOne = false;

    const CRITERIA_COST = 'COST';
    const CRITERIA_BENEFIT = 'BENEFIT';

    const SORT_ASC = 'ASCENDING';
    const SORT_DESC = 'DESCENDING';

    /**
     * If you want get just the data (without weight or any other), use ONLY DATA
     */
    const ONLY_DATA = 'ONLY_DATA';

    /**
     * Calculate the total weight of data
     */
    private static function calculateTotalWeight()
    {
        $temp = self::$data;
        self::$totalWeight = array_reduce($temp, function ($initial, $next) {
            return $initial + $next['weight'];
        }, 0.0);
    }

    /**
     * Get the total weight of data
     *
     * @return float
     */
    public static function totalWeight()
    {
        return self::$totalWeight;
    }

    /**
     * Add a data into $data
     *
     * @param array $data
     * @param int $weight
     * @param string $criteria
     * @throws Exception
     */
    public static function addData($data = [], $weight = 1, $criteria = self::CRITERIA_COST)
    {
        if (self::$rejectWeightIfMoreThanOne && self::$totalWeight > 1) {
            throw new Exception("The weight is more than 1, adding data rejected");
        } else {
            array_push(self::$data, [
                'criteria'      => $criteria,
                'data'          => $data,
                'weight'        => $weight
            ]);

            self::calculateTotalWeight();
            self::$normalize = self::$data;
        }
    }

    /**
     * Get current data
     *
     * @return array
     */
    public static function data()
    {
        return self::$data;
    }

    /**
     * Set reject the data if weight is more than 1
     *
     * @param bool $rejectWeightIfMoreThanOne
     */
    public static function rejectWeightIfMoreThanOne($rejectWeightIfMoreThanOne = false)
    {
        self::$rejectWeightIfMoreThanOne = $rejectWeightIfMoreThanOne;
    }

    /**
     * Get the result
     *
     * @return array
     */
    public static function result()
    {
        return self::$result;
    }

    /**
     * Sort the result
     *
     * @param string $type
     * @return array
     */
    public static function sort($type = self::SORT_ASC)
    {
        $temp = self::$result;
        if ($type === self::SORT_ASC) {
            sort($temp);
        } else if ($type === self::SORT_DESC) {
            rsort($temp);
        }
        return $temp;
    }

    /**
     * Calculate the $data
     */
    public static function calculate()
    {
        $tempData = [];
        self::$data = self::$normalize;

        foreach (self::$data as $items) {
            $values = [];
            foreach ($items['data'] as $item) {
                array_push($values, round($item * $items['weight'], 3));
            }

            array_push($tempData, $values);
        }

        $result = [];
        if (count($tempData) > 0) {

            for ($i = 0; $i < count($tempData[0]); $i++) {
                $value = 0;
                for ($j = 0; $j < count($tempData); $j++) {
                    $value += $tempData[$j][$i];
                }
                array_push($result, round($value, 4));
            }
        }

        self::$result = $result;
    }

    /**
     * Get normalization result
     *
     * @param string $type
     * @return array
     */
    public static function normalizationResult($type = self::ONLY_DATA)
    {
        if ($type === self::ONLY_DATA) {
            $plucked = [];
            foreach (self::$normalize as $collection) {
                if (array_key_exists('data', $collection)) {
                    array_push($plucked, $collection['data']);
                }
            }

            return $plucked;
        }
        return self::$normalize;
    }

    /**
     * Normalizing the data
     */
    public static function normalize()
    {
        foreach (self::$normalize as &$items) {
            $values = [];

            if ($items['criteria'] === self::CRITERIA_BENEFIT) {
                $point = max($items['data']);
                foreach ($items['data'] as $item) {
                    array_push($values, round($item / $point, 3));
                }
            } else if ($items['criteria'] === self::CRITERIA_COST) {
                $point = min($items['data']);
                foreach ($items['data'] as $item) {
                    array_push($values, round($point / $item, 3));
                }
            }

            $items['data'] = $values;
        }
    }

    /**
     * After call calculate function, clear all data
     */
    public static function clear()
    {
        self::$data = [];
        self::$normalize = [];
        self::$result = [];
        self::$rejectWeightIfMoreThanOne = false;
        self::$totalWeight = 0.0;
    }
}