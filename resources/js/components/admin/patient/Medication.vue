<template>
    <div class="container-fluid">
        <div class="form-group">
            <span class="font-semibold">Medication</span>
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
                                    <input type="text" name="drug_name" id="drug_name" class="form-control" placeholder="Aa..." :class="(errors.drug_name) ? 'is-invalid':''" v-model="medication.name">
                                    <span v-if="errors.drug_name" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.drug_name[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="dose" id="dose" class="form-control" placeholder="Aa..." :class="(errors.dose) ? 'is-invalid':''" v-model="medication.dose">
                                    <span v-if="errors.dose" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.dose[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="frequency" id="frequency" class="form-control" placeholder="Aa..." :class="(errors.frequency) ? 'is-invalid':''" v-model="medication.frequency">
                                    <span v-if="errors.frequency" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.frequency[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="pm_duration" id="pm_duration" class="form-control" placeholder="Aa..." :class="(errors.pm_duration) ? 'is-invalid':''" v-model="medication.duration">
                                    <span v-if="errors.pm_duration" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.pm_duration[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="form-group m-0">
                                    <input type="text" name="pm_remarks" id="pm_remarks" class="form-control" placeholder="Aa..." :class="(errors.pm_remarks) ? 'is-invalid':''" v-model="medication.remarks">
                                    <span v-if="errors.pm_remarks" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.pm_remarks[0] }}</strong>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button type="button" v-if="!editable" class="btn btn-primary" @click="createMedication"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                <button type="button" v-else class="btn btn-primary" @click="updateMedication"><i class="fas fa-save" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <tr v-for="(meds, k) in m" :key="k">
                            <td> {{k+1}} </td>
                            <td> {{meds.name}} </td>
                            <td> {{meds.dose}} </td>
                            <td> {{meds.frequency}} </td>
                            <td> {{meds.duration}} </td>
                            <td> {{meds.remarks}} </td>
                            <td>
                                <button type="button" class="btn btn-warning" @click="medication = meds; editable = true;"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div class="form-group row">
            <div class="form-group col-md-6">
                <label for="payment">Payment</label>
                <div class="d-flex">
                    <button type="button" class="btn">Php</button>
                    <input type="text" class="form-control" name="payment" id="payment" aria-describedby="helpId" placeholder="00.00" v-model="record.payment">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="next_visit">Next Visit</label>
                <input type="text" name="next_visit" id="next_visit" class="form-control datepicker" data-date-format="mm/dd/yyyy" data-provide="datepicker" placeholder="mm/dd/yyyy" @blur="mydate('next_visit')" :class="(errors.next_visit) ? 'is-invalid':''" v-model="record.next_visit">
            </div>
        </div>
        <div class="form-group">
          <label for="note">Note/Comment</label>
          <textarea name="note" id="note" cols="30" rows="3" class="form-control col-md-12" placeholder="Aa..." v-model="record.note"></textarea>
        </div>
    </div>
</template>
<script>
export default {
    props: ['record','m'],
    data () {
        return {
            editable: false,
            medication: {
                patient_record_id: this.record.id, name:'', dose: '', duration: '', frequency: '', remarks: ''
            },
            errors: [],
        }
    },
    methods: {
        createMedication () {
            axios.post(`Medication`, this.medication).then(
                response => {
                    this.medication = {
                        patient_record_id: this.record.id, name:'', dose: '', duration: '', frequency: '', remarks: ''
                    };
                    this.m.push(response.data);
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        updateMedication () {
            axios.patch(`Medication/${this.medication.id}`, this.medication).then(
                response => {
                    this.medication = {
                        patient_record_id: this.record.id, name:'', dose: '', duration: '', frequency: '', remarks: ''
                    };
                    this.editable = false;
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        mydate(id) {
            this.record[id] = $(`#${id}`).val();
        }
    }
}
</script>