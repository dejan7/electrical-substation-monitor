<?php

namespace App\ESubMonitor;

use Log;

class InfluxQueryBuilder
{
    /**
     * InfluxQueryBuilder constructor.
     * @param $interfaceRows
     * example: "[{"connector":"or","column":"IPTA","condition":"lt","conditionValue":0,"start":"2017-09-10T17:49:08.000Z","end":"2017-09-10T17:49:17.729Z"}]"
     */

    protected $data;

    protected $perPage = 30;

    protected $addedConditions = 0;

    public function __construct($interfaceRows)
    {
        $this->data = $interfaceRows;
    }

    public function getSelectQuery()
    {

        $query = "";
        $query .= $this->generateSelectClause();
        $query .= $this->generateWhereConditions();
        $query .= $this->generateLocationWhereConditions();
        $query .= $this->generateTimeWhereConditions();


        $offset = $this->perPage * $this->data['page'];
        $query .= " ORDER BY time ASC LIMIT $this->perPage OFFSET $offset";

        return $query;
    }

    public function getPaginationQuery() {
        $query = "";
        $query .= $this->getCountClause();
        $query .= $this->generateWhereConditions();
        $query .= $this->generateLocationWhereConditions();
        $query .= $this->generateTimeWhereConditions();

        return $query;
    }

    private function getCountClause() {
        $query = "SELECT COUNT(mean_IPTH) FROM substation_data ";
        return $query;
    }

    private function generateSelectClause()
    {
        $query = "SELECT ";

        foreach ($this->data['rows'] as $i =>$row) {
            $query .= "mean_" . $row['column'];
            if ($i != (count($this->data['rows']) -1))
                $query .=",";
        }

        $query .= " FROM substation_data ";

        return $query;
    }

    private function generateWhereConditions()
    {
        $query = "";
        $this->addedConditions = 0;
        foreach ($this->data['rows'] as $i =>$row) {
            if ($row['condition'] != 'any') {
                if ($this->addedConditions == 0)
                    $query .= "WHERE ";

                if ($this->addedConditions != 0)
                    $query .= " " . strtoupper($row['connector']) . " ";

                $query .= "mean_" . $row['column'] . " ";

                $query .= $this->getComparison($row['condition']) . " ";

                $query .= $row['conditionValue'];

                $this->addedConditions++;
            }
        }

        return $query;
    }

    private function generateTimeWhereConditions()
    {
        $query = "";
        if ($this->data['start']) {
            if ($this->addedConditions == 0)
                $query .= " WHERE ";
            else
                $query .= " AND ";

            $this->addedConditions++;


            $query .= "time > " .(strtotime($this->data['start'])) . "000000000 "; //to nanoseconds
        }
        if ($this->data['end']) {
            if ($this->addedConditions == 0)
                $query .= " WHERE ";
            else
                $query .= " AND ";

            $this->addedConditions++;


            $query .= "time < " .(strtotime($this->data['end'])) . "000000000 ";
        }

        return $query;
    }

    private function generateLocationWhereConditions()
    {
        $query = "";
        if ($this->addedConditions == 0)
            $query .= " WHERE (";
        else
            $query .= " AND (";

        $this->addedConditions++;

        foreach ($this->data['lids'] as $i=>$lid) {
            $query .= " LOCATION_ID = '$lid' ";
            if ($i == (count($this->data['lids']) - 1)) {
                //last one
                $query .=") ";
            } else {
                $query .= " OR ";
            }
        }


        return $query;
    }

    private function getComparison($operator)
    {
        switch ($operator) {
            case 'lt':
                return "<";
            case 'eq':
                return "=";
            case 'gt':
                return ">";
        }
    }
}