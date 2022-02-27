<template>
    <v-dialog v-model="dialog" width="30vw" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text>
                <div class="form-group row">
                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Aa..." :class="errors.title ? 'is-invalid':''" v-model="holiday.title">
                        <small id="helpId" v-if="errors.title" class="text-red-500">{{errors.title[0]}}</small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="type">Type</label>
                        <select class="form-control" name="type" id="type" v-model="holiday.type" :class="errors.type ? 'is-invalid':''" @change="setColors">
                            <option value="RH">Regular Holiday</option>
                            <option value="SH">Special Holiday</option>
                        </select>
                        <small id="helpId" v-if="errors.type" class="text-red-500">{{errors.type[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0">
                        <label for="from">From</label>
                        <input type="text" name="from" id="from" class="form-control date-picker" placeholder="mm/dd/yyyy"  data-date-format="mm/dd/yyyy" data-provide="datepicker" aria-describedby="helpId" @blur="mydate('from')" v-model="holiday.from" :class="errors.from ? 'is-invalid':''">
                        <small id="helpId" v-if="errors.from" class="text-red-500">{{errors.from[0]}}</small>
                    </div>
                    <div class="form-group col-md-6 m-0">
                        <label for="to">To</label>
                        <input type="text" name="to" id="to" class="form-control date-picker" placeholder="mm/dd/yyyy"  data-date-format="mm/dd/yyyy" data-provide="datepicker" aria-describedby="helpId" @blur="mydate('to')" v-model="holiday.to" :class="errors.to ? 'is-invalid':''">
                        <small id="helpId" v-if="errors.to" class="text-red-500">{{errors.to[0]}}</small>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="justify-center">
                <button type="button" v-if="title == 'New Holiday'" class="btn btn-primary" @click="createHoliday"><i class="fas fa-save"></i> Save</button>
                <button type="button" v-else class="btn btn-primary" @click="updateHoliday"><i class="fas fa-save"></i> Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'holiday', 'title'],
    data () {
        return {
            bgs: {
                'RH': '#ed8936',
                'SH': '#d6bcfa',
            },
            colors: {
                'RH': '#fff',
                'SH': '#000',
            },
            errors: [],
        }
    },
    methods: {
        mydate (id) {
            this.holiday[id] = $(`#${id}`).val();
            var to = $('#to').val();
            if (id == 'from' && (this.holiday.to == null || this.holiday.to == "")) {
                this.holiday['to'] = $(`#${id}`).val();
            }
        },
        createHoliday () {
            axios.post('/Holiday', this.holiday).then(response => {
                location.href = '/Holiday';
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        },
        updateHoliday () {
            axios.patch(`/Holiday/${this.holiday.id}`, this.holiday).then(response => {
                location.href = '/Holiday';
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        },
        setColors () {
            this.$parent.holiday.bg = this.bgs[this.holiday.type];
            this.$parent.holiday.color = this.colors[this.holiday.type];
        }
    }
}
</script>