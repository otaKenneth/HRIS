<template>
    <v-dialog v-model="dialog" width="30vw" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text>
                <div class="row m-0">
                    <div class="form-group col-md-12 m-0 pt-2 pb-0">
                        <label for="employee">Employee</label>
                        <select class="custom-select" name="employee" id="employee" v-model="override.user_id" :disabled="override.disabled" :class="errors.user_id ? 'is-invalid':''">
                            <option value="0" selected>Select One</option>
                            <option v-for="emp in employees" :key="emp.id" :value="emp.id">{{emp.name}}</option>
                        </select>
                        <small v-if="errors.user_id" id="helpId" class="text-red-500 text-xs">Please select an Employee</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0">
                        <label for="date">Date</label>
                        <input type="text" name="date" id="date" class="form-control datepicker" data-date-format="mm/dd/yyyy" data-provide="datepicker" data-date-end-date="0d" placeholder="mm/dd/yyyy" aria-describedby="helpId" v-model="override.date" @blur="mydate('date')" :class="errors.date ? 'is-invalid':''">
                        <small v-if="errors.date" id="helpId" class="text-red-500 text-xs">{{errors.date[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0">
                        <label for="override">Override</label>
                        <select class="form-control" name="" id="" v-model="override_select" :class="errors.override ? 'is-invalid':''">
                            <option v-for="(opt, key) in oride_opt" :key="key" :value="key">{{opt}}</option>
                        </select>
                        <small v-if="errors.override" class="text-red-500 text-xs">{{errors.override[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0" v-if="['all','in','inout'].find(data => data == override_select)">
                        <label for="in">In</label>
                        <input type="time" class="form-control" name="in" id="in" aria-describedby="helpId" placeholder="hh:mm" v-model="override.in" :class="errors.in ? 'is-invalid':''">
                        <small v-if="errors.in" id="helpId" class="text-red-500 text-xs">{{errors.in[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0" v-if="['all','breakOut','breaks'].find(data => data == override_select)">
                        <label for="breakOut">Break-Out</label>
                        <input type="time" class="form-control" name="breakOut" id="breakOut" aria-describedby="helpId" placeholder="hh:mm" v-model="override.breakOut" :class="errors.breakOut ? 'is-invalid':''">
                        <small v-if="errors.breakOut" id="helpId" class="text-red-500 text-xs">{{errors.breakOut[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0" v-if="['all','breakIn','breaks'].find(data => data == override_select)">
                        <label for="breakIn">Break-In</label>
                        <input type="time" class="form-control" name="breakIn" id="breakIn" aria-describedby="helpId" placeholder="hh:mm" v-model="override.breakIn" :class="errors.breakIn ? 'is-invalid':''">
                        <small v-if="errors.breakIn" id="helpId" class="text-red-500 text-xs">{{errors.breakIn[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0 pt-2 pb-0" v-if="['all','out','inout'].find(data => data == override_select)">
                        <label for="out">Out</label>
                        <input type="time" class="form-control" name="out" id="out" aria-describedby="helpId" placeholder="hh:mm" v-model="override.out" :class="errors.out ? 'is-invalid':''">
                        <small v-if="errors.out" id="helpId" class="text-red-500 text-xs">{{errors.out[0]}}</small>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <button type="button" v-if="title == 'New Override'" class="btn btn-primary" @click="createOverride"><i class="fas fa-save"></i> Save</button>
                <button type="button" v-else class="btn btn-primary" @click="updateOverride"><i class="fas fa-save"></i> Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'title', 'employees', 'override'],
    data () {
        return {
            oride_opt: {
                all:'All',
                inout: 'In-Out',
                breaks: 'Breaks',
                in: 'In',
                out: 'Out',
                breakOut: 'Break-Out',
                breakIn: 'Break-In'
            },
            override_select: this.override.override,
            errors: [],
        }
    },
    watch: {
        override_select () {
            this.$parent.override.in = null;
            this.$parent.override.breakOut = null;
            this.$parent.override.breakIn = null;
            this.$parent.override.out = null;
        }
    },
    methods: {
        mydate (id) {
            this.override[id] = $(`#${id}`).val();
        },
        createOverride () {
            this.$parent.override.override = this.override_select;
            axios.post(`/Override`, this.override).then(response => {
                location.href = "";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        },
        updateOverride () {
            this.$parent.override.override = this.override_select;
            axios.patch(`/Override/${this.override.id}`, this.override).then(response => {
                location.href = "";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        }
    }
}
</script>