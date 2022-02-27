<template>
    <div class="d-flex">
        <notif-component :d="notif" :dt="nTitle" :text="nText" :status="nStatus"></notif-component>
        <!-- <a :href="'/DTR/'+range+'/Employee/'+user_id+'/Process'" class="btn btn-primary text-light" data-toggle="tooltip" data-placement="bottom" title="Process All"><i class="fa fa-repeat"></i></a> -->
        <button type="button" class="btn btn-primary" @click="openNotif" data-toggle="tooltip" data-placement="bottom" title="Re-process"><i class="fa fa-repeat"></i></button>
    </div>
</template>
<script>
export default {
    props: ['range', 'user_id'],
    data () {
        return {
            notif: false,
            nTitle: null,
            nText: null,
            nStatus: null,
        }
    },
    methods: {
        openNotif () {
            this.notif = true;
            this.nTitle = "process";
            this.nText = "Are you sure you want to process all dates of this month?";
        },
        process () {
            this.nTitle = "wait";
            this.nText = "This may take a while. Please wait...";

            axios.get(`/DTR/${this.range}/Employee/${this.user_id}/Process`).then(response => {
                // console.log(response.data)
                if (response.data.processed) {
                    this.nTitle = "ok";
                    this.nText = "All processes is complete. Please reload to view information";
                }
            });
        }
    }
}
</script>