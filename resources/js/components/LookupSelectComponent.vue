<template>
    <div class="form-group">
        <select class="form-control" :name="id" :id="id" v-model="value">
            <option v-for="(val, k) in lkups[id]" :key="k" :value="val.id">{{val.value}}</option>
        </select>
    </div>
</template>
<script>
export default {
    props: ['id','value'],
    data () {
        return {
            lkups: []
        }
    },
    mounted () {
        axios.get('/Lookup/prettylookups').then(
            response => {
                this.lkups = response.data;
            }
        ).catch(
            errors => {
                this.errors = errors.response.data.errors;
            }
        );
    }
}
</script>