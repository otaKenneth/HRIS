<template>
    <v-dialog v-model="dialog" width="35vw" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text>
                <div class="form-group row m-0">
                    <div class="text-dark col-12">
                        <div>{{employee}}</div>
                        <div class="text-xs text-blue-400">{{notif}}</div>
                    </div>
                    <div class="form-group col-md-5 col-12 m-0">
                        <label for="tndp">Total # Of Days Paid</label>
                        <select class="form-control" name="tndp" id="tndp" v-model="salary.tndp" :class="errors.tndp ? 'is-invalid':''" @change="setNotif">
                            <option value="261">261</option>
                            <option value="313">313</option>
                            <option value="365">365</option>
                            <option value="392.5">392.5</option>
                        </select>
                        <small id="helpId" v-if="errors.salary_type" class="text-red-500 text-xs">{{errors.salary_type[0]}}</small>
                    </div>
                    <div class="form-group col-md-4 col-12 m-0">
                        <label for="type">Salary Type</label>
                        <select class="form-control" name="type" id="type" v-model="salary.salary_type" :class="errors.salary_type ? 'is-invalid':''">
                            <option value="monthly">Monthly</option>
                            <option value="daily">Daily</option>
                        </select>
                        <small id="helpId" v-if="errors.salary_type" class="text-red-500 text-xs">{{errors.salary_type[0]}}</small>
                    </div>
                    <div class="form-group col-md-3 col-12 m-0">
                        <label for="wdw">Work dys/wk</label>
                        <input type="number" name="weekly_work_days" id="wdw" class="form-control" v-model="salary.weekly_work_days" :class="(errors.weekly_work_days ? 'is-invalid':'')" onkeypress="return (event.key >= '0' && event.key <= '7')" min="0" max="7" maxlength="1">
                        <small id="helpId" v-if="errors.weekly_work_days" class="text-red-500 text-xs">{{errors.weekly_work_days[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 col-12 m-0">
                        <label for="monthly">Monthly Basic</label>
                        <input type="text" name="monthly" id="monthly" class="form-control" placeholder="" aria-describedby="helpId" onkeypress="return (event.key >= '0' && event.key <= '9') || event.key == '.'" v-model="salary.monthly" :class="errors.monthly ? 'is-invalid':''">
                        <small id="helpId" v-if="errors.monthly" class="text-red-500 text-xs">{{errors.monthly[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 col-12 m-0">
                        <label for="increase">Increase</label>
                        <input type="text" name="increase" id="increase" class="form-control" placeholder="" aria-describedby="helpId" onkeypress="return (event.key >= '0' && event.key <= '9') || event.key == '.'" v-model="salary.increase" :class="errors.increase ? 'is-invalid':''">
                        <small id="helpId" v-if="errors.increase" class="text-red-500 text-xs">{{errors.increase[0]}}</small>
                    </div>
                </div>
                <div class="from-group row m-0">
                    <div class="form-group col-md-6 col-12 m-0">
                        <label for="type">Allowace Type</label>
                        <select class="form-control" name="type" id="type" v-model="salary.allowance_type" :class="errors.allowance_type ? 'is-invalid':''">
                            <option value="daily">Daily</option>
                            <option value="f&t">Food & Travel</option>
                        </select>
                        <small id="helpId" v-if="errors.allowance_type" class="text-red-500 text-xs">{{errors.allowance_type[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 col-12 m-0">
                        <label for="allowance">Allowance</label>
                        <input type="text" name="allowance" id="allowance" class="form-control" placeholder="" aria-describedby="helpId" onkeypress="return (event.key >= '0' && event.key <= '9') || event.key == '.'" v-model="salary.allowance" :class="errors.allowance ? 'is-invalid':''">
                        <small id="helpId" v-if="errors.allowance" class="text-red-500 text-xs">{{errors.allowance[0]}}</small>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="justify-center">
                <button type="button" v-if="!salary.id" class="btn btn-primary" @click="createSalary">
                    <div v-if="saving" class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-else><i class="fas fa-save"></i> Save</span>
                </button>
                <button type="button" v-else class="btn btn-primary" @click="updateSalary">
                    <div v-if="saving" class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-else><i class="fas fa-save"></i> Save</span>
                </button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'salary', 'title', 'employee'],
    data () {
        return {
            errors: [], notif: null, saving: false,
        }
    },
    mounted () {
        this.setNotif();
    },
    methods: {
        setNotif () {
            if (this.salary.tndp == 261) {
                this.notif = "Doesn't work and not considered paid on Saturdays and Sundays or rest days:";
            }else if (this.salary.tndp == 313) {
                this.notif = "Doesn't work and not considered paid on Sundays or rest days:";
            }else if (this.salary.tndp == 365) {
                this.notif = "Doesn't work and but considered paid on rest days, special and regular holidays:";
            }else if (this.salary.tndp == 392.5) {
                this.notif = "Required to work everyday including Saturdays and Sundays or rest days, special and regular holidays:";
            }
        },
        createSalary () {
            this.saving = true;
            axios.post(`Salary`, this.salary).then(response => {
                // console.log(response);
                location.href = '/Salary';
                this.saving = false;
            }).catch(errors => {
                this.errors = errors.response.data.errors;
                this.saving = false;
            });
        },
        updateSalary () {
            this.saving = true;
            axios.patch(`Salary/${this.salary.id}`, this.salary).then(response => {
                // console.log(response);
                location.href = '/Salary';
                this.saving = false;
            }).catch(errors => {
                this.errors = errors.response.data.errors;
                this.saving = false;
            });
            
        }
    }
}
</script>