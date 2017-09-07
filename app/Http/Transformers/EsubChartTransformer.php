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

        for ($i=0; $i< count($this->points); $i++) {
            foreach ($this->points[$i] as $key => $value) {
                if ($key == "LOCATION_ID")
                    continue;

                if ($key == 'time')
                    $this->points[$i][$key] = strtotime($this->points[$i][$key]) * 1000;
                else
                    $this->points[$i][$key] = round($this->points[$i][$key], 2);
            }
        }
        return $this->points;
/*

        $lines = [];
        foreach ($this->points as $point) {
            $i = 0;
            foreach ($point as $key => $value) {
                if ($key == "LOCATION_ID")
                    continue;

                if (!isset($lines[$i])) {
                    $lines[$i] = [];
                }

                if ($key == 'time')
                    $lines[$i][] = strtotime($point['time']) * 1000;
                else
                    $lines[$i][] = round($point[$key], 2);

                $i++;
            }
        }
        return $lines;*/
    }
}