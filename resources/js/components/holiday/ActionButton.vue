<template>
    <div>
        <holiday-dialog :dialog="dialog" :holiday="hday" :title="title"></holiday-dialog>
        <button type="button" class="btn btn-warning" @click="dialog = true;"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-danger" @click="deleteHoliday"><i class="fa fa-trash"></i></button>
    </div>
</template>
<script>
export default {
    props: ['holiday'],
    data () {
        return {
            dialog: false,
            title: 'Edit Holiday',
            hday: this.setDate(this.holiday),
        }
    },
    methods: {
        setDate (arr) {
            var date = new Date(arr.from);
            var m = date.getMonth()+1; var d = date.getDate(); var y = date.getFullYear();
            m = (m > 9) ? m:`0${m}`;
            d = (d > 9) ? d:`0${d}`;
            arr.from = `${m}/${d}/${y}`;
            var date = new Date(arr.to);
            var m = date.getMonth()+1; var d = date.getDate(); var y = date.getFullYear();
            m = (m > 9) ? m:`0${m}`;
            d = (d > 9) ? d:`0${d}`;
            arr.to = `${m}/${d}/${y}`;
            return arr;
        },
        deleteHoliday () {
            axios.delete(`/Holiday/${this.holiday.id}`).then(response => {
                location.href = '/Holiday';
            });
        }
    }
}
</script>