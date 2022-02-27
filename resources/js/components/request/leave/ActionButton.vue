<template>
    <div>
        <leave-dialog :dialog="dialog" :title="title" :leave="l" :dateRange="leave.leave_ranges" :employees="employees"></leave-dialog>
        <div class="d-flex justify-content-around" v-if="leave.status == 0">
            <button type="button" class="btn btn-warning" @click="dialog = true;"><i class="fas fa-edit"></i></button>
            <button type="button" class="btn btn-danger" @click="destroy"><i class="fa fa-trash" aria-hidden="true"></i></button>
        </div>
        <div class="d-flex justify-content-center" v-else>
            <button type="button" class="btn" style="background-color: #90cdf4;"><i class="fa fa-eye" aria-hidden="true"></i></button>
        </div>
    </div>
</template>
<script>
export default {
    props: ['leave', 'employees'],
    data () {
        return {
            l: this.leave,
            dialog: false, title: "Edit Leave", 
        }
    },
    methods: {
        destroy () {
            axios.delete(`/Leave/${this.l.id}`).then(response => {
                location.href = "";
            });
        }
    }
}
</script>