Vue.component('date-picker', VueBootstrapDatetimePicker.default);

var queryVue = new Vue({
    el: '#queryContent',
    data: function () {
        return {
            dataKeyValues: eSubKeyValues,
            rows: [
                {connector: 'or', column : 'IPTA', condition: 'any', conditionValue: 0},
            ],
            selectedColumns: [],
            start: null,
            end: null,
            receivedRows: [],
            test: "",
            currentPage: 0,
            maxCount: 0,
            maxPages: 1,
            isLoading: false,
            substations: substations,
            substationIDs: [41],
            aggregate: 'none',
            selector: 'none',
            selectorModifier: ""
        }
    },
    methods: {
        addRow : function () {
            this.rows.push({connector: 'or', column : 'IPTA', condition: 'any', conditionValue: 5});
        },
        removeRow: function (i) {
            this.rows.splice(i, i);
        },
        prevPage: function () {
            this.currentPage--;
            this.getData(true);
        },
        nextPage: function () {
            this.currentPage++;
            this.getData(true);
        },
        getData: function (keepPage) {
            if (!keepPage)
                this.currentPage=0;
            this.isLoading = true;
            this.selectedColumns= [];
            for (var i=0; i< this.rows.length; i++) {
                this.selectedColumns.push(this.dataKeyValues[this.rows[i].column]);
            }
            this.$http.post(SITE_URL + '/api/query/', {
                rows: this.rows,
                start: this.start,
                end: this.end,
                page: this.currentPage,
                lids: this.substationIDs,
                aggregate: this.aggregate,
                selector: this.selector,
                selectorModifier: this.selectorModifier
            })
                .then(function (res) {
                    for (var i =0; i < res.body.results.length; i++) {
                        res.body.results[i].time = moment(res.body.results[i].time).format("YYYY/MM/DD HH:mm");
                    }
                    console.log(res.body);
                    this.receivedRows = res.body.results;
                    this.maxCount = res.body.total;
                    this.isLoading = false;
                    this.updatePagination();
                })
                .catch(function (res) {
                    console.log(res);
                    this.isLoading = false;
                })
        },
        toggleSS: function (lid) {
            var pos = this.substationIDs.indexOf(lid);
            if (pos > -1) {
                if (this.substationIDs.length > 1)
                    this.substationIDs.splice(pos, 1);
            }
            else
                this.substationIDs.push(lid);
        },
        updatePagination: function () {
            this.maxPages = Math.ceil(this.maxCount / 30);
        }
    },
    mounted: function () {
    },
    template: `
<div>
    <div class="row">
        <div class="col-md-12" style="position: relative; z-index: 22">
            <div class="card" >
                <div class="content">
                <div class="query">
                    Prikaži podatke gde je:<br><br>
                    <div class="query-row" v-for="(row, i) in rows">
                        <select v-show="i > 0" class="form-control inlinecontrol border-input" v-model="row.connector">
                            <option value="and">I</option>
                            <option value="or">ILI</option>
                        </select>
                        <select class="form-control inlinecontrol border-input" v-model="row.column" >
                            <option v-for="(value, key) in dataKeyValues" :value="key">{{value}}</option>
                        </select>
                        <select class="form-control inlinecontrol border-input" v-model="row.condition">
                            <option value="any">Bilo koja vrednost</option>
                            <option value="gt">Veće</option>
                            <option value="lt">Manje</option>
                            <option value="eq">Jednako</option>
                        </select>
                        <span v-show="row.condition != 'any'">
                            <span v-show="row.condition != 'eq'">od</span> 
                            <input class="form-control inlinecontrol border-input" placeholder="vrednost" v-model="row.conditionValue">
                        </span>
                        <span v-show="i == (rows.length-1)">
                       
                        </span>
                        <button v-show="i == (rows.length-1)" class="btn btn-success btn-fill" @click="addRow()">+</button>
                        <button v-show="i > 0" class="btn btn-danger btn-fill" @click="removeRow(i)">-</button>
                       
                    </div>
                        <select class="form-control inlinecontrol border-input" v-model="aggregate" v-show="selector == 'none'">
                            <option value="none">Bez funkcije agregacije</option>
                            <option value="COUNT">COUNT</option>
                            <option value="INTEGRAL">INTEGRAL</option>
                            <option value="MEAN">MEAN</option>
                            <option value="MEDIAN">MEDIAN</option>
                            <option value="MODE">MODE</option>
                            <option value="SPREAD">SPREAD</option>
                            <option value="STDDEV">STDDEV</option>
                            <option value="SUM">SUM</option>
                        </select>
                        <select class="form-control inlinecontrol border-input" v-model="selector" v-show="aggregate == 'none'">
                            <option value="none">Bez selektora</option>
                            <option value="BOTTOM">BOTTOM</option>
                            <option value="FIRST">FIRST</option>
                            <option value="LAST">LAST</option>
                            <option value="MAX">MAX</option>
                            <option value="MIN">MIN</option>
                            <option value="PERCENTILE">PERCENTILE</option>
                            <option value="SAMPLE">SAMPLE</option>
                            <option value="TOP">TOP</option>
                        </select>
                        <input class="form-control inlinecontrol border-input" v-model="selectorModifier" placeholder="N selektora" v-show="selector == 'BOTTOM' || selector == 'PERCENTILE' || selector == 'SAMPLE' || selector == 'TOP'"> 
                        u vremenskom periodu od
                        <date-picker class="form-control inlinecontrol border-input" placeholder="Bilo kad" v-model="start" :config="{format: 'YYYY-MM-DD HH:mm'}"></date-picker>
                        do
                        <date-picker class="form-control inlinecontrol border-input" placeholder="Bilo kad" v-model="end" :config="{format: 'YYYY-MM-DD HH:mm'}"></date-picker>
                        <hr>
                            <button class='btn btn-info' v-for="s in substations" :class="{'btn-fill' : substationIDs.indexOf(s.location_id) > -1}" @click="toggleSS(s.location_id)">{{s.name}} (ID: {{s.location_id}})</button> 
                        <hr>
                    <button class="btn btn-primary btn-fill btn-lg" @click="getData()">PRIKAŽI PODATKE</button>
                </div>
                </div>
            </div>
        </div>
    </div>
    
     <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                    <h1>Rezultati:</h1>
                    </div>
                    <div class="content table-responsive table-full-width">
                 
                        <h1 v-show="isLoading" class="text-center"><i class="fa fa-spin fa-spinner"></i> </h1>
                        <div  v-show="receivedRows.length && !isLoading">
                        <p class="text-center">Ukupno {{maxCount}} rezultat{{maxCount > 1 ? 'a' : ''}}</p>
                        <p class="text-center">Prikazujem {{currentPage+1}}. stranu. Ukupno {{maxPages}} strana.</p>
                        <p class="text-center"><button class="btn btn-primary" v-show="currentPage > 0" @click="prevPage()">Prethodna</button> 
                        <button class="btn btn-primary" v-show="(currentPage+1) != maxPages" @click="nextPage()">Sledeća</button>  </p>
                        <table class="table table-striped">
                            <thead>
                                <th v-if="aggregate == 'none'">Vreme</th>
                                <th v-for="col in selectedColumns">
                                    <span v-show="aggregate != 'none'">{{aggregate}}(</span>
                                    {{col}}
                                    <span v-show="aggregate != 'none'">)</span>
                                </th>
                            </thead>
                            <tbody>
                                <tr v-for="res in receivedRows">
                                    <td v-if="aggregate == 'none'">{{res.time}}</td>
                                    <td v-for="(value, key) in res" v-if="key !== 'time'">{{value}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p class="text-center">Ukupno: {{maxCount}} rezultata</p>
                        <p class="text-center">Prikazujem {{currentPage+1}}. od {{maxPages}}. strana.</p>
                        <p class="text-center"><button class="btn btn-primary" v-show="currentPage > 0" @click="prevPage()">Prethodna</button> 
                        <button class="btn btn-primary" v-show="(currentPage+1) != maxPages" @click="nextPage()">Sledeća</button>  </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>        
    `
});