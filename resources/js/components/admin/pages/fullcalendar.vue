<script>
import '@fullcalendar/core/vdom' // solves problem with Vite
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
    components: {
        FullCalendar // make the <FullCalendar> tag available
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
                //dateClick: this.dateClick
                /* you can update a remote database when these fire:
                eventAdd:
                eventChange:
                eventRemove:
                */
            }
        }
    }
}
</script>
<template>
    <FullCalendar :options="calendarOptions" />
</template>
