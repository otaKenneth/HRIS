<template>
    <v-dialog v-model="dialog" width="50vh" persistent>
        <v-card>
            <v-card-title class="d-flex justify-content-between">
                {{title}}
                <i class="fa fa-times text-red-500 cursor-pointer" aria-hidden="true" @click="$parent.dialog = false;"></i>
            </v-card-title>
            <v-card-text class="m-0 pb-0">
                <div>
                    <small class="text-red-500">Shift must be unique.</small>
                </div>
                <div class="">
                    <i class="fa fa-cog" aria-hidden="true"></i> Options
                    <div class="ml-3">
                        <input type="checkbox" name="option" id="opentime" v-model="shift.opentime">
                        <label for="opentime">Flexible Time</label>
                    </div>
                    <div class="ml-3">
                        <input type="checkbox" name="option" id="breaks" v-model="shift.breaks">
                        <label for="breaks">Break</label>
                    </div>
                </div>
                <div class="">
                    <div v-if="!shift.opentime">
                        <div class="form-group row m-0">
                            <div class="form-group px-2">
                                <label for="in">Check-In</label>
                                <input type="time" class="form-control" name="in" id="in" aria-describedby="helpId" placeholder="" v-model="shift.in">
                                <small id="helpId" v-if="errors.in" class="form-text text-muted text-red-500">{{errors.in[0]}}</small>
                            </div>
                            <div class="form-group px-2" v-if="shift.breaks">
                                <label for="breakOut">Break-Out</label>
                                <input type="time" class="form-control" name="breakOut" id="breakOut" aria-describedby="helpId" placeholder="" v-model="shift.breakOut">
                                <small id="helpId" v-if="errors.breakOut" class="form-text text-muted text-red-500">{{errors.breakOut[0]}}</small>
                            </div>
                            <div class="form-group px-2" v-if="shift.breaks">
                                <label for="breakIn">Break-In</label>
                                <input type="time" class="form-control" name="breakIn" id="breakIn" aria-describedby="helpId" placeholder="" v-model="shift.breakIn">
                                <small id="helpId" v-if="errors.breakIn" class="form-text text-muted text-red-500">{{errors.breakIn[0]}}</small>
                            </div>
                            <div class="form-group px-2">
                                <label for="out">Check-Out</label>
                                <input type="time" class="form-control" name="out" id="out" aria-describedby="helpId" placeholder="" v-model="shift.out">
                                <small id="helpId" v-if="errors.out" class="form-text text-muted text-red-500">{{errors.out[0]}}</small>
                            </div>
                        </div>
                    </div>
                    <div v-if="errors.code">
                        <small class="text-red-500">{{errors.code[0]}}</small>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions class="d-flex justify-content-center">
                <button type="button" v-if="type == 'add'" class="btn btn-primary" @click="createShift"><i class="fas fa-save"></i> Save</button>
                <button type="button" v-if="type == 'edit'" class="btn btn-primary" @click="updateShift"><i class="fas fa-save"></i> Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['dialog', 'title', 's', 'type'],
    data () {
        return {
            shift: this.s, errors: [],
        }
    },
    methods: {
        createShift () {
            if (this.shift.opentime) {
                this.shift.code = 'flexitime';
            }else if (this.shift.breaks) {
                this.shift.code = `${this.shift.in}:${this.shift.breakOut}-${this.shift.breakIn}:${this.shift.out}`;
            }else{
                this.shift.code = `${this.shift.in}:flexibreak:${this.shift.out}`;
            }
            axios.post(``, this.shift).then(response => {
                location.href = '/Shift';
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        },
        updateShift () {
            axios.patch(`${this.shift.id}`, this.shift).then(response => {
                location.href = '/Shift';
            }).catch(errors => {
                this.errors = errors.response.data.errors;
            });
        }
    }
}
</script>