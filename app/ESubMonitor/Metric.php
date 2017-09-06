<?php

namespace App\ESubMonitor;

use App\ESubMonitor\Enums\MetricEnum;
use InfluxDB\Point;

class Metric
{
    /**
     * @var array of data, see App\ESubMonitor\Metric for labels
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->parseFloats();
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toInfluxDBPoint()
    {
        return new Point(
            MetricEnum::NAME,
            null,
            $this->getTags($this->data),
            $this->getFields($this->data),
            $this->get(MetricEnum::READ_TIME)
        );
    }

    /**
     * Pluck key-value pairs where values are strings (InfluxDB tags)
     *
     * @return array
     */
    public function getTags()
    {
        return array_only($this->data, [
            MetricEnum::LOCATION_ID,
            MetricEnum::BATCH_TASK_ID,
            MetricEnum::DEVICE_ID
        ]);
    }

    /**
     * Pluck key-value pairs where values are numbers (InfluxDB fields)
     *
     * @return array
     */
    public function getFields()
    {
        return array_except($this->data, [
            MetricEnum::ID,
            MetricEnum::LOCATION_ID,
            MetricEnum::BATCH_TASK_ID,
            MetricEnum::VALID,
            MetricEnum::READ_TIME,
            MetricEnum::DEVICE_ID,
            MetricEnum::SUCCEDED_COMMUNICATION_ID,
            MetricEnum::RESOLUTION_TYPE_ID
        ]);
    }

    /**
     * Some of the fields might be received as rounded floats i.e. integers
     * Make sure that every field is a float to avoid InfluxDB Conflicts
     */
    private function parseFloats()
    {
        $fields = $this->getFields();

        foreach ($fields as $key=>$value) {
            $this->data[$key] = (float) $this->data[$key];
        }
    }

}