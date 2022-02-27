<template>
    <v-row class="fill-height">
        <v-col>
            <v-sheet height="64">
                <v-toolbar flat color="white">
                    <v-btn outlined class="mr-4" @click="setToday">
                        Today
                    </v-btn>
                    <v-btn fab text small @click="prev">
                        <v-icon small>mdi-chevron-left</v-icon>
                    </v-btn>
                    <v-btn fab text small @click="next">
                        <v-icon small>mdi-chevron-right</v-icon>
                    </v-btn>
                    <v-toolbar-title>{{ title }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-title class="mr-5">Events: </v-toolbar-title>
                    <v-menu bottom right>
                        <template v-slot:activator="{on}">
                            <v-btn outlined v-on="on">
                                <span>{{calendarType[calType]}}</span>
                                <v-icon right>mdi-menu-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item v-for="(ctype, key) in calendarType" :key="key" @click="calType = key">
                                <v-list-item-title>{{ctype}}</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                    <v-spacer></v-spacer>
                    <v-menu bottom right>
                        <template v-slot:activator="{ on }">
                            <v-btn outlined v-on="on">
                                <span>{{ typeToLabel[type] }}</span>
                                <v-icon right>mdi-menu-down</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item @click="type = 'day'">
                                <v-list-item-title>Day</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'week'">
                                <v-list-item-title>Week</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = 'month'">
                                <v-list-item-title>Month</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="type = '4day'">
                                <v-list-item-title>4 days</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar>
            </v-sheet>
            <v-sheet height="80vh">
                <v-calendar ref="calendar" v-model="focus" color="primary" :events="events" :event-color="getEventColor"
                    :event-text-color="getEventTextColor" :event-margin-bottom="3" :now="today" :type="type"
                    @click:more="viewDay" @change="updateRange"></v-calendar>
                    <!--  @mouseenter:day="selectedDates" @mouseup:day="touchend" @click:event="showEvent"
                    @mousedown:day="touchstart" -->
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
        focus: today,
        type: 'month',
        calType: 'all',
        typeToLabel: {
            month: 'Month',
            week: 'Week',
            day: 'Day',
            '4day': '4 Days',
        },
        calendarType: {
            all: 'All',
            leave: 'Leave',
            // override: 'Override',
            holidays: 'Holidays',
            // ot: 'Over Time',
        },
        start: null,
        end: null,
        selectedEvent: {},
        selectedElement: null,
        selectedOpen: false,
        // events: [],
        eventDate: {start:'',end:''},timeout_id:0
    }),
	computed: {
        title () {
            const { start, end } = this
            if (!start || !end) {
                return ''
            }

            const startMonth = this.monthFormatter(start)
            const endMonth = this.monthFormatter(end)
            const suffixMonth = startMonth === endMonth ? '' : endMonth

            const startYear = start.year
            const endYear = end.year
            const suffixYear = startYear === endYear ? '' : endYear

            const startDay = start.day + this.nth(start.day)
            const endDay = end.day + this.nth(end.day)

            switch (this.type) {
                case 'month':
                    return `${startMonth} ${startYear}`
                case 'week':
                case '4day':
                    return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
                case 'day':
                    return `${startMonth} ${startDay} ${startYear}`
            }
            return ''
        },
        monthFormatter () {
            return this.$refs.calendar.getFormatter({
                timeZone: 'UTC', month: 'long',
            })
        },
	},
	mounted () {
	  this.$refs.calendar.checkChange()
	},
    methods: {
        viewDay ({ date }) {
            this.focus = date
            this.type = 'day'
        },
        showEvent ({ nativeEvent, event }) {
            const open = () => {
                this.selectedEvent = event
                this.selectedElement = nativeEvent.target
                setTimeout(() => this.selectedOpen = true, 10)
            }

            if (this.selectedOpen) {
                this.selectedOpen = false
                setTimeout(open, 10)
            } else {
                open()
            }

            nativeEvent.stopPropagation()
        },
        getEventTextColor (event) {
            return event.textColor
        },
        getEventColor (event) {
            return event.color
        },
        setToday () {
            this.focus = this.today;
        },
        prev () {
            this.$refs.calendar.prev()
        },
        next () {
            this.$refs.calendar.next()
        },
        updateRange ({ start, end }) {
            // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
            this.start = start;
            this.end = end;
            // getEventsForCalendar(start.date,end.date);
        },
        nth (d) {
            return d > 3 && d < 21
                ? 'th'
                : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
        }
    }
}
</script>