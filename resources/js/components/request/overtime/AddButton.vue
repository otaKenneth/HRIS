<template>
    <div class="d-flex justify-content-center">
        <overtime-dialog :dialog="dialog" :overtime="ot" :employees="employees" :title="title"></overtime-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    props: ['employees', 'overtime'],
    data () {
        return {
            dialog: false,
            title: 'New Overtime',
            ot: this.overtime,
        }
    }
}
</script>