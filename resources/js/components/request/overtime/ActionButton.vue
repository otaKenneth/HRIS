<template>
    <div class="d-flex justify-content-around">
        <overtime-dialog :dialog="dialog" :overtime="item" :employees="employees" :title="title"></overtime-dialog>
        <button type="button" v-if="overtime.status == 0" class="btn btn-warning" @click="dialog = true;"><i class="fa fa-edit" aria-hidden="true"></i></button>
        <button type="button" v-else class="btn" style="background-color: #90cdf4;"><i class="fa fa-eye" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    props: ['overtime', 'employees'],
    data () {
        return {
            dialog: false,
            title: 'Edit Overtime',
            item: this.setDate(this.overtime),
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