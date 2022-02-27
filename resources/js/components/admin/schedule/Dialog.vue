<template>
    <v-dialog v-model="dialog" persistent>
        <v-card>
            <v-card-title v-if="dialog != undefined" class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text>
                <div class="row m-0">
                    <div v-if="title == 'Edit Schedule'" class="form-group col-sm-3 m-0">
                        <label for="selection">Schedule List:</label>
                        <select class="custom-select" name="selection" id="selection" v-model="effectivitydate">
                            <option v-for="(sched, key) in dates" :key="key" :value="key">{{sched}}</option>
                        </select>
                        <!-- <small id="helpId" v-if="errors['schedule.sun']" class="text-red-500">{{errors['schedule.sun']}}</small>
                                    <small id="helpId" v-if="errors.sun" class="text-red-500">{{errors.sun[0]}}</small> -->
                    </div>
                    <div class="form-group col-sm-3 m-0">
                        <label for="effectivitydate">Effectivity Date:</label>
                        <input type="text" name="effectivitydate" id="effectivitydate" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" data-provide="datepicker" aria-describedby="helpId" @blur="mydate('effectivitydate')" v-model="schedule.effectivitydate" :class="(errors['schedule.effectivitydate'] || errors.effectivitydate) ? 'is-invalid':''" :disabled="(title == 'Edit Schedule')">
                        <small id="helpId" v-if="errors['schedule.effectivitydate']" class="text-red-500">{{errors['schedule.effectivitydate'][0]}}</small>
                        <small id="helpId" v-if="errors.effectivitydate" class="text-red-500">{{errors.effectivitydate[0]}}</small>
                    </div>
                    <div class="form-group col-sm-3 m-0">
                        <label for="selection">Shift Provider:</label>
                        <select class="custom-select" name="selection" id="selection" v-model="shift_default">
                            <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                        </select>
                    </div>
                </div>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse thead-dark">
                        <tr>
                            <th>
                                <span>S</span><span class="d-none d-sm-inline-block">un</span><span class="d-none d-md-inline-block">day</span>
                            </th>
                            <th>
                                <span>M</span><span class="d-none d-sm-inline-block">on</span><span class="d-none d-md-inline-block">day</span>
                            </th>
                            <th>
                                <span>T</span><span class="d-none d-sm-inline-block">ues</span><span class="d-none d-md-inline-block">day</span>
                            </th>
                            <th>
                                <span>W</span><span class="d-none d-sm-inline-block">ed</span><span class="d-none d-md-inline-block">nesday</span>
                            </th>
                            <th>
                                <span>Th</span><span class="d-none d-sm-inline-block">ur</span><span class="d-none d-md-inline-block">sday</span>
                            </th>
                            <th>
                                <span>F</span><span class="d-none d-sm-inline-block">ri</span><span class="d-none d-md-inline-block">day</span>
                            </th>
                            <th>
                                <span>Sa</span><span class="d-none d-sm-inline-block">t</span><span class="d-none d-md-inline-block">urday</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="sunday" id="sunday" v-model="schedule.sun" :class="(errors['schedule.sun'] || errors.sun) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.sun']" class="text-red-500">{{errors['schedule.sun'][0]}}</small>
                                    <small id="helpId" v-if="errors.sun" class="text-red-500">{{errors.sun[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="monday" id="monday" v-model="schedule.mon" :class="(errors['schedule.mon'] || errors.mon) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.mon']" class="text-red-500">{{errors['schedule.mon'][0]}}</small>
                                    <small id="helpId" v-if="errors.mon" class="text-red-500">{{errors.mon[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="tuesday" id="tuesday" v-model="schedule.tue" :class="(errors['schedule.tue'] || errors.tue) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.tue']" class="text-red-500">{{errors['schedule.tue'][0]}}</small>
                                    <small id="helpId" v-if="errors.tue" class="text-red-500">{{errors.tue[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="wednesday" id="wednesday" v-model="schedule.wed" :class="(errors['schedule.wed'] || errors.wed) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.wed']" class="text-red-500">{{errors['schedule.wed'][0]}}</small>
                                    <small id="helpId" v-if="errors.wed" class="text-red-500">{{errors.wed[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="thursday" id="thursday" v-model="schedule.th" :class="(errors['schedule.th'] || errors.th) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.th']" class="text-red-500">{{errors['schedule.th'][0]}}</small>
                                    <small id="helpId" v-if="errors.th" class="text-red-500">{{errors.th[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="friday" id="friday" v-model="schedule.fri" :class="(errors['schedule.fri'] || errors.fri) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.fri']" class="text-red-500">{{errors['schedule.fri'][0]}}</small>
                                    <small id="helpId" v-if="errors.fri" class="text-red-500">{{errors.fri[0]}}</small>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="custom-select" name="saturday" id="saturday" v-model="schedule.sat" :class="(errors['schedule.sat'] || errors.sat) ? 'is-invalid':''">
                                        <option v-for="shift in shifts" :key="shift.id" :value="shift.id">{{shift.code}}</option>
                                    </select>
                                    <small id="helpId" v-if="errors['schedule.sat']" class="text-red-500">{{errors['schedule.sat'][0]}}</small>
                                    <small id="helpId" v-if="errors.sat" class="text-red-500">{{errors.sat[0]}}</small>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </v-card-text>
            <v-card-actions class="d-flex justify-content-center">
                <button type="button" v-if="title == 'Edit Schedule'" class="btn btn-primary" @click="updateSchedule">
                    <div v-if="saving" class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-else>
                        <i class="fas fa-save"></i> Save
                    </span>
                </button>
                <button type="button" v-else class="btn btn-primary" @click="createSchedule">
                    <div v-if="saving" class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-else>
                        <i class="fas fa-save"></i> Save
                    </span>
                </button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'title', 'schedule', 'selecteds', 'errors'],
    data () {
        return {
            shifts: [], shift_default: null,
            dates: [], schedules: [], effectivitydate: null, saving: false,
        }
    },
    watch: {
        shift_default () {
            this.$parent.schedule.sun = this.shift_default;
            this.$parent.schedule.mon = this.shift_default;
            this.$parent.schedule.tue = this.shift_default;
            this.$parent.schedule.wed = this.shift_default;
            this.$parent.schedule.th = this.shift_default;
            this.$parent.schedule.fri = this.shift_default;
            this.$parent.schedule.sat = this.shift_default;
        },
        dialog () {
            if(this.dialog == true && this.title == "Edit Schedule"){
                this.getUserSchedules();
            }
        },
        effectivitydate (val) {
            if (val == null) {
                this.$parent.schedule = {
                    effectivitydate: '',
                    sun: '', mon: '', tue: '', wed: '', th: '', fri: '', sat: '',
                };
            }else{
                this.$parent.schedule = this.schedules[val];
            }
        }
    },
    mounted () {
        if (this.dialog == undefined) {
            this.getUserSchedules();
        }
        axios.get(`/Shift/list`).then(response => {
            this.shifts = response.data;
        });
    },
    methods: {
        getUserSchedules () {
            var user_id = this.selecteds[0];
            axios.get(`/Schedule/getUserSchedule/${user_id}`).then(response => {
                this.dates = response.data[0];
                this.schedules = response.data[1];
            });
        },
        createSchedule () {
            var data = {
                selecteds: this.selecteds,
                schedule: this.schedule
            };
            this.saving = true;
            axios.post(`/Schedule`, data).then(response => {
                location.href = "/Schedule";
            }).catch(errors => {
                this.saving = false;
                this.errors = errors.response.data.errors;
            })
        },
        updateSchedule () {
            this.saving = true;
            axios.patch(`/Schedule/${this.schedule.user_id}`, this.schedule).then(response => {
                var resp = response.data;
                this.$parent.selecteds = [];
                this.processDtr(resp);

                this.saving = false;
                this.$parent.dialog = false;
            }).catch(errors => {
                this.saving = false;
                this.errors = errors.response.data.errors;
            })
        },
        processDtr (data) {
            var edate = data.effectivitydate;
            var filtered = data.day.find(data => data == true);

            if (edate || filtered) {
                this.$parent.notif = true;
                this.$parent.notif_title = "wait";
                this.$parent.notif_text = "There have been some changes on this Employee's schedule. We're now going to process Daily Time Record. Please wait.";
                this.$parent.notif_status = "";
                data['boundarydate'] = this.dates[this.effectivitydate - 1];
                data['effectivitydate'] = this.dates[this.effectivitydate];
                this.effectivitydate = null;
                
                axios.patch(`/DTR/${this.schedule.user_id}`, data).then(response => {
                    // console.log(response.data)
                    this.$parent.notif = false;
                });
            }
        },
        mydate (id) {
            this.schedule[id] = $(`#${id}`).val();
            // console.log(this.employee[id])
        }
    }
}
</script>