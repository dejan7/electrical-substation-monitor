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

        //return $this->points;
        $this->points = array_reverse($this->points);

        $lines = [];
        foreach ($this->points as $point) {
            $i = 0;
            foreach ($point as $key => $value) {
                if ($key == "LOCATION_ID")
                    continue;

                $trKey = $key == 'time' ? 'x' : $key;

                if (!isset($lines[$i])) {
                    $lines[$i] = [];
                    $lines[$i][] = $trKey;
                }

                if ($trKey == 'x')
                    $lines[$i][] = strtotime($point['time']) * 1000;
                else
                    $lines[$i][] = round($point[$key], 2);

                $i++;
            }
        }
        return $lines;
    }
}