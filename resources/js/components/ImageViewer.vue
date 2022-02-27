<template>
    <v-dialog v-model="imageD" fullscreen>
        <v-card>
            <v-card-title class="d-flex justify-content-between headline">
                <h2> {{img}} </h2>
                <button type="button" class="btn btn-link" @click="close"><i class="fa fa-times text-lg text-red-500"></i></button>
            </v-card-title>
            <v-card-text style="height: 89vh; overflow: auto;">
                <div class="container-fluid d-flex justify-content-center">
                    <img :src="img" class="img-fluid rounded" alt="">
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>
<script>
export default {
    props: ['imageD','img'],
    methods: {
        close () {
            this.$parent.imageDialog = false;
        }
    }
}
</script>