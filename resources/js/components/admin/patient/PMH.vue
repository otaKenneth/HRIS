<template>
    <div class="container-fluid">
        <div class="form-group">
            <span class="font-semibold">Past Hospitalization</span>
            <table class="table table-striped table-inverse table-responsive-sm">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Hospital</th>
                        <th>Date</th>
                        <th>Dx</th>
                        <th>Duration</th>
                        <th>Attending</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-</td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="hospital" id="hospital" class="form-control" placeholder="Aa..." :class="(errors.hospital) ? 'is-invalid':''" v-model="hospitalization.hospital">
                                    <span v-if="errors.hospital" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.hospital[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="h_date" id="h_date" class="form-control datepicker" data-date-format="mm/dd/yyyy" data-provide="datepicker" placeholder="mm/dd/yyyy" :class="(errors.h_date) ? 'is-invalid':''" v-model="hospitalization.h_date" @blur="mydate('h_date')">
                                    <span v-if="errors.h_date" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.h_date[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="dx" id="dx" class="form-control" placeholder="Aa..." :class="(errors.dx) ? 'is-invalid':''" v-model="hospitalization.dx">
                                    <span v-if="errors.dx" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.dx[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="ph_duration" id="ph_duration" class="form-control" placeholder="Aa..." :class="(errors.ph_duration) ? 'is-invalid':''" v-model="hospitalization.duration">
                                    <span v-if="errors.ph_duration" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.ph_duration[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="attending" id="attending" class="form-control" placeholder="Aa..." :class="(errors.attending) ? 'is-invalid':''" v-model="hospitalization.attending">
                                    <span v-if="errors.attending" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.attending[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="ph_remarks" id="ph_remarks" class="form-control" placeholder="Aa..." :class="(errors.ph_remarks) ? 'is-invalid':''" v-model="hospitalization.remarks">
                                    <span v-if="errors.ph_remarks" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.ph_remarks[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button v-if="!editable.h" type="button" class="btn btn-primary" @click="createHospitalization"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type="button" v-else class="btn btn-primary" @click="updateHospitalization"><i class="fas fa-save"></i></button>
                            </td>
                        </tr>
                        <tr v-for="(hospital_record, k) in h" :key="k">
                            <td> {{k+1}} </td>
                            <td> {{hospital_record.hospital}} </td>
                            <td> {{hospital_record.h_date}} </td>
                            <td> {{hospital_record.dx}} </td>
                            <td> {{hospital_record.duration}} </td>
                            <td> {{hospital_record.attending}} </td>
                            <td> {{hospital_record.remarks}} </td>
                            <td>
                                <button type="button" v-if="hospitalization.id == hospital_record.id" class="btn btn-danger" @click="hospitalization = {}; editable.h = false;"><i class="fa fa-times" aria-hidden="true"></i></button>
                                <button type="button" v-else class="btn btn-warning" @click="hospitalization = hospital_record; editable.h = true;"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="form-group">
            <span class="font-semibold">Past Medication</span>
            <table class="table table-striped table-inverse table-responsive-sm">
                <thead class="thead-inverse">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Dose</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>-</td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="drug_name" id="drug_name" class="form-control" placeholder="Aa..." :class="(errors.drug_name) ? 'is-invalid':''" v-model="past_med.name">
                                    <span v-if="errors.drug_name" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.drug_name[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="dose" id="dose" class="form-control" placeholder="Aa..." :class="(errors.dose) ? 'is-invalid':''" v-model="past_med.dose">
                                    <span v-if="errors.dose" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.dose[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="frequency" id="frequency" class="form-control" placeholder="Aa..." :class="(errors.frequency) ? 'is-invalid':''" v-model="past_med.frequency">
                                    <span v-if="errors.frequency" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.frequency[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="pm_duration" id="pm_duration" class="form-control" placeholder="Aa..." :class="(errors.pm_duration) ? 'is-invalid':''" v-model="past_med.duration">
                                    <span v-if="errors.pm_duration" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.pm_duration[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="pm_remarks" id="pm_remarks" class="form-control" placeholder="Aa..." :class="(errors.pm_remarks) ? 'is-invalid':''" v-model="past_med.remarks">
                                    <span v-if="errors.pm_remarks" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.pm_remarks[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button type="button" v-if="!editable.pm" class="btn btn-primary" @click="createPastMedication"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type="button" v-else class="btn btn-primary" @click="updatePastMedication"><i class="fas fa-save"></i></button>
                            </td>
                        </tr>
                        <tr v-for="(p_med, k) in pm" :key="k">
                            <td> {{k+1}} </td>
                            <td> {{p_med.name}} </td>
                            <td> {{p_med.dose}} </td>
                            <td> {{p_med.frequency}} </td>
                            <td> {{p_med.duration}} </td>
                            <td> {{p_med.remarks}} </td>
                            <td>
                                <button type="button" v-if="past_med.id == p_med.id" class="btn btn-danger" @click="past_med = {}; editable.pm = false;"><i class="fa fa-times" aria-hidden="true"></i></button>
                                <button type="button" v-else class="btn btn-warning" @click="past_med = p_med; editable.pm = true;"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="form-group">
            <span class="font-semibold">In-Born Sicknesses</span>
            <div class="d-flex">
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <span class="font-semibold">Herido Familial Desease</span>
                        <table class="table table-striped table-inverse table-responsive-sm">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>
                                            <div class="form-group m-0">
                                                <input type="text" name="hfd_name" id="hfd_name" class="form-control" placeholder="Aa..." :class="(errors.disease) ? 'is-invalid':''" v-model="hfd.disease">
                                                <span v-if="errors.disease" class="invalid-feedback" role="alert">
                                                    <strong>{{ errors.disease[0] }}</strong>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" v-if="!editable.hfds" class="btn btn-primary" @click="createHfd"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <button type="button" v-else class="btn btn-primary" @click="updateHfd"><i class="fas fa-save" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                                    <tr v-for="(disease, k) in hfds" :key="k">
                                        <td> {{k+1}} </td>
                                        <td> {{disease.disease}} </td>
                                        <td>
                                            <button type="button" v-if="hfd.id == disease.id" class="btn btn-danger" @click="hfd = {}; editable.hfds = false;"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            <button type="button" v-else class="btn btn-warning" @click="hfd = disease; editable.hfds = true;"><i class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="form-group">
                        <span class="font-semibold">Allergies</span>
                        <table class="table table-striped table-inverse table-responsive-sm">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>-</td>
                                        <td>
                                            <div class="form-group m-0">
                                                <input type="text" name="a_name" id="a_name" class="form-control" placeholder="Aa..." :class="(errors.allergy) ? 'is-invalid':''" v-model="allergy.allergy">
                                                <span v-if="errors.allergy" class="invalid-feedback" role="alert">
                                                    <strong>{{ errors.allergy[0] }}</strong>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" v-if="!editable.a" class="btn btn-primary" @click="createAllergy"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                            <button type="button" v-else class="btn btn-primary" @click="updateAllergy"><i class="fas fa-save"></i></button>
                                        </td>
                                    </tr>
                                    <tr v-for="(alg, k) in a" :key="k">
                                        <td> {{k+1}} </td>
                                        <td> {{alg.allergy}} </td>
                                        <td>
                                            <button type="button" v-if="allergy.id == alg.id" class="btn btn-danger" @click="allergy = {}; editable.a = false;"><i class="fa fa-times" aria-hidden="true"></i></button>
                                            <button type="button" v-else class="btn btn-warning" @click="allergy = alg; editable.a = true;"><i class="fas fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['pid','rid','a','hfds','h','pm'],
    data () {
        return {
            editable: {
                h: false,
                pm: false,
                hfds: false,
                a: false,
            },
            hospitalization: {
                patient_record_id: this.rid, hospital:'', h_date:'', dx:'', duration:'', attending:'', remarks:''
            },
            past_med: {
                patient_record_id: this.rid, name:'', dose:'', frequency:'', duration:'', remarks:'',
            },
            hfd: {
                patient_id: this.pid, disease: ''
            },
            allergy: {
                patient_id: this.pid, allergy: ''
            },
            errors: [],
        }
    },
    methods: {
        createHospitalization () {
            axios.post(`Hospitalization`, this.hospitalization).then(
                response => {
                    // console.log(response.data);
                    this.hospitalization = {
                        patient_record_id: this.rid, hospital:'', h_date:'', dx:'', duration:'', attending:'', remarks:''
                    };
                    this.h.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updateHospitalization () {
            axios.patch(`Hospitalization/${this.hospitalization.id}`, this.hospitalization).then(
                response => {
                    // console.log(response.data);
                    this.hospitalization = {
                        patient_record_id: this.rid, hospital:'', h_date:'', dx:'', duration:'', attending:'', remarks:''
                    };
                    this.editable = false;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        createPastMedication () {
            axios.post(`PastMedication`, this.past_med).then(
                response => {
                    this.past_med = {
                        patient_record_id: this.rid, name:'', dose:'', frequency:'', duration:'', remarks:'',
                    };
                    this.pm.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updatePastMedication () {
            axios.patch(`PastMedication/${this.past_med.id}`, this.past_med).then(
                response => {
                    this.past_med = {
                        patient_record_id: this.rid, name:'', dose:'', frequency:'', duration:'', remarks:'',
                    };
                    this.editable.pm = false;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        createHfd () {
            axios.post(`/Patient/${this.pid}/HFD`, this.hfd).then(
                response => {
                    this.hfd = {
                        patient_id: this.pid, name: ''
                    };
                    this.hfds.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updateHfd () {
            axios.patch(`/Patient/${this.pid}/HFD/${this.hfd.id}`, this.hfd).then(
                response => {
                    this.hfd = {
                        patient_id: this.pid, name: ''
                    };
                    this.editable.hfds = false;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        createAllergy () {
            axios.post(`/Patient/${this.pid}/Allergy`, this.allergy).then(
                response => {
                    this.allergy = {
                        patient_id: this.pid, name: ''
                    };
                    this.a.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updateAllergy () {
            axios.patch(`/Patient/${this.pid}/Allergy/${this.allergy.id}`, this.allergy).then(
                response => {
                    this.allergy = {
                        patient_id: this.pid, name: ''
                    };
                    this.editable.a = false;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )

        },
        mydate (id) {
            this.hospitalization[id] = $(`#${id}`).val();
            // console.log(this.employee[id])
        }
    }
}
</script>