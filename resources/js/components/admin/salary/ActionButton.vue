<template>
    <div class="d-flex justify-content-around">
        <salary-dialog :dialog="dialog" :title="title" :salary="salary" :employee="employee"></salary-dialog>
        <button type="button" class="btn btn-warning" @click="dialog = true;"><i class="fas fa-edit"></i></button>
        <button type="button" class="btn btn-primary"><i class="fas fa-list"></i></button>
    </div>
</template>
<script>
export default {
    props: ['salary', 'employee'],
    data () {
        return {
            dialog: false,
            title: "Edit Salary",
        }
    },
}
</script>