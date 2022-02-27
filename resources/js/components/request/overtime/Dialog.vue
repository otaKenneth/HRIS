<template>
    <v-dialog v-model="dialog" width="30vw" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text>
                <div class="form-group row m-0">
                    <div class="form-group col-md-6 m-0">
                        <label for="emp">Employee</label>
                        <select class="custom-select form-control" name="emp" id="emp" v-model="overtime.user_id" :class="(errors.user_id) ? 'is-invalid':''" :disabled="overtime.disabled">
                            <option value="0">Select one</option>
                            <option v-for="(emp, key) in employees" :key="key" :value="emp.id">
                                {{emp.name}}
                            </option>
                        </select>
                        <small id="helpId" class="text-red-500 text-xs" v-if="errors.user_id">{{errors.user_id[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0">
                        <label for="date">Date</label>
                        <input type="text" name="date" id="date" class="form-control datepicker" data-date-format="mm/dd/yyyy" data-provide="datepicker" data-date-end-date="0d" placeholder="mm/dd/yyyy" aria-describedby="helpId" v-model="overtime.date" @blur="mydate('date')" :class="(errors.date) ? 'is-invalid':''">
                        <small id="helpId" class="text-red-500 text-xs" v-if="errors.date">{{errors.date[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0">
                        <label for="in">In</label>
                        <input type="time" class="form-control" name="in" id="in" aria-describedby="helpId" placeholder="hh:mm" v-model="overtime.in" :class="(errors.in) ? 'is-invalid':''">
                        <small id="helpId" class="form-text text-red-500 text-xs" v-if="errors.in">{{errors.in[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0">
                        <label for="out">Out</label>
                        <input type="time" class="form-control" name="out" id="out" aria-describedby="helpId" placeholder="hh:mm" v-model="overtime.out" :class="(errors.out) ? 'is-invalid':''">
                        <small id="helpId" class="form-text text-red-500 text-xs" v-if="errors.out">{{errors.out[0]}}</small>
                    </div>
                    <div class="form-group col-md-12 m-0">
                        <label for="reason">Reason</label>
                        <input type="text" class="form-control" name="reason" id="reason" aria-describedby="helpId" placeholder="Aa..." v-model="overtime.reason" :class="(errors.reason) ? 'is-invalid':''">
                        <small id="helpId" class="form-text text-red-500 text-xs" v-if="errors.reason">{{errors.reason[0]}}</small>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="justify-content-center">
                <button type="button" v-if="title == 'New Overtime'" class="btn btn-primary" @click="createOvertime"><i class="fas fa-save"></i> Save</button>
                <button type="button" v-else class="btn btn-primary" @click="updateOvertime"><i class="fas fa-save"></i> Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'overtime', 'employees', 'title'],
    data () {
        return {
            errors: [],
        }
    },
    methods: {
        mydate (id) {
            this.overtime[id] = $(`#${id}`).val();
        },
        createOvertime () {
            axios.post(`/Overtime`, this.overtime).then(response => {
                location.href = "/Overtime";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        },
        updateOvertime () {
            axios.patch(`/Overtime/${this.overtime.id}`, this.overtime).then(response => {
                location.href = "/Overtime";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        }
    }
}
</script>