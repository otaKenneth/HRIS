<template>
    <div id="createEmployee">
        <lookup-cog-dialog :d="cog_dialog" :dt="dialog_title" :errs="errors" :dk="d_key"></lookup-cog-dialog>
        <notif-component :d="notif" :dt="notif_title" :text="notif_text" :status="notif_status"></notif-component>
        <v-stepper v-model="e1">
            <v-stepper-header>
            <v-stepper-step :complete="e1 > 1" step="1" editable>
                <span class="cursor-pointer" :class="(e1 > 1) ? 'complete':''">Basic Information</span>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step :complete="e1 > 2" step="2" editable>
                <span class="cursor-pointer" :class="(e1 > 2) ? 'complete':''">Contact Information</span>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step :complete="e1 > 3" step="3" editable>
                <span class="cursor-pointer" :class="(e1 > 3) ? 'complete':''">Job Information</span>
            </v-stepper-step>

            <v-divider></v-divider>

            <v-stepper-step step="4" editable>
                <span class="cursor-pointer" :class="(e1 > 4) ? 'complete':''">Employment Status</span>
            </v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
            <v-stepper-content step="1" style="padding: 5px;">
                <v-card class="mb-2" style="max-height: 470px; overflow: auto;">
                    <div id="basic-infos" class="d-flex">
                        <div class="form-group col-md-3">
                            <div id="profile-upload">
                                <div class="img-container">
                                    <img :src="(employee.profile == null) ? 'https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg':'/storage/'+employee.profile" alt="Profile Here" class="emp_img cursor-pointer" @click="uploadImg" data-toggle="toggle" title="Click to Upload Picture">
                                </div>
                                <input type="file" name="profile" id="profile" class="d-none" @change="readUrl">
                            </div>
                            <div class="mt-2">
                                <input type="text" name="employee_id" id="empId" class="form-control text-center" v-model="employee.employee_id" required autocomplete="off" autofocus onkeypress="return (event.key >= '0' && event.key <= '9')" maxlength="9" minlength="5" placeholder="Employee Id" :class="(errors.employee_id) ? 'is-invalid':''">
                                <span v-if="errors.employee_id" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.employee_id[0] }}</strong>
                                </span>
                            </div>
                            <div class="mt-2">
                                <div class="form-group d-flex">
                                  <select class="form-control" name="userlvl" id="userlvl" v-model="employee.userlvl">
                                        <option value="0" disabled>User Level</option>
                                        <option v-for="lvl in lkups.userlvl" :key="lvl.id" :value="lvl.id"> {{lvl.value}} </option>
                                  </select>
                                  <button type="button" class="btn btn-normal p-1" @click.stop="openDialog('User Level', 'userlvl')"><i class="fa fa-cog" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-9">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="fname">First Name:</label>
                                    <input type="text" name="firstname" id="fname" class="form-control" v-model="employee.firstname" required autocomplete="off" autofocus :class="(errors.firstname) ? 'is-invalid':''">
                                    <span v-if="errors.firstname" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.firstname[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mname">Middle Name</label>
                                    <input type="text" name="middlename" id="mname" class="form-control" v-model="employee.middlename" required autocomplete="off" autofocus :class="(errors.middlename) ? 'is-invalid':''">
                                    <span v-if="errors.middlename" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.middlename[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="lname">Last Name</label>
                                    <input type="text" name="lastname" id="lname" class="form-control" v-model="employee.lastname" required autocomplete="off" autofocus :class="(errors.lastname) ? 'is-invalid':''">
                                    <span v-if="errors.lastname" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.lastname[0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="uname">Username:</label>
                                    <input type="text" name="username" id="uname" class="form-control" v-model="employee.username" required autocomplete="off" autofocus :class="(errors.username) ? 'is-invalid':''">
                                    <span v-if="errors.username" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.username[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="age">Age:</label>
                                    <input type="number" name="age" id="age" class="form-control w-100" v-model="employee.age" autocomplete="off" autofocus :class="(errors.age) ? 'is-invalid':''" onkeypress="return (event.key >= '0' && event.key <= '9')">
                                    <span v-if="errors.age" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.age[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="birthdate">Birthdate:</label>
                                    <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.birthdate" @blur="mydate('birthdate')" :class="(errors.birthdate) ? 'is-invalid':''">
                                    <span v-if="errors.birthdate" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.birthdate[0] }}</strong>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="gender">Gender:</label>
                                    <button class="btn btn-normal p-1" @click.stop="openDialog('Gender', 'gender')"><i class="fa fa-cog"></i></button>
                                    <select name="gender" id="gender" class="form-control" v-model="employee.gender" required autocomplete="off" autofocus :class="(errors.gender) ? 'is-invalid':''">
                                        <option v-for="v in lkups.gender" :key="v.id" :value="v.id"> {{v.value}} </option>
                                    </select>
                                    <span v-if="errors.gender" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.gender[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cstatus">Civil Status:</label>
                                    <button class="btn btn-normal p-1" @click.stop="openDialog('Civil Status', 'cstatus')"><i class="fa fa-cog"></i></button>
                                    <select name="cstatus" id="cstatus" class="form-control" v-model="employee.cstatus" required autocomplete="off" autofocus :class="(errors.cstatus) ? 'is-invalid':''">
                                        <option v-for="v in lkups.cstatus" :key="v.id" :value="v.id"> {{v.value}} </option>
                                    </select>
                                    <span v-if="errors.cstatus" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.cstatus[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="religion">Religion:</label>
                                    <button class="btn btn-normal p-1" @click.stop="openDialog('Religion', 'religion')"><i class="fa fa-cog"></i></button>
                                    <select name="religion" id="religion" class="form-control" v-model="employee.religion" autocomplete="off" autofocus :class="(errors.religion) ? 'is-invalid':''">
                                        <option v-for="v in lkups.religion" :key="v.id" :value="v.id"> {{v.value}} </option>
                                    </select>
                                    <span v-if="errors.religion" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.religion[0] }}</strong>
                                    </span>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nationality">Nationality:</label>
                                    <button class="btn btn-normal p-1" @click.stop="openDialog('Nationality', 'nationality')"><i class="fa fa-cog"></i></button>
                                    <select name="nationality" id="nationality" class="form-control" v-model="employee.nationality" required autocomplete="off" autofocus :class="(errors.nationality) ? 'is-invalid':''">
                                        <option v-for="v in lkups.nationality" :key="v.id" :value="v.id"> {{v.value}} </option>
                                    </select>
                                    <span v-if="errors.nationality" class="invalid-feedback" role="alert">
                                        <strong>{{ errors.nationality[0] }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card>
                <div v-if="!employee.disabled" class="d-flex justify-content-between px-2">
                    <a class="btn btn-danger text-light" href="/Employees" ><i class="fa fa-arrow-left"></i>&nbsp;Back</a>
                    <button class="btn btn-primary" @click="saveEmpBasicInfo">Continue&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </v-stepper-content>

            <v-stepper-content step="2" style="padding: 5px;">
                <v-card class="mb-2" style="max-height: 400px; overflow: auto;">
                    <div id="contact-info" class="px-3">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="email">E-mail:</label>
                                <input type="email" name="email" id="email" class="form-control" v-model="employee.email" required autocomplete="off" autofocus :class="(errors.email) ? 'is-invalid':''">
                                <span v-if="errors.email" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.email[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="mnum">Mobile Number:</label>
                                <input type="text" name="mnum" id="mnum" class="form-control" v-model="employee.mnum" required autocomplete="off" autofocus onkeypress="return (event.key >= '0' && event.key <= '9')" maxlength="11" :class="(errors.mnum) ? 'is-invalid':''">
                                <span v-if="errors.mnum" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.mnum[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tnum">Telephone Number:</label>
                                <input type="text" name="tnum" id="tnum" class="form-control" v-model="employee.tnum" autocomplete="off" autofocus onkeypress="return (event.key >= '0' && event.key <= '9')" maxlength="9" :class="(errors.tnum) ? 'is-invalid':''">
                                <span v-if="errors.tnum" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.tnum[0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <thead class="thead thead-dark">
                                    <tr>
                                        <th>Type</th>
                                        <th>Address</th>
                                        <th>Town/City</th>
                                        <th>Provice</th>
                                        <th>Country</th>
                                        <th v-if="!employee.disabled">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="address_err">
                                        <td colspan="6" class="bg-red-200">
                                            <div class="text-center">Fill Up All Inputs For Your Address</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="addType" id="addType" v-model="address.type" class="form-control" requried autofocus>
                                                <option value="0">Home Address</option>
                                                <option value="1">Current Address</option>
                                            </select>
                                            <!-- <span v-if="error.lastname" class="invalid-feedback" role="alert">
                                                <strong>{{ error.lastname }}</strong>
                                            </span> -->
                                        </td>
                                        <td>
                                            <input type="text" name="address" id="address" class="form-control" v-model="address.address" required autocomplete="off" autofocus>
                                        </td>
                                        <td>
                                            <select name="town" id="town" v-model="address.town" class="form-control" requried autofocus>
                                                <!-- <option value="0">Calumpit</option> -->
                                                <option v-for="(city, key) in temp_cities" :key="key" :value="key">{{city.name}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="province" id="province" v-model="prov_key" class="form-control" requried autofocus>
                                                <!-- <option value="0">Bulacan</option> -->
                                                <option v-for="(province, key) in provinces" :key="key" :value="key">{{province.name}}</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="country" id="country" v-model="address.country" class="form-control" disabled>
                                        </td>
                                        <td v-if="!employee.disabled" class="d-flex">
                                            <button class="btn btn-primary w-100" @click="addAddress" :class="(show_add_btn) ? 'd-block':'d-none'"><i class="fa fa-plus"></i>&nbsp;Add</button>
                                            <button class="btn btn-primary w-100" @click="updateAddress(address.id)" :class="(show_add_btn) ? 'd-none':'d-block'"><i class="fa fa-save"></i>&nbsp;Save</button>
                                        </td>
                                    </tr>
                                    <tr v-for="(address, key) in employee.addresses" :key="key">
                                        <td>{{ ["Home Address","Current Address"][address.type] }}</td>
                                        <td>{{ address.address }}</td>
                                        <td>{{ ($root.ph_cities).filter(data => data.province == provinces[address.province].key)[address.town].name }}</td>
                                        <td>{{ provinces[address.province].name }}</td>
                                        <td>{{ address.country }}</td>
                                        <td v-if="!employee.disabled">
                                            <div class="d-flex justify-content-around">
                                                <button class="btn btn-warning" @click="editAddress(key)"><i class="fa fa-edit"></i></button>
                                                <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </v-card>

                <div v-if="!employee.disabled" class="d-flex justify-content-between px-2">
                    <button class="btn btn-danger" @click="e1 = 1"><i class="fa fa-arrow-left"></i>&nbsp;Previous</button>
                    <button class="btn btn-primary" @click="saveContactInfo">Continue&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </v-stepper-content>

            <v-stepper-content step="3" style="padding: 5px;">
                <v-card class="mb-2" style="max-height: 470px; overflow: auto;">
                    <div id="job-info" class="px-3">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="tax">Tax:</label>
                                <select name="tax" id="tax" class="form-control" v-model="employee.tax" required autocomplete="off" autofocus :class="(errors.tax) ? 'is-invalid':''">
                                    <option value="0">Exempted</option>
                                    <option value="1">Not Exempted</option>
                                </select>
                                <span v-if="errors.tax" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.tax[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sss">SSS:</label>
                                <select name="sss" id="sss" class="form-control" v-model="employee.sss" required autocomplete="off" autofocus :class="(errors.sss) ? 'is-invalid':''">
                                    <option value="0">Exempted</option>
                                    <option value="1">Not Exempted</option>
                                </select>
                                <span v-if="errors.sss" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.sss[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="philhealth">Philhealth:</label>
                                <select name="philhealth" id="philhealth" class="form-control" v-model="employee.philhealth" required autocomplete="off" autofocus :class="(errors.philhealth) ? 'is-invalid':''">
                                    <option value="0">Exempted</option>
                                    <option value="1">Not Exempted</option>
                                </select>
                                <span v-if="errors.philhealth" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.philhealth[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="pagibig">Pag-ibig:</label>
                                <select name="pagibig" id="pagibig" class="form-control" v-model="employee.pagibig" required autocomplete="off" autofocus :class="(errors.pagibig) ? 'is-invalid':''">
                                    <option value="0">Exempted</option>
                                    <option value="1">Not Exempted</option>
                                </select>
                                <span v-if="errors.pagibig" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.pagibig[0] }}</strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="job_position">Job Position:</label>
                                <button class="btn btn-normal p-1" @click.stop="openDialog('Job Position', 'job_position')"><i class="fa fa-cog"></i></button>
                                <select name="job_position" id="job_position" class="form-control" v-model="employee.job_position" required autocomplete="off" autofocus :class="(errors.job_position) ? 'is-invalid':''">
                                    <option v-for="v in lkups.job_position" :key="v.id" :value="v.id"> {{v.value}} </option>
                                </select>
                                <span v-if="errors.job_position" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.job_position[0] }}</strong>
                                </span>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="job_status">Job Status:</label>
                                <button class="btn btn-normal p-1" @click.stop="openDialog('Job Status', 'job_status')"><i class="fa fa-cog"></i></button>
                                <select name="job_status" id="job_status" class="form-control" v-model="employee.job_status" required autocomplete="off" autofocus :class="(errors.job_status) ? 'is-invalid':''">
                                    <option v-for="v in lkups.job_status" :key="v.id" :value="v.id"> {{v.value}} </option>
                                </select>
                                <span v-if="errors.job_status" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.job_status[0] }}</strong>
                                </span>
                            </div>
                        </div>
                    </div>
                </v-card>

                <div v-if="!employee.disabled" class="d-flex justify-content-between px-2">
                    <button class="btn btn-danger" @click="e1 = 2"><i class="fa fa-arrow-left"></i>&nbsp;Previous</button>
                    <button class="btn btn-primary" @click="saveJobInfo">Continue&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </v-stepper-content>

            <v-stepper-content step="4" style="padding: 5px;">
                <v-card class="mb-2" style="max-height: 400px; overflow: auto;">
                    <div id="employment-status" class="py-2 px-3">
                        <div class="d-flex justify-content-center">
                            <div class="form-group col-md-6 pb-0 mb-0">
                                <v-stepper v-model="e6" vertical class="py-1">
                                    <v-stepper-step :complete="e6 > 1" step="1" :class="(e6 == 1) ? 'p-1':''">Training Period</v-stepper-step>

                                    <v-stepper-content step="1" class="pl-5" :class="(e6 == 1) ? '':'d-none'">
                                        <v-card class="mb-2">
                                            <div class="row">
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="training_start">Start Date:</label>
                                                    <input type="text" name="training_start" id="training_start" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.training_start" :class="(errors.training_start) ? 'is-invalid':''" @blur="mydate('training_start')">
                                                    <span v-if="errors.training_start" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.training_start[0] }}</strong>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="training_evaluation">Evaluation Date:</label>
                                                    <input type="text" name="training_evaluation" id="training_evaluation" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.training_evaluation" :class="(errors.training_evaluation) ? 'is-invalid':''" @blur="mydate('training_evaluation')">
                                                    <span v-if="errors.training_evaluation" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.training_evaluation[0] }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </v-card>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-primary" @click="e6 = 2"><i class="text-xs fa fa-arrow-down"></i></button>
                                        </div>
                                    </v-stepper-content>

                                    <v-stepper-step :complete="e6 > 2" step="2" :class="(e6 == 2) ? 'p-1':''">Probationary</v-stepper-step>

                                    <v-stepper-content step="2" class="pl-5" :class="(e6 == 2) ? '':'d-none'">
                                        <v-card class="mb-2">
                                            <div class="row">
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="probi_start">Start Date:</label>
                                                    <input type="text" name="probi_start" id="probi_start" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.probi_start" :class="(errors.probi_start) ? 'is-invalid':''" @blur="mydate('probi_start')">
                                                    <span v-if="errors.probi_start" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.probi_start[0] }}</strong>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="probi_evaluation">Evaluation Date:</label>
                                                    <input type="text" name="probi_evaluation" id="probi_evaluation" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.probi_evaluation" :class="(errors.probi_evaluation) ? 'is-invalid':''" @blur="mydate('probi_evaluation')">
                                                    <span v-if="errors.probi_evaluation" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.probi_evaluation[0] }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </v-card>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-danger mr-2" @click="e6 = 1"><i class="text-xs fa fa-arrow-up"></i></button>
                                            <button class="btn btn-primary" @click="e6 = 3"><i class="text-xs fa fa-arrow-down"></i></button>
                                        </div>
                                    </v-stepper-content>

                                    <v-stepper-step :complete="e6 > 3" step="3" :class="(e6 == 3) ? 'p-1':''">Regularization</v-stepper-step>

                                    <v-stepper-content step="3" class="pl-5" :class="(e6 == 3) ? '':'d-none'">
                                        <v-card class="mb-2">
                                            <div class="row">
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="reg_start">Start Date:</label>
                                                    <input type="text" name="reg_start" id="reg_start" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.reg_start" :class="(errors.reg_start) ? 'is-invalid':''" @blur="mydate('reg_start')">
                                                    <span v-if="errors.reg_start" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.reg_start[0] }}</strong>
                                                    </span>
                                                </div>
                                                <div class="form-group col-md-6 m-0">
                                                    <label for="reg_end">End Date:</label>
                                                    <input type="text" name="reg_end" id="reg_end" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.reg_end" :class="(errors.reg_end) ? 'is-invalid':''" @blur="mydate('reg_end')">
                                                    <span v-if="errors.reg_end" class="invalid-feedback" role="alert">
                                                        <strong>{{ errors.reg_end[0] }}</strong>
                                                    </span>
                                                </div>
                                            </div>
                                        </v-card>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-danger" @click="e6 = 2"><i class="text-xs fa fa-arrow-up"></i></button>
                                        </div>
                                    </v-stepper-content>
                                    
                                </v-stepper>
                            </div>
                            <div class="form-group col-md-6 pb-0 mb-0">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="emp_status">Employment Status:</label>
                                        <select name="emp_status" id="emp_status" class="form-control" v-model="employee.emp_status" required autocomplete="off" autofocus :class="(errors.emp_status) ? 'is-invalid':''">
                                            <option value="0">Employed</option>
                                            <option value="1">Resigned</option>
                                        </select>
                                        <span v-if="errors.emp_status" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.emp_status[0] }}</strong>
                                        </span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="hire_date">Hire Date:</label>
                                        <input type="text" name="hire_date" id="hire_date" class="form-control datepicker" placeholder="mm/dd/yyyy" data-date-format="mm/dd/yyyy" v-model="employee.hire_date" :class="(errors.hire_date) ? 'is-invalid':''" @blur="mydate('hire_date')">
                                        <span v-if="errors.hire_date" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.hire_date[0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="sl_credits">Sick Leave Credits:</label>
                                        <input type="number" name="sl_credits" id="sl_credits" class="form-control w-100" v-model="employee.sl_credits" autocomplete="off" autofocus :class="(errors.sl_credits) ? 'is-invalid':''" min="0">
                                        <span v-if="errors.sl_credits" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.sl_credits[0] }}</strong>
                                        </span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="vl_credits">Vacation Leave Credits:</label>
                                        <input type="number" name="vl_credits" id="vl_credits" class="form-control w-100" v-model="employee.vl_credits" autocomplete="off" autofocus :class="(errors.vl_credits) ? 'is-invalid':''" min="0">
                                        <span v-if="errors.vl_credits" class="invalid-feedback" role="alert">
                                            <strong>{{ errors.vl_credits[0] }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="rol">Reason of Leaving:</label>
                                        <textarea name="rol" id="rol" cols="30" rows="3" class="form-control" v-model="employee.rol"></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="remarks">Remarks:</label>
                                        <textarea name="remarks" id="remarks" cols="30" rows="3" class="form-control" v-model="employee.remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-card>

                <div v-if="!employee.disabled" class="d-flex justify-content-between px-2">
                    <button class="btn btn-danger" @click="e1 = 3"><i class="fa fa-arrow-left"></i>&nbsp;Previous</button>
                    <a href="/Employees" id="finish"></a>
                    <button class="btn btn-primary" @click="saveEmpStat">Finish&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
            </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </div>
</template>
<script>
    export default {
        props: ['employee', 'heads'],
        data () {
            return {
                e1: 1, e6: 1, errors: {}, show_add_btn: true, address_key: null, address_err: false,
                temp_cities: [], profile_updated: false,
                provinces: this.$root.ph_provinces,
                prov_key: null,
                address: {
                    type: '', address: '', town: '', province: '', country: 'Philippines'
                },
                cog_dialog: false, dialog_title: null, d_key: null,
                lkups: [],
                notif: false, notif_title: '', notif_text: '', notif_status: '',
            }
        },
        watch:{
            prov_key (value) {
                if (value != null) {
                    this.address.province = value;
                    this.temp_cities = (this.$root.ph_cities).filter(data => data.province == this.provinces[value].key);
                }
            }
        },
        mounted () {
            if (this.employee.disabled) {
                $('#createEmployee input').prop('disabled', true);
                $('#createEmployee textarea').attr('readonly', true);
                $('#createEmployee select').prop('disabled', true);
                $('#createEmployee .stepper-actions').addClass('d-none');
            }

            if (this.employee.training_evaluation != null) {
                this.e6 = 2;
            }
            
            if (this.employee.probi_evaluation != null) {
                this.e6 = 3;
            }

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
        methods:{
            uploadImg () {
                $('#profile').click();
            },
            readUrl (ev) {
                if (ev.target.files && ev.target.files[0]) {
                    var reader = new FileReader();

                    reader.onload = (e) => {
                        $('.emp_img').attr('src', e.target.result);
                    };
                    this.employee.profile = ev.target.files[0];
                    this.profile_updated = true;
                    reader.readAsDataURL(ev.target.files[0]);
                }
            },
            saveEmpBasicInfo () {
                var url = (this.employee.editable) ? `Basic_Info`:`/Employee/Basic_Info`;
                axios.post(url, this.employee).then(
                    response => {
                        if (!this.employee.editable) {
                            this.employee.id = response.data.id;
                            this.employee.editable = true;
                        }

                        if (this.profile_updated) {
                            let formData = new FormData();
                            formData.append('profile', this.employee.profile);
                            
                            axios.post(`Profile`, formData, {
                                headers: {
                                    'Content-Type' : 'multipart/form-data'
                                }
                            }).then(response => {
                                this.e1 = 2;
                            }).catch(errors => {
                                // console.log(errors.response.data.message);
                                this.notif = true; 
                                this.notif_title = 'err';
                                this.notif_text = errors.response.data.message;
                                this.notif_status = errors.response.status;
                            });
                        }else{
                            this.e1 = 2;
                        }
                    }
                ).catch(
                    errors => {
                        this.errors = errors.response.data.errors;
                    }
                );
            },
            saveContactInfo () {
                axios.post(`/Employee/${this.employee.id}/Contact_Info`, this.employee).then(
                    response => {
                        this.e1 = 3;
                        this.address_err = true;
                    }
                ).catch(
                    errors => {
                        this.errors = errors.response.data.errors;
                    }
                );
            },
            addAddress () {
                var test = Object.values(this.address).find((data) => (data == '' || data == null));
                if (test == undefined) {
                    this.address.province = this.prov_key;
                    this.employee.addresses = [...this.employee.addresses, this.address];
                    var address = this.address;
                    address['user_id'] = this.employee.id;
    
                    axios.post(`/Employee/${this.employee.id}/Address`, address).then(
                        response => {
                            console.log('Saved');
                        }
                    ).catch(
                        errors => {
                            this.address_err = errors.response.data.errors;
                        }
                    )
                    this.prov_key = null;
                    this.address = {
                        type: '', address: '', town: '', province: '', country: 'Philippines'
                    };
                    this.address_err = false;
                }else{
                    this.address_err = true;
                }
            },
            editAddress (i) {
                this.show_add_btn = false; this.address_key = i;
                this.address = this.employee.addresses[i];
                this.prov_key = this.address.province;
            },
            updateAddress () {
                this.show_add_btn = true; this.address_key = null;
                this.address.province = this.prov_key;
                this.employee.addresses[this.address_key] = this.address;

                axios.post(`/Employee/${this.employee.id}/Address/${this.address.id}/Edit`, this.address).then(
                    response => {
                        console.log('Saved');
                    }
                ).catch(
                    errors => {
                        this.errors = errors.response.data.errors;
                    }
                );
                
                this.prov_key = null;
                this.address = {
                    type: '', address: '', town: '', province: '', country: 'Philippines'
                };
            },
            saveJobInfo () {
                axios.post(`/Employee/${this.employee.id}/Job_info`, this.employee).then(
                    response => {
                        this.e1 = 4;
                        console.log('Saved');
                    }
                ).catch(
                    errors => {
                        this.errors = errors.response.data.errors;
                    }
                )
            },
            saveEmpStat () {
                this.employee.hire_date = $('#hire_date').val();
                this.employee.training_start = $('#training_start').val();
                this.employee.training_evaluation = $('#training_evaluation').val();
                this.employee.probi_start = $('#probi_start').val();
                this.employee.probi_evaluation = $('#probi_evaluation').val();
                this.employee.reg_start = $('#reg_start').val();
                this.employee.reg_end = $('#reg_end').val();

                axios.post(`/Employee/${this.employee.id}/Employee_Status`, this.employee).then(
                    response => {
                        this.notif = true;
                        this.notif_title = "ok";
                        this.notif_text = `Modifications for Employee ${this.employee.id} has been saved.`;
                        // this.e1 = 1;
                    }
                ).catch(
                    errors => {
                        this.errors = errors.response.data.errors;
                    }
                )
            },
            openDialog (title, key) {
                this.cog_dialog = true; 
                this.dialog_title = title;
                this.d_key = key;
            },
            headName (f, m, l) {
                var mi = [];
                m.split(" ").forEach( (v, k) => {
                    mi.push(v.substr(0,1));
                } );
                m = mi.join(".");
                return `${f} ${m} ${l}`;
            },
            mydate (id) {
                this.employee[id] = $(`#${id}`).val();
                // console.log(this.employee[id])
            }
        }
    }
</script>