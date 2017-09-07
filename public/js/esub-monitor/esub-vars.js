var eSubCharts = {
    power : {name:"Struja", value:"IPTL,IPTA,IPTH", labels:['Tmin','Tsr','Tmax'], unitMeasure:"Struja (mA)"},
    true_power: {name:"Aktivna snaga", value:"PPTL,PPTA,PPTH", labels:['Pmin','Psr','Pmax'], unitMeasure:"Snaga (W)"},
    reactive_power: {name:"Reaktivna snaga", value:"PQTL,PQTA,PQTH", labels:['Qmin','Qsr','Qmax'], unitMeasure:"Reaktivna snaga (VAR)"},
    apparent_power: {name:"Prividna snaga", value:"PSTL,PSTA,PSTH", labels:['Smin','Ssr','Smax'], unitMeasure:"Prividna snaga (VA)"},
    power_factor: {name:"Faktor snage", value:"PFTL,PFTA,PFTH", labels:['PFmin','PFsr','PFmax'], unitMeasure:"Faktor snage"},
    frequency: {name:"Frekvencija", value:"FREL,FREA,FREH", labels:['Fmin','Fsr','Fmax'], unitMeasure:"Frekvencija (Hz)"},
    temperature: {name:"Temperatura", value:"TEML,TEMA,TEMH", labels:['TEMPmin','TEMPsr','TEMPmax'], unitMeasure:"Temperatura (C)"},
    current_zero: {name:"Struja nule", value:"IPNL,IPNA,IPAH", labels:['Nmin','Nsr','Nmax'], unitMeasure:"Struja nule (mA)"},
    current_phases: {name:"Struje faza", value:"IPAA,IPBA,IPCA,IPAH,IPBH,IPCH,IPAL,IPBL,IPCL", labels:['A','B','C','Amax','Bmax','Cmax','Amin','Bmin','Cmin'], unitMeasure:"Struja (mA)"},
    voltage_phases: {name:"Fazni naponi", value:"VABH,VBCH,VCAH,VABA,VBCA,VCAA,VABL,VBCL,VCAL", labels:['ABmax','BCmax','CAmax','AB','BC','CA','ABmin','BCmin','CAmin'], unitMeasure:"Napon (kV)"},
    true_power_phases: {name:"Aktivna snaga faza", value:"PPAA,PPBA,PPCA,PPAH,PPBH,PPCH,PPAL,PPBL,PPCL", labels:['A','B','C','Amax','Bmax','Cmax','Amin','Bmin','Cmin'], unitMeasure:"Aktivna snaga (kW)"},
    reactive_power_phases: {name:"Reaktivna snaga faza", value:"PQAA,PQBA,PQCA,PQAH,PQBH,PQCH,PQAL,PQBL,PQCL", labels:['A','B','C','Amax','Bmax','Cmax','Amin','Bmin','Cmin'], unitMeasure:"Reaktivna snaga (kW)"}
};

var eSubIntervals = {
    'real-time': "Uživo",
    '1m': "1 minut",
    '5m': "5 minuta",
    '60m': "1 sat",
    '6h': "6 sati",
    '24h': "1 dan"
};