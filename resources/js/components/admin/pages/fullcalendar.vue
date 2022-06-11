<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

import AddRecords from "../popup/add-records";

export default {
    components: {
        FullCalendar, // make the <FullCalendar> tag available
        AddRecords,
    },
    data() {
        return {
            calendarOptions: {
                plugins: [ dayGridPlugin, interactionPlugin ],
                initialView: 'dayGridMonth',
                headerToolbar: {},
                height: 700,
                timeZone: 'UTC',
                firstDay: 1,
                locale: 'ru',
                themeSystem: 'bootstrap',
                eventDisplay: 'block',
                nextDayThreshold: '00:00:00',
                editable: true,
                selectable: true,
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                weekends: true,
                events: '',
                //eventClick: this.clickRecord,
                // eventsSet: this.handleEvents,
                dateClick: this.dateClick
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            }
        }
    },
    methods: {
        dateClick(record) {
            let nameChoiceDate = new Date(record.dateStr).toLocaleString('ru', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                weekday: 'long'
            });
            this.$refs.add_records.date = record.dateStr
            this.$refs.add_records.nameChoiceDate = nameChoiceDate
            this.$refs.add_records.records = [{
                typeMyself: false,
                time: '00:00',
                status: 1,
                title: ''
            }]
            this.$refs.add_records.isDisabled = false
            this.$refs.add_records.$refs._open_modal_add_record.click()
        },
    },
    mounted() {

    }
}
</script>
<template>
    <div class="card card-primary">
        <FullCalendar :options="calendarOptions" />
        <AddRecords ref="add_records"></AddRecords>
    </div>
</template>
<style>
a {
    color: black;
}
</style>
