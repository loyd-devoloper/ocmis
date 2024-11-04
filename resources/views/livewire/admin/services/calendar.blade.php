
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
<div>
    <section x-data="dropdown" wire:ignore>
        <div lass="col-6">
            <label for="address">Schedule:</label>
            <div x-ref="calendar" class="bg-white h-[300px]"></div>

        </div>

        <input type="checkbox" id="my_modal_1" x-model="my_modal_1" class="modal-toggle" />
        <div class="modal" role="dialog">
            <div class="modal-box">
                <label class="form-control w-full max-w-xs">
                    <span class="label-text">Start Time</span>
                    <input type="time" x-model="start" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                </label>
                <label class="form-control w-full max-w-xs">
                    <span class="label-text">End Time</span>
                    <input type="time" x-model="end" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                </label>
                <div class="modal-action">
                    <button type="button" x-on:click="submitForm">submit</button>
                    <label for="my_modal_1" class="btn">Close!</label>
                </div>
            </div>
        </div>


    </section>
</div>
</x-dynamic-component>
@script
    <script>
        Alpine.data('dropdown', () => ({
            open: false,
            calendar: null,
            xx: 'xx',
            start: '',
            end: '',
            schedule: [],
            dates: '',
            available: [],
            my_modal_1: '',

            toggle() {
                this.open = !this.open
            },
            submitForm() {

                if (!this.start || !this.end) {
                    alert('Please fill in both start and end times.');
                    return;
                } else {

                    var self = this;
                self.my_modal_1 = false;
                var x = {
                    date: self.dates,
                    start: self.start,
                    end: self.end,

                };



                this.schedule.push(x)
                this.available.push({

                    title: 'Available',
                    display: 'block',
                    start: self.dates,
                    backgroundColor: '#2986cc'
                })
                this.start = '';
                this.end = '';
                this.showCalendar();
                }


            },
            changeDate(date) {
                this.dates = date;
            },
            showCalendar() {

                // var evt = datas.map(function(value) {
                //     this.available.push()
                //     // return ;

                // })

                var self = this;
                this.calendar = new Calendar(this.$refs.calendar, {
                    plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],

                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today'
                    },
                    events: self.available,
                    hiddenDays: [0],
                    validRange: function(nowDate) {
                        // Calculate the current date
                        var now = new Date(nowDate);

                        // Set the valid range to start from the current date
                        return {
                            start: now.toISOString().split("T")[
                                0], // Format: YYYY-MM-DD
                        };
                    },

                    // validRange: {
                    //     start: '2024-01-11'
                    // }
                })
                this.calendar.render()


                this.calendar.on('dateClick', function(info) {


                    const isDateAvailable = self.available.some(item =>

                        item.start === info.dateStr
                    );

                    if (isDateAvailable) {
                        const updatedScheduleArray = self.available.filter(item =>
                            !(item.start === info.dateStr)
                        );
                        self.available = updatedScheduleArray;
                        self.showCalendar();
                    } else {
                        // self.$refs.ss.click();
                        self.my_modal_1 = true;
                        self.dates = info.dateStr
                    }
                });

                this.calendar.on('eventClick', function(info) {

                    var date = new Date(info.event.start);
                    var newDate =
                        `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate()}`;

                    const isDateAvailable = self.available.some(item =>

                        item.start === newDate
                    );
                    console.log(isDateAvailable)
                    if (isDateAvailable) {
                        const updatedScheduleArray = self.available.filter(item =>
                            !(item.start === newDate)
                        );
                        self.available = updatedScheduleArray;
                        self.showCalendar();
                    } else {
                        self.my_modal_1 = true;
                        self.dates = newDate
                    }
                });

            },
            async init() {
                setTimeout(() => {
                     this.showCalendar([]);
                }, 1000);

                this.$watch('schedule', (value) =>    $wire.set('{{ $getStatePath("schedule") }}', JSON.stringify(value)) )
                this.$watch('available', (value) => console.log("available:"+value))




                // const myModalAlternative = new bootstrap.Modal(this.$refs.exampleModal)


            }
        }))
    </script>
@endscript
