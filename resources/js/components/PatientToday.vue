<template>
    <div class="">
        <new-patient :d1="dialog" :o="lkups"></new-patient>
        <lookup-cog-dialog :d="cog_dialog" :dt="dialog_title" :errs="errors" :dk="d_key"></lookup-cog-dialog>
        <table class="table table-striped table-bordered table-inverse">
            <thead class="thead-dark thead-inverse">
                <tr>
                    <th colspan="3">
                        <input type="text" class="form-control form-control" name="search" id="search" aria-describedby="search" placeholder="Search patient name" v-model="search" autofocus>
                    </th>
                    <th>
                        <div class="d-flex justify-content-end">
                            <!-- <button class="btn btn-success text-sm mr-2" @click="dialog = true"> <i class="fa fa-file-medical" aria-hidden="true"></i> </button> -->
                            <button class="btn btn-primary text-sm" @click="dialog = true"> <i class="fa fa-user-plus" aria-hidden="true"></i> </button>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(p, k) in patients" :key="k">
                    <td scope="row"> {{k+1}} </td>
                    <td> {{p.patient.firstname}} {{p.patient.middlename}} {{p.patient.lastname}} </td>
                    <td> Php {{p.payment}} </td>
                    <td>
                        <div v-if="!userlvl" class="row">
                            <label for="payment" class="col-sm-6 m-0">{{(p.payed == 0) ? '-':p.payed}}</label>
                            <v-switch id="payment" class="col-sm-6 m-0" v-if="p.payment" inset v-model="p.payed" true-value="Payed" false-value="-"></v-switch>
                        </div>
                        <a :href="'Patient/'+p.patient.id+'/Edit'" v-else class="btn btn-primary"><i class="fa fa-arrow-circle-right text-light" aria-hidden="true"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props:['userlvl'],
    data () {
        return {
            dialog: false, lkups: [], record_dialog: false, 
            patient: {
                id: null, firstname: null, middlename: null, lastname: null,
            },
            cog_dialog: false, dialog_title: '', d_key: '',
            errors: [], patients: [], search: '', temp_p: [],
        }
    },
    mounted () {
        this.fetchPatients();
        
        window.channel.bind('my-event', (data) => {
            if (data) this.fetchPatients();
        });
    },
    watch: {
        dialog (val) {
            if (!val) this.fetchPatients();
        },
        search (val) {
            val = val.toLowerCase();
            this.patients = this.temp_p.filter( (data) => {
                var name = (`${data.patient.firstname} ${data.patient.middlename} ${data.patient.lastname}`).toLowerCase();
                return name.match(val);
            });
        }
    },
    methods: {
        fetchPatients () {
            axios.get('getPatientsAtDate').then(response => {
                this.patients = response.data;
                this.temp_p = response.data;
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        }
    }
}
</script>