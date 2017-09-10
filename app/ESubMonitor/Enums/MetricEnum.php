<?php

namespace App\ESubMonitor\Enums;

class MetricEnum
{
    /**
     * InfluxDB measurement name
     */
    const NAME = "substation_data";

    /**
     * Measured data (tags and fields)
     */
    const ID = 'ID';
    const LOCATION_ID = 'LOCATION_ID';
    const BATCH_TASK_ID = 'BATCH_TASK_ID';
    const VALID = 'VALID';
    const READ_TIME = 'READ_TIME';
    const DEVICE_ID = 'DEVICE_ID';
    const SUCCEDED_COMMUNICATION_ID = 'SUCCEDED_COMMUNICATION_ID';

    const IPAL = 'IPAL';
    const IPAA = 'IPAA';
    const IPAH = 'IPAH';
    const IPBL = 'IPBL';
    const IPBA = 'IPBA';
    const IPBH = 'IPBH';
    const IPCL = 'IPCL';
    const IPCA = 'IPCA';
    const IPCH = 'IPCH';
    const VABL = 'VABL';
    const VABA = 'VABA';
    const VABH = 'VABH';
    const VBCL = 'VBCL';
    const VBCA = 'VBCA';
    const VBCH = 'VBCH';
    const VCAL = 'VCAL';
    const VCAA = 'VCAA';
    const VCAH = 'VCAH';
    const PPTL = 'PPTL';
    const PPTA = 'PPTA';
    const PPTH = 'PPTH';
    const PQTL = 'PQTL';
    const PQTA = 'PQTA';
    const PQTH = 'PQTH';
    const EPTC = 'EPTC';
    const EQTC = 'EQTC';
    const TEML = 'TEML';
    const TEMA = 'TEMA';
    const TEMH = 'TEMH';
    const FREL = 'FREL';
    const FREA = 'FREA';
    const FREH = 'FREH';
    const IPNL = 'IPNL';
    const IPNA = 'IPNA';
    const IPNH = 'IPNH';
    const IPTL = 'IPTL';
    const IPTA = 'IPTA';
    const IPTH = 'IPTH';
    const PPAL = 'PPAL';
    const PPAA = 'PPAA';
    const PPAH = 'PPAH';
    const PPBL = 'PPBL';
    const PPBA = 'PPBA';
    const PPBH = 'PPBH';
    const PPCL = 'PPCL';
    const PPCA = 'PPCA';
    const PPCH = 'PPCH';
    const PQAL = 'PQAL';
    const PQAA = 'PQAA';
    const PQAH = 'PQAH';
    const PQBL = 'PQBL';
    const PQBA = 'PQBA';
    const PQBH = 'PQBH';
    const PQCL = 'PQCL';
    const PQCA = 'PQCA';
    const PQCH = 'PQCH';
    const PSTL = 'PSTL';
    const PSTA = 'PSTA';
    const PSTH = 'PSTH';
    const PFTL = 'PFTL';
    const PFTA = 'PFTA';
    const PFTH = 'PFTH';
    const EPTP = 'EPTP';
    const EQTP = 'EQTP';

    const RESOLUTION_TYPE_ID = 'RESOLUTION_TYPE_ID';

    public static function exists($const) {
        /*constant('self::'. $const);

        return $has;*/
    }
}