<template>
    <v-dialog v-model="dialog" width="600px" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between headline">
                <h2> New Patient </h2>
                <!-- <button type="button" class="btn btn-link"><i class="fa fa-times"></i></button> -->
            </v-card-title>

            <v-card-text class="pb-0">
                <div class="d-flex">
                    <div class="form-group m-0">
                        <span class="font-semibold">Patient Name</span>
                        <div class="d-flex">
                            <div class="form-group col-md-4">
                                <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" v-model="patient.firstname">
                                <span v-if="errors.firstname" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.firstname[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="mname" id="mname" class="form-control" placeholder="Middle Name" v-model="patient.middlename">
                                <span v-if="errors.middlename" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.middlename[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" v-model="patient.lastname">
                                <span v-if="errors.lastname" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.lastname[0] }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group m-0">
                        <span class="font-semibold">Other Info</span>
                        <div class="d-flex">
                            <div class="form-group col-md-4">
                                <input type="text" name="age" id="age" class="form-control" placeholder="Age" onkeypress="return (event.key >= '0' && event.key <= '9')" v-model="patient.age">
                                <span v-if="errors.age" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.age[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" data-provide="datepicker" v-model="patient.birthdate" @blur="mydate('birthdate')" :class="(errors.birthdate) ? 'is-invalid':''" autocomplete="off">
                                <span v-if="errors.birthdate" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.birthdate[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="d-flex">
                                    <select class="form-control" name="gender" id="gender" v-model="patient.gender">
                                        <option value="0">Gender</option>
                                        <option v-for="v in lkups.gender" :key="v.id" :value="v.id">{{v.value}}</option>
                                    </select>
                                    <button class="btn" @click="$parent.cog_dialog = true; $parent.dialog_title = 'Gender'; $parent.d_key = 'gender'"><i class="fa fa-cog"></i></button>
                                </div>
                                <span v-if="errors.gender" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.gender[0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-group col-md-4">
                                <input type="email" name="email" id="email" class="form-control" placeholder="test@test.com" v-model="patient.email">
                                <span v-if="errors.email" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.email[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="pnum" id="pnum" class="form-control" placeholder="Phone Number" onkeypress="return (event.key >= '0') && (event.key <= '9')" maxlength="11" v-model="patient.pnum">
                                <span v-if="errors.pnum" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.pnum[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="d-flex">
                                    <input type="text" name="weight" id="weight" class="form-control" placeholder="Weigth" onkeypress="return (event.key >= '0') && (event.key <= '9')" maxlength="11" v-model="weight">
                                    <span class="btn">kg</span>
                                </div>
                                <span v-if="errors.weight" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.weight[0] }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="form-group m-0">
                        <span class="font-semibold">Address</span>
                        <div class="d-flex">
                            <div class="form-group col-md-3 px-1">
                                <input type="text" name="address" id="address" class="form-control" v-model="patient.address" placeholder="Address">
                                <span v-if="errors.address" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.address[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3 px-1">
                                <select class="form-control" name="town" id="town" v-model="patient.town">
                                    <option v-for="(city, key) in temp_cities" :key="key" :value="key">{{city.name}}</option>
                                </select>
                                <span v-if="errors.town" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.town[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3 px-1">
                                <select class="form-control" name="province" id="province" v-model="prov_key">
                                    <option v-for="(province, key) in provinces" :key="key" :value="key">{{province.name}}</option>
                                </select>
                                <span v-if="errors.province" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.province[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3 px-1">
                                <input type="text" name="country" v-model="patient.country" id="country" class="form-control" placeholder="Country" disabled>
                                <span v-if="errors.country" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.country[0] }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </v-card-text>

            <v-card-actions class="d-flex justify-content-around">
                <button class="btn btn-danger mr-2" @click="close"><i class="fa fa-times"></i>&nbsp;Cancel</button>
                <button class="btn btn-primary" @click="createPatient"><i class="fa fa-save"></i>&nbsp;Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['d1','o'],
    data () {
        return {
            lkups: this.o,
            patient: {
                firstname: '', middlename: '', lastname: '', age: '', birthdate: '', gender: 0, email: '', pnum: '',
                address: '', town: '', province: '', country: 'Philippines' 
            },
            weight: '',
            temp_cities: [],
            provinces: this.$root.ph_provinces,
            prov_key: null,
            errors: [],
        }
    },
    computed: {
        dialog () {
            return this.d1;
        }
    },
    watch:{
        prov_key (value) {
            if (value != null) {
                this.patient.province = value;
                this.temp_cities = (this.$root.ph_cities).filter(data => data.province == this.provinces[value].key);
            }
        }
    },
    mounted () {
        this.prov_key = 18;

        axios.get('/Lookup/prettylookups').then(
            response => {
                this.lkups = response.data;
            }
        ).catch(
            errors => {
                this.errors = errors.response.data.errors;
            }
        );
    },
    methods: {
        close () {
            this.$parent.dialog = false;
        },
        createPatient () {
            axios.post('/Patient/CreateFromDashboard', this.patient).then(
                response => {
                    var id = response.data.id;
                    axios.post(`Patient/${id}/Record`, {patient_id: id, weight: this.weight}).then(
                        response => {
                            this.patient = {
                                firstname: '', middlename: '', lastname: '', age: '', birthdate: '', gender: 0, email: '', pnum: '',
                                address: '', town: '', province: '', country: 'Philippines' 
                            };
                            this.prov_key = 18;
                            this.width = null;
                            this.close();
                        }
                    ).catch(
                        errors => {
                            this.errors = errors.response.data.errors;
                        }
                    )
                }
            ).catch(
                errors => {
                    this.errors = errors.response.data.errors;
                }
            )
        },
        openDialog (title, key) {
            this.$parent.dialog = true; 
            this.$parent.dialog_title = title;
            this.$parent.d_key = key;
        },
        mydate (id) {
            this.patient[id] = $(`#${id}`).val();
            // console.log(this.employee[id])
        },
    }
}
</script>