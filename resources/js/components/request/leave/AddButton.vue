<template>
    <div>
        <leave-dialog :dialog="dialog" :title="title" :leave="l" :dateRange="dateRange" :employees="employees"></leave-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;" data-toggle="tooltip" data-placement="bottom" title="Request New Leave"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    props: ['employees', 'leave'],
    data () {
        return {
            l: this.leave,
            dialog: false, title: "New Leave",
            dateRange: [],
        }
    }
}
</script>