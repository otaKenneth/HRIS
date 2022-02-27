<template>
    <div class="">
        <shift-dialog :dialog="dialog" type="add" title="New Shift" :s="shift"></shift-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;"><i class="fa fa-plus" aria-hidden="true"></i> <span class="d-none d-md-inline-block">Add</span></button>
    </div>
</template>
<script>
export default {
    data () {
        return {
            dialog: false,
            shift: {
                opentime: false,
                breaks: false,
                in: null, breakOut: null, breakIn: null, out: null, break: null,
            }
        }
    }
}
</script>