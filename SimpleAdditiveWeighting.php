<?php

class SimpleAdditiveWeighting {
    private static $data = [];
    private static $normalize = [];
    private static $result = [];

    const CRITERIA_COST = 'COST';
    const CRITERIA_BENEFIT = 'BENEFIT';

    const SORT_ASC = 'ASCENDING';
    const SORT_DESC = 'DESCENDING';

    public function __construct($data = [])
    {
        self::$data = $data;
    }

    /**
     * Add a data into $data
     *
     * @param array $data
     * @param int $weight
     * @param string $criteria
     */
    public static function addData($data = [], $weight = 1, $criteria = self::CRITERIA_COST)
    {
        array_push(self::$data, [
            'criteria'      => $criteria,
            'data'          => $data,
            'weight'        => $weight
        ]);

        self::$normalize = self::$data;
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
                $weight = $items['weight'];
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
    }
}