<template>
    <div>
        <notif-component :d="notif" :dt="dt" :text="text" :status="err_status"></notif-component>
        <v-card flat>
            <v-card-text class="pb-0">
                <v-card>
                    <v-tabs v-model="tab" background-color="primary" dark>
                        <v-tab href="#generalsurvey">General Survey</v-tab>
                        <v-tab href="#hpi">History of Present Illness</v-tab>
                        <v-tab href="#pmh">Past Medication History</v-tab>
                        <v-tab href="#ppe">Pertinent Physical Examination</v-tab>
                        <v-tab href="#rnd">Diagnostics & Requests</v-tab>
                        <v-tab href="#medication">Medication</v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
                        <v-tab-item id="generalsurvey" value="generalsurvey">
                            <v-card flat>
                                <v-card-text><gen-surv :record="record" :errs="errors"></gen-surv></v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item style="height: 69vh; overflow: auto;" id="hpi" value="hpi">
                            <v-card flat>
                                <v-card-text>
                                    <hpi-component :record="record" :errs="errors"></hpi-component>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item style="height: 69vh; overflow: auto;" id="pmh" value="pmh">
                            <v-card flat>
                                <v-card-text>
                                    <pmh-component :pid="patient.id" :rid="record.id" :a="patient.allergies" :hfds="patient.hfds" :pm="record.past_medications" :h="record.hospitalizations" :errs="errors"></pmh-component>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item style="height: 69vh; overflow: auto;" id="ppe" value="ppe">
                            <v-card flat>
                                <v-card-text>
                                    <ppe-component :exam="record.examination" :errs="errors"></ppe-component>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item style="height: 69vh; overflow: auto;" id="rnd" value="rnd">
                            <v-card flat>
                                <v-card-text>
                                    <dnr-component :rid="record.id" :reqs="record.requests" :diags="record.diagnoses" :errs="errors"></dnr-component>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item style="height: 69vh; overflow: auto;" id="medication" value="medication">
                            <v-card flat>
                                <v-card-text>
                                    <medication-component :record="record" :m="record.medications" :errs="errors"></medication-component>
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </v-card-text>

            <v-card-actions class="d-flex justify-content-around">
                <div v-if="saving" class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <button v-else class="btn btn-primary" @click="save">
                    <i class="fa fa-save"></i>
                    &nbsp;Save
                </button>
            </v-card-actions>
        </v-card>
    </div>
</template>
<script>
export default {
    props: ['patient','record','e'],
    data () {
        return {
            tab: null,
            lkups: [],
            errors: [],
            saving: false,
            notif: false, dt: null, text: null, err_status: null,
        }
    },
    mounted () {
        axios.get('/Lookup/prettylookups').then(
            response => {
                this.lkups = response.data;
            }
        ).catch(
            errors => {
                this.errors = errors.response.data.errors;
            }
        );

        this.record.examination = (this.record.examination == null) ? {
            skin: '', hair: '', nails: '', head: '', eyes: '', ears: '', nose: '', mouth: '', throat: '', neck: '', cl: '', heart: '', abdomen: '', back: '', ext: '', impression: '',
        }:this.record.examination;
    },
    methods: {
        save () {
            this.saving = true;
            if (this.e) {
                axios.patch(`Tab/${this.tab}`, this.record).then(
                    response => {
                        this.saving = false;
                        this.record = response.data;
                    }
                ).catch(
                    errors => {
                        if (errors.response.data.errors) {
                            this.errors = errors.response.data.errors;
                        }
    
                        if (errors.response.data.message) {
                            this.notif = true;
                            this.dt = "err";
                            this.text = errors.response.statusText;
                            this.err_status = errors.response.status;
                        }
                        this.saving = false;
                    }
                )
            }else{
                axios.post(`Tab/${this.tab}`, this.record).then(
                    response => {
                        this.saving = false;
                        this.record = response.data;
                        location.href = `/Patient/${this.patient.id}/Record/${this.record.id}/Edit`;
                    }
                ).catch(
                    errors => {
                        if (errors.response.data.errors) {
                            this.errors = errors.response.data.errors;
                        }
    
                        if (errors.response.data.message && errors.response.status != 422) {
                            this.notif = true;
                            this.dt = "err";
                            this.text = errors.response.statusText;
                            this.err_status = errors.response.status;
                        }
                        this.saving = false;
                    }
                )

            }
        },
    }
}
</script>