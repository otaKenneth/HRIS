<template>
    <div class="container-fluid">
        <div class="">
            <span class="font-semibold">General Survey</span>
            <div class="form-group col-md-12 m-0">
                <input type="text" name="gen_survey" id="gen_survey" class="form-control" placeholder="General Survey" :class="(errs.gen_survey) ? 'is-invalid':''" v-model="record.gen_survey">
                <span v-if="errs.gen_survey" class="text-red-500 text-xs mt-2" role="alert">
                    <strong>{{ errs.gen_survey[0] }}</strong>
                </span>
            </div>
        </div>
        <div class="">
            <span class="font-semibold">Vitals</span>
            <div class="d-flex">
                <div class="form-group col-md-2 m-0">
                    <label for="bp">BP:</label>
                    <input type="text" name="bp" id="bp" class="form-control" placeholder="BP" :class="(errs.bp) ? 'is-invalid':''" v-model="record.bp">
                    <span v-if="errs.bp" class="text-red-500 text-xs mt-2" role="alert">
                        <strong>{{ errs.bp[0] }}</strong>
                    </span>
                </div>
                <div class="form-group col-md-2 m-0">
                    <label for="hr">HR:</label>
                    <input type="text" name="hr" id="hr" class="form-control" placeholder="HR" :class="(errs.hr) ? 'is-invalid':''" v-model="record.hr">
                    <span v-if="errs.hr" class="text-red-500 text-xs mt-2" role="alert">
                        <strong>{{ errs.hr[0] }}</strong>
                    </span>
                </div>
                <div class="form-group col-md-2 m-0">
                    <label for="rr">RR:</label>
                    <input type="text" name="rr" id="rr" class="form-control" placeholder="RR" :class="(errs.rr) ? 'is-invalid':''" v-model="record.rr">
                    <span v-if="errs.rr" class="text-red-500 text-xs mt-2" role="alert">
                        <strong>{{ errs.rr[0] }}</strong>
                    </span>
                </div>
                <div class="form-group col-md-3 m-0">
                    <label for="temp">Weight:</label>
                    <div class="d-flex">
                        <input type="text" name="weight" id="weight" class="form-control" placeholder="weight" :class="(errs.weight) ? 'is-invalid':''" v-model="record.weight">
                        <span class="btn">Kg</span>
                    </div>
                    <span v-if="errs.weight" class="text-red-500 text-xs mt-2" role="alert">
                        <strong>{{ errs.weight[0] }}</strong>
                    </span>
                </div>
                <div class="form-group col-md-3 m-0">
                    <label for="temp">Temperature:</label>
                    <div class="d-flex">
                        <input type="text" name="temp" id="temp" class="form-control" placeholder="Temperature" :class="(errs.temp) ? 'is-invalid':''" v-model="record.temp">
                        <span class="btn">°C</span>
                    </div>
                    <span v-if="errs.temp" class="text-red-500 text-xs mt-2" role="alert">
                        <strong>{{ errs.temp[0] }}</strong>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <span class="font-semibold">Chief Complaint</span>
            <div class="form-group col-md-12 m-0">
                <input type="text" name="chief_complaint" id="chief_complaint" class="form-control" placeholder="Aa..." :class="(errs.chief_complaint) ? 'is-invalid':''" v-model="record.chief_complaint">
                <span v-if="errs.chief_complaint" class="text-red-500 text-xs mt-2" role="alert">
                    <strong>{{ errs.chief_complaint[0] }}</strong>
                </span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['record', 'errs'],
    data () {
        return {

        }
    }
}
</script>