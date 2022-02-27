<template>
    <v-dialog v-model="d" persistent max-width="290">
        <v-card>
            <v-card-title class="headline">
                <h2> {{dt}} </h2>
            </v-card-title>

            <v-card-text>
                <div class="row">
                    <div class="form-group col-8 mb-0">
                        <label for="value">Value:</label>
                        <input type="text" name="value" id="value" class="form-control" autocomplete="off" required autofocus :class="(errs.value) ? 'is-invalid':''" v-model="value">
                        <span v-if="errs.value" class="invalid-feedback" role="alert">
                            <strong>{{ errs.value[0] }}</strong>
                        </span>
                    </div>
                    <div class="form-group col-4 mb-0">
                        <label for="index">Index:</label>
                        <input type="text" name="index" id="index" class="form-control" autocomplete="off" required autofocus :class="(errs.index) ? 'is-invalid':''" v-model="index">
                        <span v-if="errs.index" class="invalid-feedback" role="alert">
                            <strong>{{ errs.index[0] }}</strong>
                        </span>
                    </div>
                </div>
            </v-card-text>

            <v-card-actions class="d-flex justify-content-around">
                <button class="btn btn-danger mr-2" @click="close"><i class="fa fa-times"></i>&nbsp;Cancel</button>
                <button class="btn btn-primary" @click="addNewLookup"><i class="fa fa-save"></i>&nbsp;Save</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['d', 'dt', 'errs', 'dk'],
    data () {
        return {
            value: null, index: null, dialog: false, errors: this.errs, 
        }
    },
    mounted () {
        this.dialog = this.d;
    },
    methods: {
        close () {
            this.value = null;
            this.$parent.cog_dialog = false;
        },
        addNewLookup () {
            axios.post('/Lookup', {label: this.dt, key: this.dk, value: this.value, index: this.index}).then(
                response => {
                    this.$parent.lkups[this.dk] = response.data[this.dk];
                    this.value = null;
                    this.$parent.cog_dialog = false;
                }
            ).catch(
                errors => {
                    this.errs = errors.response.data.errors;
                }
            )
        }
    }
}
</script>