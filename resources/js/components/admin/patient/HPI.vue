<template>
    <div>
        <div class="form-group col-md-12">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <td>
                            <span class="font-semibold text-red-500">S</span>ite
                            &nbsp;
                            <span class="font-bold">Where?</span>
                        </td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="site" id="site" class="form-control" placeholder="Aa..." :class="(errors.site) ? 'is-invalid':''" v-model="record.site">
                                <span v-if="errors.site" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.site[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="font-semibold text-red-500">O</span>nset
                            &nbsp;
                            <span class="font-bold">When?</span>
                        </td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="onset" id="onset" class="form-control" placeholder="Aa..." :class="(errors.onset) ? 'is-invalid':''" v-model="record.onset">
                                <span v-if="errors.onset" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.onset[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="font-semibold text-red-500">C</span>haracter
                            &nbsp;
                            <span class="font-bold">How? What?</span>
                        </td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="character" id="character" class="form-control" placeholder="Aa..." :class="(errors.character) ? 'is-invalid':''" v-model="record.character">
                                <span v-if="errors.character" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.character[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="font-semibold text-red-500">R</span>adiation
                            &nbsp;
                            <span class="font-bold">Does?</span>
                        </td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="radiation" id="radiation" class="form-control" placeholder="Aa..." :class="(errors.radiation) ? 'is-invalid':''" v-model="record.radiation">
                                <span v-if="errors.radiation" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.radiation[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="font-semibold text-red-500">A</span>ssociation</td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="association" id="association" class="form-control" placeholder="Aa..." :class="(errors.radiation) ? 'is-invalid':''" v-model="record.association">
                                <span v-if="errors.association" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.association[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="font-semibold text-red-500">T</span>ime</td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="time" id="time" class="form-control" placeholder="Aa..." :class="(errors.time) ? 'is-invalid':''" v-model="record.time">
                                <span v-if="errors.time" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.time[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="font-semibold text-red-500">E</span>xacerbating/Releiving Factors</td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="exacerbating" id="exacerbating" class="form-control" placeholder="Aa..." :class="(errors.exacerbating) ? 'is-invalid':''" v-model="record.exacerbating">
                                <span v-if="errors.exacerbating" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.exacerbating[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="font-semibold text-red-500">S</span>everity</td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="severity" id="severity" class="form-control" placeholder="Aa..." :class="(errors.severity) ? 'is-invalid':''" v-model="record.severity">
                                <span v-if="errors.severity" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.severity[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Previous Lab Test <small class="text-red-500">(Include Pertinent Negatives)</small></td>
                        <td>
                            <div class="form-group m-0">
                                <input type="text" name="plt" id="plt" class="form-control" placeholder="Aa..." :class="(errors.plt) ? 'is-invalid':''" v-model="record.plt">
                                <span v-if="errors.plt" class="invalid-feedback" role="alert">
                                    <strong>{{ errors.radiation[0] }}</strong>
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
export default {
    props: ['record', 'errs'],
    data () {
        return {
            errors: this.errs,
        }
    }
}
</script>