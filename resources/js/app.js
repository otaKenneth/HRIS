/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker';
import Vue from 'vue';
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.css';
import 'bootstrap-select';

window.Vue = require('vue');
window.Vue.use(Vuetify);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('notif-component', require('./components/NotifComponent.vue').default);
Vue.component('datepick-component', require('./components/DatePickerComponent.vue').default);
Vue.component('patients', require('./components/PatientToday.vue').default);
Vue.component('new-patient', require('./components/NewPatientComponent.vue').default);
Vue.component('lk-select', require('./components/LookupSelectComponent.vue').default);
Vue.component('address-form', require('./components/AddressFormComponent.vue').default);
Vue.component('image-viewer', require('./components/ImageViewer.vue').default);
Vue.component('weekly-calendar', require('./components/WeeklyCalendar.vue').default);

// admin
Vue.component('patient-record', require('./components/admin/PatientRecord.vue').default);
Vue.component('lookup-cog-dialog', require('./components/admin/LookupCogDialogComponent.vue').default);
Vue.component('lookup-component', require('./components/admin/LookupComponent.vue').default);
Vue.component('salary-view', require('./components/admin/SalaryListComponent.vue').default);
// notifications
Vue.component('notif-bell', require('./components/notifications/Bell.vue').default);
// employee
Vue.component('create-employee', require('./components/admin/employee/CreateEmployeeComponent.vue').default);
// salary
Vue.component('salary-actions', require('./components/admin/salary/ActionButton.vue').default);
Vue.component('salary-dialog', require('./components/admin/salary/Dialog.vue').default);
// patient
Vue.component('gen-surv', require('./components/admin/patient/GeneralSurvey.vue').default);
Vue.component('hpi-component', require('./components/admin/patient/HPI.vue').default);
Vue.component('pmh-component', require('./components/admin/patient/PMH.vue').default);
Vue.component('ppe-component', require('./components/admin/patient/PPE.vue').default);
Vue.component('dnr-component', require('./components/admin/patient/DnR.vue').default);
Vue.component('medication-component', require('./components/admin/patient/Medication.vue').default);
// dtr
Vue.component('dtr', require('./components/admin/dtr/DtrComponent.vue').default);
// shift
Vue.component('shift-add-button', require('./components/admin/shift/AddButton.vue').default);
Vue.component('shift-edit-button', require('./components/admin/shift/EditButton.vue').default);
Vue.component('shift-dialog', require('./components/admin/shift/Dialog.vue').default);
// schedule
Vue.component('schedule-list', require('./components/admin/schedule/List.vue').default);
Vue.component('schedule-dialog', require('./components/admin/schedule/Dialog.vue').default);
Vue.component('schedule-add-button', require('./components/admin/schedule/AddButton.vue').default);
Vue.component('schedule-edit-button', require('./components/admin/schedule/EditButton.vue').default);
// request
Vue.component('calendar', require('./components/request/Calendar.vue').default);
// leave
Vue.component('leave-dialog', require('./components/request/leave/Dialog.vue').default);
Vue.component('leave-add', require('./components/request/leave/AddButton.vue').default);
Vue.component('leave-actions', require('./components/request/leave/ActionButton.vue').default);
// override
Vue.component('override-dialog', require('./components/request/override/Dialog.vue').default);
Vue.component('override-add', require('./components/request/override/AddButton.vue').default);
Vue.component('override-actions', require('./components/request/override/ActionButton.vue').default);
// overtime
Vue.component('overtime-dialog', require('./components/request/overtime/Dialog.vue').default);
Vue.component('overtime-add', require('./components/request/overtime/AddButton.vue').default);
Vue.component('overtime-actions', require('./components/request/overtime/ActionButton.vue').default);
// holiday
Vue.component('holiday-dialog', require('./components/holiday/Dialog.vue').default);
Vue.component('holiday-add', require('./components/holiday/AddButton.vue').default);
Vue.component('holiday-actions', require('./components/holiday/ActionButton.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var ph_provinces = require('philippines/provinces');
var ph_cities = require('philippines/cities');

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    data: {
        ph_cities: ph_cities,
        ph_provinces: ph_provinces,
        tab: null,
        lookup_cog_dialog: false,
        lookup_cog_dialog_title: '',
        sort_key: null, sort_i: 0, userId: 0,
    },
    methods: {
        sortBy(table, key) {
            if (this.sort_key == key) {
                if (this.sort_i == 0) {
                    table.sort((r1, r2) => {
                        if (typeof r1[key] == "string") {
                            return (r1[key].toLowerCase() > r2[key].toLowerCase()) ? 1 : -1;
                        } else {
                            return r1[key] - r2[key]
                        }
                    });
                    this.sort_i = 1;
                } else if (this.sort_i == 1) {
                    table.sort((r1, r2) => {
                        if (typeof r1[key] == "string") {
                            return (r2[key].toLowerCase() > r1[key].toLowerCase()) ? 1 : -1;
                        } else {
                            return r2[key] - r1[key]
                        }
                    });
                    this.sort_i = 2;
                } else {
                    table.sort((r1, r2) => {
                        return r1['id'] - r2['id']
                    });
                    this.sort_i = 0
                }
            } else {
                this.sort_key = key;
                this.sort_i = 0;
                if (this.sort_i == 0) {
                    table.sort((r1, r2) => {
                        if (typeof r1[key] == "string") {
                            return (r1[key].toLowerCase() > r2[key].toLowerCase()) ? 1 : -1;
                        } else {
                            return r1[key] - r2[key]
                        }
                    });
                    this.sort_i = 1;
                }
            }
        }
    }
});

$('.datepicker').datepicker();
$('.thead-sticky tr').each((el) => {
    var pos = $(`.thead-sticky tr:nth-child(${el+1})`).position();
    $(`.thead-sticky tr:nth-child(${el + 1}) th`).css(pos);
});
