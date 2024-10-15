@extends('layouts.header')
@section('title', 'OCMIS | Shop')

<style>
    .center-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .transparent-box {
        /* Add any additional styling you want for the transparent box */
        background-color: #fff;
        padding: 20px;
    }
</style>
@section('content')
    <section x-data="dropdown">
        <div class="sidebar">
            <ul class="sidebar-nav">
                <li class="{{ request()->is('admin/services/category*') ? 'active' : '' }}">
                    <a href="{{ route('services') }}">Category
                    </a>
                </li>
                <li class="{{ request()->is('admin/services/priest*') ? 'active' : '' }}">
                    <a href="{{ route('priests') }}">Priest
                    </a>
                </li>
                <li class="{{ request()->is('admin/services/service*') ? 'active' : '' }}">
                    <a href="{{ route('serviceList') }}">Service Transactions
                    </a>
                </li>
                <li class="{{ request()->is('admin/services/sale*') ? 'active' : '' }}">
                    <a href="{{ route('serviceSales') }}">Sales
                    </a>
                </li>
            </ul>
        </div>

        <div class="center-container " style=" 0px ;z-index: 50">
            {{-- transparent-box --}}
            <div class=" transparent-box "
                style="margin: 10rem 0px 10rem;z-index: 50;padding:3rem;height: fit-content;width: fit-content;margin: 0 auto">
                @if (session('success'))
                    <div class="alert alert-success"
                        style="background-color: #dff0d8; border-color: #d0e9c6; color: #3c763d; padding: 10px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger"
                        style="background-color: #f2dede; border-color: #ebccd1; color: #a94442; padding: 10px; margin-bottom: 20px">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="">
                    <h2>CREATE PRIEST</h2>

                    <form action="{{ route('postCreatePriest') }}" class="d-flex justify-content-between  gap-10"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="schedule" x-model="JSON.stringify(schedule)">
                        <div class="col-6">
                            <label for="name">PRIEST NAME: <input type="text" id="name" name="name"
                                    required></label>
                            <label for="contactnumber">CONTACT NUMBER: <input type="text" id="contactnumber"
                                    name="contactnumber" required></label>
                            <label for="address">ADDRESS: <input type="text" id="address" name="address"
                                    required></label>

                            <label for="status">STATUS:
                                <select id="status" name="status">
                                    <option value="Active">ACTIVE</option>
                                    <option value="Inactive">INACTIVE</option>
                                </select>
                            </label>
                        </div>
                        <div lass="col-6">
                            <label for="address">Schedule:</label>
                            <div x-ref="calendar" class="bg-white"></div>
                            <!-- Button trigger modal -->
                            <button type="button" x-ref="ss" style="display: none" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Launch demo modal
                            </button>
                            <button class="submit-button" type="submit" style="margin-left: 100px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="189" height="63" viewBox="0 0 189 63"
                                    fill="none">
                                    <path d="M0 0H189V63H0V0Z" fill="url(#paint0_linear_104_94)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_104_94" x1="109.941" y1="-2.26211e-08"
                                            x2="109.941" y2="63" gradientUnits="userSpaceOnUse">
                                            <stop offset="0.911458" stop-color="#23231F" />
                                            <stop offset="1" stop-color="#6A4D4D" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg><span>CREATE</span>
                            </button>
                        </div>
                    </form>



                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form x-on:submit.prevent="submitForm" class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Set-TIme</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="d-grid">
                            <div class="text-start">
                                <label for="" class="text-start">Start Time</label>
                                <input type="time" x-model="start" class="form-control" required>
                            </div>
                            <div class="text-start">
                                <label for="" class="text-start">End Time</label>
                                <input type="time" x-model="end" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" x-ref="closeModal"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </section>




@endsection

@push('jss')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dropdown', () => ({
                open: false,
                calendar: null,
                xx: 'xx',
                start: '',
                end: '',
                schedule: [],
                dates: '',
                available: [],
                toggle() {
                    this.open = !this.open
                },
                submitForm() {
                    var self = this;
                    this.$refs.closeModal.click();
                    var x = {
                        date: self.dates,
                        start: self.start,
                        end: self.end,

                    };

                    console.log(JSON.stringify(x))
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
                        console.log(isDateAvailable)
                        if (isDateAvailable) {
                            const updatedScheduleArray = self.available.filter(item =>
                                !(item.start === info.dateStr)
                            );
                            self.available = updatedScheduleArray;
                            self.showCalendar();
                        } else {
                            self.$refs.ss.click();
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
                            self.$refs.ss.click();
                            self.dates = newDate
                        }
                    });
                },
                init() {
                    this.showCalendar([]);

                    this.$watch('schedule', (value) => console.log(value))




                    // const myModalAlternative = new bootstrap.Modal(this.$refs.exampleModal)


                }
            }))
        })
    </script>
@endpush
