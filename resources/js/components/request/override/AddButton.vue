<template>
    <div>
        <override-dialog :dialog="dialog" :title="title" :employees="employees" :override="override"></override-dialog>
        <button type="button" class="btn btn-primary" @click="dialog = true;"><i class="fa fa-plus" aria-hidden="true"></i></button>
    </div>
</template>
<script>
export default {
    props: ['employees', 'oride'],
    data () {
        return {
            dialog: false,
            title: "New Override",
            override: this.oride,
        }
    }
}
</script>