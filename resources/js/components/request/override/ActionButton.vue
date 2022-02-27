<template>
    <div>
        <override-dialog :dialog="dialog" :override="oride" :title="title" :employees="employees"></override-dialog>
        <button type="button" class="btn btn-warning" v-if="override.status == 0" @click="dialog = true;"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn" style="background-color: #90cdf4" v-else><i class="fas fa-eye"></i></button>
    </div>
</template>
<script>
export default {
    props: ['override', 'employees'],
    data () {
        return {
            dialog: false,
            title: 'Edit Override',
            oride: this.setDate(this.override),
        }
    },
    methods: {
        setDate (arr) {
            var date = new Date(arr.date);
            var m = date.getMonth()+1; var d = date.getDate(); var y = date.getFullYear();
            m = (m > 9) ? m:`0${m}`;
            d = (d > 9) ? d:`0${d}`;
            arr.date = `${m}/${d}/${y}`;
            return arr;
        }
    }
}
</script>