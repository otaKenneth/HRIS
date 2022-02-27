<template>
    <v-row class="fill-height">
        <v-col>
            <v-sheet height="55vh">
                <v-calendar
                    ref="calendar"
                    v-model="focus"
                    :now="today"
                    type="week"
                    :events="events"
                >
                </v-calendar>
            </v-sheet>
        </v-col>
    </v-row>
</template>

<script>
var date = new Date();
var dd = date.getDate();
var mm = date.getMonth()+1;
var yy = date.getFullYear();
var today = `${yy}-${mm}-${dd}`;
export default {
    props: ['events'],
    data: () => ({
        today: today,
        focus: today
    }),
    mounted () {
        this.$refs.calendar.scrollToTime('12:00');
    },
}
</script>