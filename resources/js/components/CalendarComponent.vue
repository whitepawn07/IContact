<template>
  <v-layout>
    <v-flex>
        <v-sheet height="64">
            <v-toolbar flat color="white">
                <v-btn outlined class="mr-4" @click="setToday">
                Today
                </v-btn>
                <v-btn fab text small @click="prev">
                    <v-icon small>arrow_back_ios</v-icon>
                </v-btn>
                <v-btn fab text small @click="next">
                <v-icon small>arrow_forward_ios</v-icon>
                </v-btn>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                
            </v-toolbar>
        </v-sheet>
        <v-sheet height="470">
            <v-calendar
                ref="calendar"
                v-model="focus"
                :type="type"
                :now="today"
                :value="today"
                color="primary"
                @change="updateRange"
                >
            <template v-slot:day="{ date }">
                <template v-for="event in eventsMap[date]">
                <v-menu
                    :key="event.title"
                    v-model="event.open"
                    full-width
                    offset-x
                >
                    <template v-slot:activator="{ on }">
                        <div
                            v-if="!event.time"
                            v-ripple
                            class="my-event"
                            v-on="on"
                            v-html="event.title"
                        ></div>
                    </template>
                </v-menu>
                </template>
            </template>
            </v-calendar>
        </v-sheet>
    </v-flex>
  </v-layout>
</template>
<script>
    import moment from 'moment'
    export default {
        props:[
            'eventdata'
        ],
        data: () => ({
            type: 'month',
            start: null,
            end: null,
            
            today:  moment().format('YYYY-MM-DD') ,
            focus:  moment().format('YYYY-MM-DD') ,
            events: [
                {
                    title: 'Vacation',
                    details: 'Going to the beach!',
                    date: '2018-12-30',
                    open: false
                },
                {
                    title: 'Vacation',
                    details: 'Going to the beach!',
                    date: '2018-12-31',
                    open: false
                },
                {
                    title: 'Vacation',
                    details: 'Going to the beach!',
                    date: '2019-01-01',
                    open: false
                },
                {
                    title: 'Meeting',
                    details: 'Spending time on how we do not have enough time',
                    date: '2019-01-07',
                    open: false
                },
                {
                    title: '30th Birthday',
                    details: 'Celebrate responsibly',
                    date: '2019-01-03',
                    open: false
                },
                {
                    title: 'New Year',
                    details: 'Eat chocolate until you pass out',
                    date: '2019-01-01',
                    open: false
                },
                {
                    title: 'Conference',
                    details: 'Mute myself the whole time and wonder why I am on this call',
                    date: '2019-01-21',
                    open: false
                },
                {
                    title: 'Hackathon',
                    details: 'Code like there is no tommorrow',
                    date: '2019-02-01',
                    open: false
                }
                // {
                // name: 'Vacation',
                // start: '2018-12-30',
                // end: '2019-01-02',
                // },
                // {
                // name: 'Meeting',
                // start: '2019-01-07',
                // },
                // {
                // name: '30th Birthday',
                // start: '2019-01-03',
                // },
                // {
                // name: 'New Year',
                // start: '2019-01-01',
                // },
                // {
                // name: 'Conference',
                // start: '2019-01-21',
                // },
                // {
                // name: 'Hackathon',
                // start: '2019-01-30',
                // end: '2019-02-01',
                // },
            ]
        }),
        computed: {
        // convert the list of events into a map of lists keyed by date
        eventsMap () {
            const map = {}
            
            this.events.forEach(e => (map[e.date] = map[e.date] || []).push(e) )
            return map
        },
        title () {
            const { start, end } = this
            // return moment().format('MMMM YYYY') 
            if (!start || !end) {
            return moment().format('MMMM YYYY') 
            }
        
            const startMonth = moment(start.date).format('MMMM')
            const endMonth = moment(end.date).format('MMMM')
            const suffixMonth = startMonth === endMonth ? '' : endMonth
            const startYear = start.year
            const endYear = end.year
            const suffixYear = startYear === endYear ? '' : endYear
            const startDay = start.day + this.nth(start.day)
            const endDay = end.day + this.nth(end.day)
            
            return `${startMonth} ${startYear}`
        },
        },
        methods: {
            
            open (event) {
            alert(event.title)
            },
            setToday () {
            this.focus = this.today
            },
            prev () {
            this.$refs.calendar.prev()
            },
            next () {
                
            this.$refs.calendar.next()
            },
            updateRange ({ start, end }) {
            // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
            this.start = start
            this.end = end
            },
            nth (d) {
            return d > 3 && d < 21
                ? 'th'
                : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
            },
        },
        watch:{
            eventdata(){
                this.events = this.eventdata
            }
        }
        
    
  }
</script>
<style scoped>
  .my-event {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    border-radius: 2px;
    background-color: #1867c0;
    color: #ffffff;
    border: 1px solid #1867c0;
    width: 100%;
    font-size: 12px;
    padding: 3px;
    cursor: pointer;
    margin-bottom: 1px;
  }
</style>