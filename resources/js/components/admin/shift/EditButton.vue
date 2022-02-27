<template>
    <div>
        <shift-dialog :dialog="dialog" type="edit" :s="new_shift" title="Edit Shift"></shift-dialog>
        <div class="d-flex justify-content-around">
            <button type="button" class="btn btn-warning" @click="dialog = true;"><i class="fa fa-edit" aria-hidden="true"></i> <span class="d-none d-md-inline-block">Edit</span></button>
            <button type="button" class="btn btn-danger" @click="deleteShift"><i class="fa fa-trash" aria-hidden="true"></i> <span class="d-none d-md-inline-block">Delete</span></button>
        </div>
    </div>
</template>
<script>
export default {
    props: ['shift'],
    data () {
        return {
            dialog: false,
            new_shift: this.shift,
        }
    },
    methods: {
        deleteShift () {
            axios.delete(`/Shift/${this.new_shift.id}`).then(response => {
                location.href = "/Shift";
            }).catch(errors => {
                console.log(errors.response.data.errors);
            })
        }
    }
}
</script>