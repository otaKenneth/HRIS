<template>
    <div class="justify-center">
        <holiday-dialog :dialog="dialog" :holiday="holiday" :title="title"></holiday-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    data () {
        return {
            dialog: false,
            title: 'New Holiday', 
            holiday: {
                type: 'RH', title: null, from: null, to: null, bg: null, color: null,
            }
        }
    }
}
</script>