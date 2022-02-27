<template>
    <v-dialog v-model="dialog" width="50vw" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text style="height: auto; max-height: 70vh; overflow: auto" class="py-0">
                <div class="row">
                    <div class="form-group row col-6 m-0">
                        <div class="form-group">
                            <label for="emp">Employee</label>
                            <select class="custom-select form-control" name="emp" id="emp" v-model="leave.user_id" @change="empChanged" :disabled="leave.disabled">
                                <option value="0">Select one</option>
                                <option v-for="(emp, key) in employees" :key="key" :value="emp.id">
                                    {{emp.name}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 m-0">
                            <label for="from">From</label>
                            <input type="text" name="from" id="from" class="form-control date-picker" placeholder="mm/dd/yyyy"  data-date-format="mm/dd/yyyy" data-provide="datepicker" aria-describedby="helpId" @blur="mydate('from')" v-model="leave.from" :class="errors['leave.from'] ? 'is-invalid':''">
                            <small id="helpId" v-if="errors['leave.from']" class="text-red-500">{{errors['leave.from'][0]}}</small>
                        </div>
                        <div class="form-group col-md-6 m-0">
                            <label for="to">To</label>
                            <input type="text" name="to" id="to" class="form-control date-picker" placeholder="mm/dd/yyyy"  data-date-format="mm/dd/yyyy" data-provide="datepicker" aria-describedby="helpId" @blur="mydate('to')" v-model="leave.to" :class="errors['leave.to'] ? 'is-invalid':''">
                            <small id="helpId" v-if="errors['leave.to']" class="text-red-500">{{errors['leave.to'][0]}}</small>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Type</label>
                            <select class="form-control" name="type" id="type" v-model="leave.type" :class="errors['leave.type'] ? 'is-invalid':''">
                                <option value="SL">Sick Leave</option>
                                <option value="VL">Vacation Leave</option>
                            </select>
                            <small id="helpId" v-if="errors['leave.type']" class="text-red-500">{{errors['leave.type'][0]}}</small>
                        </div>
                        <div class="form-group col-md-6 m-0">
                            <label for="reason">Reason</label>
                            <input type="text" name="reason" id="reason" class="form-control" placeholder="Aa..." aria-describedby="helpId" v-model="leave.reason" :class="errors['leave.reason'] ? 'is-invalid':''">
                            <small id="helpId" v-if="errors['leave.reason']" class="text-red-500">{{errors['leave.reason'][0]}}</small>
                        </div>
                    </div>
                    <div class="form-group row col-6 m-0" style="height: 340px; overflow:auto;">
                        <table id="dateRange" class="table table-striped table-inverse">
                            <thead class="thead-inverse thead-dark">
                                <tr v-if="reverted">
                                    <th colspan="3"><span class="text-red-500">Date Range has been <b>Reverted</b></span></th>
                                </tr>
                                <tr>
                                    <th colspan=2><span class="text-red-500">{{leave.type}} credits left:</span></th>
                                    <th v-if="loading">
                                        <div class="spinner-border text-info" role="status" style="width: 15px; height: 15px;">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </th>
                                    <th v-else>{{credits[leave.type] - payed.length}}</th>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th class="text-center">Payment <input type="checkbox" name="" id="payment" v-model="checkAllPayment"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(mdate, key) in dateRange" :key="key">
                                    <td>{{mdate.date}}</td>
                                    <td>{{mdate.day}}</td>
                                    <td class="text-center">
                                        <input type="checkbox" class="payment" :id="'mdate'+key" v-model="payed" :value="mdate.date" :disabled="(credits[leave.type] == 0)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="d-flex justify-content-center">
                <button type="button" class="btn btn-primary" v-if="title == 'Edit Leave'" @click="updateLeave"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-primary" v-else @click="createLeave"><i class="fas fa-save"></i> Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<style>
table#dateRange thead tr:nth-child(1) th {
    position: sticky;
    top: 0px;
}
table#dateRange thead tr:nth-child(2) th {
    position: sticky;
    top: 45px;
}
</style>
<script>
export default {
    props: ['dialog', 'title', 'leave', 'dateRange', 'employees'],
    data () {
        return {
            errors: [],
            emps: [],
            credits: {
                SL: 0, VL: 0,
            },
            loading: false,
            reverted: false,
            payed: [],
            checkAllPayment: false,
        }
    },
    watch: {
        payed (val) {
            if (this.credits[this.leave.type] == val.length) {
                $('input:checkbox.payment:not(:checked)').prop('disabled', true);
            }else{
                $('input:checkbox.payment').prop('disabled', false);
            }
        },
        checkAllPayment (val) {
            if (val) {
                this.dateRange.forEach((element, key) => {
                    if (!this.payed.find(data => data == element.date) && this.credits[this.leave.type] > this.payed.length) {
                        this.payed = [...this.payed, element.date];
                        $(`input:checkbox#mdate${key}.payment`).prop('checked', true);
                    }
                });
            }else{
                if (this.payed.length == this.credits[this.leave.type] || this.payed.length == this.dateRange.length) {
                    this.payed = [];
                }
            }
        }
    },
    mounted () {
        if (this.title == "Edit Leave") {
            this.dateRange.forEach(element => {
                if (element.pay) this.payed = [...this.payed, element.date];
            });

            if (this.payed.length == this.credits[this.leave.type] || this.payed.length == this.dateRange.length) {
                this.checkAllPayment = true;
            }
        }

        if (this.leave.user_id > 0) {
            this.empChanged();
        }
    },
    methods: {
        mydate (id) {
            this.leave[id] = $(`#${id}`).val();
            var to = $('#to').val();
            if (id == 'from' && (this.leave.to == null || this.leave.to == "")) {
                this.leave['to'] = $(`#${id}`).val();
            }

            if(id == 'from' || id == 'to') this.updateRange();
        },
        empChanged () {
            this.loading = true;
            axios.get(`/Employee/${this.leave.user_id}/getLeaveCredits`).then(response => {
                this.credits = response.data;
                this.loading = false;
            });
        },
        updateRange () {
            var daysArr = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            var s = new Date(this.leave.from), e = new Date(this.leave.to), dates = [], d,m,y;
            while (s <= e) {
                d = s.getDate(); m = s.getMonth()+1; y = s.getFullYear();
                var temp = {
                    day: daysArr[s.getDay()],
                    date: `${m}/${d}/${y}`,
                    pay: false
                };
                dates = [...dates,temp];
                s.setDate(s.getDate() + 1);
            }

            this.payed = [];
            this.checkAllPayment = false;
            this.reverted = (this.title == 'Edit Leave' && this.dateRange.length == 0) ? false:true;
            this.$parent.dateRange = dates;
        },
        createLeave () {
            var data = {
                payed: this.payed,
                credits_left: this.credits[this.leave.type],
                leave: this.leave,
                dateRange: this.dateRange,
            };
            axios.post('/Leave', data).then(response => {
                location.href = "";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            })
        },
        updateLeave () {
            var data = {
                payed: this.payed,
                credits_left: this.credits[this.leave.type],
                leave: this.leave,
                dateRange: this.dateRange,
            };
            axios.patch(`/Leave/${this.leave.id}`, data).then(response => {
                location.href = "";
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            })
        }
    }
}
</script>