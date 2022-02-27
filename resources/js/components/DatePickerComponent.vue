<template>
    <v-row justify="center" justify-md="end">
        <v-date-picker v-model="picker" width="280" header-color="primary" @click:date="dialog = true"></v-date-picker>
    </v-row>
</template>
<script>
export default {
    data () {
        return {
            dialog: false,
            picker: new Date().toISOString().substring(0, 10),
        }
    }
}
</script>