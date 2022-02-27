<template>
    <div class="container py-0">
        <schedule-dialog :dialog="dialog" :title="dt" :schedule="schedule" :selecteds="selecteds" :errors="errors"></schedule-dialog>
        <notif-component :d="notif" :dt="notif_title" :text="notif_text" :status="notif_status"></notif-component>
        <table class="table table-bordered table-inverse">
            <thead class="thead thead-dark thead-inverse">
                <tr>
                    <th>-</th>
                    <th colspan="4">
                        <div class="row m-0">
                            <div class="form-group col-sm-2 m-0 p-1">
                                <select class="custom-select" name="key" id="key" v-model="s_key">
                                    <option value="name">Name</option>
                                    <option value="job_pos">Job Position</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-10 m-0 p-1">
                                <input type="text" class="form-control" name="search" id="search" aria-describedby="helpId" placeholder="Search" v-model="search">
                            </div>
                        </div>
                    </th>
                    <th></th>
                    <th class="text-center">
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Create Schedule" @click="showDialog('New Week Schedule')"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i></button>
                    </th>
                </tr>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">
                        <input type="checkbox" name="checkall" id="checkall" class="form-sm-control" v-model="checkcontrol">
                    </th>
                    <th>Basic Info</th>
                    <th>Job Info</th>
                    <th>Employment Status</th>
                    <th>Weekly Schedule</th>
                    <th class="text-center"> <i class="fa fa-cog"></i> </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, key) in users" :key="key">
                    <td> {{key+1}} </td>
                    <td class="text-center">
                        <input type="checkbox" :name="'check'+user.id" :id="'check'+user.id" v-model="selecteds" :value="user.id" class="form-sm-control selections">
                    </td>
                    <td>
                        <div>{{user['lastname']}}, {{user['firstname']}} {{user['middlename']}} </div>
                        <div class="text-xs"> {{user['username']}} - {{user['user_level']['value']}} </div>
                    </td>
                    <td>
                        <div class=""> {{user['employee_id']}} </div>
                        <div class="text-xs"> {{(user['status'] != null) ? user['status']['value']:''}} - {{(user['position'] != null) ? user['position']['value']:''}} </div>
                    </td>
                    <td>
                        <div> {{['Employed','Resigned'][user['emp_status']]}} - {{user['hire_date']}} </div>
                        <div class="text-xs" v-if="user['reg_start']"> Regular </div>
                        <div class="text-xs" v-else-if="user['probi_start']">Probationary</div>
                        <div class="text-xs" v-else>Trainee</div>
                    </td>
                    <td>
                        <table class="table m-0">
                            <tbody>
                                <tr>
                                    <td v-for="day in user.latest_schedule" :key="day.id" class="cursor-default text-center text-xs font-semibold" :class="(day.shift_id == 0) ? 'bg-gray-500':'bg-green-400'" data-toggle="tooltip" data-placement="bottom" :title="days[day.day]">{{days[day.day].substr(0, 1)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <div class="actions d-flex justify-content-around">
                            <button type="button" v-if="user.schedules.length > 0" class="btn btn-warning text-xs" data-toggle="tooltip" data-placement="bottom" title="Modify Schedule" @click="editSchedule(user, 'Edit Schedule')"><i class="fa fa-calendar"></i></button>
                            <!-- <button class="btn btn-primary text-xs" data-toggle="tooltip" data-placement="bottom" title="View"><i class="fa fa-eye"></i></button> -->
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['items'],
    data () {
        return {
            s_key: 'name', search: null,
            checkcontrol: false,
            temp_users: this.items, users: this.items,
            selecteds: [],
            dialog: false, dt: '',
            schedule: {
                effectivitydate: '',
                sun: '', mon: '', tue: '', wed: '', th: '', fri: '', sat: '',
            },
            days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            errors: [],
            notif: false, notif_title: null, notif_text: null, notif_status: null,
        }
    },
    mounted () {
        this.users.forEach(element => {
            element.latest_schedule.sort((a, b) => {
                return a['day'] - b['day'];
            }) 
        });
    },
    watch: {
        checkcontrol (val) {
            // $('input:checkbox.selections').prop('checked', val);
            if (val == true) {
                this.selecteds = [];
                this.users.forEach(data => {
                    this.selecteds.push(data.id);
                });
            }else{
                if (this.selecteds.length == this.users.length) {
                    this.selecteds = [];
                }
            }
        },
        selecteds (val) {
            if (val.length != this.users.length) {
                this.checkcontrol = false;
            };
        },
        search (val) {
            var v = val.toLowerCase();
            this.users = this.temp_users.filter(data => {
                if (this.s_key == 'name') {
                    var name = `${data.firstname.toLowerCase()} ${data.middlename.toLowerCase()} ${data.lastname.toLowerCase()}`;
                    return name.match(v);
                }else if (this.s_key == 'job_pos') {
                    if (data.position !== null) {
                        var pos = data.position.value.toLowerCase();
                        return pos.match(v);
                    }
                }
            });
        }
    },
    methods: {
        editSchedule(user, title) {
            this.selecteds = [user.id];
            // this.schedule = user['schedules'];
            this.dialog = true; 
            this.dt = title;
        },
        showDialog (title) {
            if (this.selecteds.length > 0) {
                this.errors = [];
                this.dialog = true; 
                this.dt = title;
            }else{
                this.errors = [];
                this.notif = true;
                this.notif_title = "err";
                this.notif_text = "Select one or multiple emplyees to create a schedule.";
                this.notif_status = "001";
            }
        },
    }
}
</script>