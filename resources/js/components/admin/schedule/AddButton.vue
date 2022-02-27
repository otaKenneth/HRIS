<template>
    <div>
        <schedule-dialog :dialog="dialog" title="New Week Schedule" :schedule="schedule"></schedule-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    data () {
        return {
            schedule: {
                code: '', sun: '', mon: '', tue: '', wed: '', th: '', fri: '', sat: '',
            },
            dialog: false,
        }
    }
}
</script>