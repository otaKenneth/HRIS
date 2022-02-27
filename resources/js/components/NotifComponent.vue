<template>
    <v-dialog v-model="d" persistent max-width="290">
        <v-card>
            <v-card-title class="headline">
                <h2 v-if="dt == 'ok'" class=" text-green-400"> 
                    <i class="fa fa-check"></i> 
                </h2>
                <h2 v-else-if="dt == 'wait'" class=" text-yellow-400">
                    <i class="fa fa-exclamation"></i> 
                </h2>
                <h2 v-else-if="dt == 'notif'" class=" text-yellow-400">
                    <i class="fa fa-exclamation"></i>
                </h2>
                <h2 v-else-if="dt == 'process'" class=" text-blue-400">
                    <i class="fa fa-exclamation"></i>
                </h2>
                <h2 v-else-if="dt == 'err'" class=" text-red-500">
                    <i class="fa fa-exclamation"></i> Error: {{status}}
                </h2>
            </v-card-title>

            <v-card-text>
                <div class="d-flex justify-content-center">
                    {{text}}
                </div>
            </v-card-text>

            <v-card-actions class="d-flex justify-content-around">
                <!-- <button class="btn btn-danger mr-2" @click="close"><i class="fa fa-times"></i>&nbsp;Cancel</button> -->
                <button class="btn btn-warning" v-if="dt == 'wait'">
                    <div class="spinner-border text-yellow-700" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
                <button class="btn btn-success" v-else-if="dt == 'process'" @click="$parent.process"><i class="fa fa-check"></i>&nbsp;OK</button>
                <button class="btn btn-success" v-else @click="ok"><i class="fa fa-check"></i>&nbsp;OK</button>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['d', 'dt', 'text', 'status'],
    methods: {
        ok () {
            this.$parent.e1 = 1;
            this.$parent.notif = false;
        }
    }
}
</script>