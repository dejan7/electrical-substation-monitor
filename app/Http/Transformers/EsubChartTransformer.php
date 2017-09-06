<?php

namespace App\Http\Transformers;

class EsubChartTransformer implements \JsonSerializable
{
    /**
     * @var array
     */
    protected $points;

    public function __construct($points)
    {
        $this->points = $points;

    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {

        $this->points = array_reverse($this->points);

        $lines = [];
        foreach ($this->points as $point) {
            foreach ($point as $key => $value) {
                if ($key == "time" || $key == "LOCATION_ID")
                    continue;

                if (!isset($lines[$key])) {
                    $lines[$key] = [];
                    $lines[$key]["x"] = [];
                    $lines[$key]["y"] = [];
                }

                $lines[$key]["x"][] = strtotime($point['time']) * 1000;
                $lines[$key]["y"][] = $point[$key];
            }
        }
        return $lines;
    }
}