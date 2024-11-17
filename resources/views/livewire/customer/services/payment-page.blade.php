<div>
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">Ocmis Services</p>
                <p class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        {{-- section --}}
        <section x-data="dropdown(@js($schedules))" class="p-10">


            <form wire:submit="submit" class="card bg-white max-w-screen-sm mx-auto p-4 space-y-4">
                <span class="text-sm pb-5"><strong>Reminder:</strong> Please note that if payment is not received within
                    one day, your transaction will be canceled by the admin.</span>
                <img src="{{ asset('storage/' . $service?->image) }}"
                    class="min-h-[8rem] mx-auto max-w-[8rem] min-w-[8rem] max-h-[8rem]" alt="">
                <p class="text-center border border-black p-2 rounded">{{ $service?->name }}</p>
                <p class="text-center border border-black p-2 rounded">₱{{ $service?->price }}</p>
                <label class="form-control w-full ">

                    <span class="label-text"> DECEASED NAME: </span>
                    <input type="text" placeholder="Type here" class="input input-bordered w-full " wire:model="deceasedname" required/>

                </label>
                <label class="form-control w-full ">
                    <span class="label-text"> MESSAGE: </span>
                    <textarea placeholder="Type here" class="textarea textarea-bordered h-24" wire:model="message" required></textarea>
                </label>

                <div class="flex items-center gap-1">
                      <label for="ownPriest" class="label-text ">Own Priest: </label>
                      <input type="checkbox" x-model="own_priest" id="ownPriest" wire:model="own_priest" />
                  </div>
                  <label x-show="own_priest" class="form-control w-full ">

                    <span class="label-text"> PRIEST NAME: </span>
                    <input type="text" placeholder="Type here" class="input input-bordered w-full " wire:model="priest_name" required/>

                </label>
                  <div x-show="own_priest" class="mb-3">
                    <label>Schedule: </label>
                    {{ $this->form }}
                    {{-- <input type="datetime-local" wire:model="date" class="form-control" min="2024-10-29"  :required="own_priest == true ? true : false"> --}}
                </div>

                <div x-show="own_priest == false" class="mb-3" id="priestDropdown">
                    <label for="priest" class="form-label">Priest</label>
                    <select x-model="priest" wire:model="priest_id" id="priest" class="form-select" :required="own_priest == false ? true : false">
                        <option value="" selected>-- Select --</option>
                        @foreach ($priests as $priest)
                            <option value="{{ $priest->id }}">Fr. {{ $priest->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div x-show="showSched && own_priest == false" class="mb-3" id="priestDropdown">
                    <label for="priest" class="form-label">Priest Schedules <span class="text-secondary">(Date -- Start Time TO End Time)</span></label>
                    <select class="form-select" wire:model="schedule" id="priest" :required="own_priest == false ? true : false">
                        <option value="" selected>-- Select --</option>


                        <template x-for="(v,i) in sched || []" x-key="i">
                            <option :value="v.id" x-text="changeName(v.date,v.start_time,v.end_time)"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <h1 class="text-xs">PAYMENT METHOD</h1>
                    <div class="form-control w-fit  text-xs">
                        <label class="label cursor-pointer">

                            <input type="radio" name="radio-10" wire:model="payment_method" value="Cash"
                                class="radio radio-xs mr-1" required/>Cash
                        </label>
                    </div>
                    <div class="form-control w-fit  text-xs">
                        <label class="label cursor-pointer">

                            <input type="radio" name="radio-10" wire:model="payment_method" value="Gcash"
                                class="radio radio-xs  mr-1" required/>Gcash
                        </label>
                    </div>
                </div>
                <button class="btn btn-primary btn-md">Submit</button>
            </form>
        </section>
    </x-customer.header>
</div>

@script
<script>
       Alpine.data('dropdown', (schedules) => ({
                open: false,
                schedules: schedules,
                own_priest: false,
                priest: '',
                sched: [],
                showSched: false,
                changeName(date, start, end) {

                    return `${date} -- ${this.changeTIme(start)} TO ${this.changeTIme(end)}`;
                },
                changeTIme(time) {
                    var timeArray = time.split(':');
                    var hours = parseInt(timeArray[0], 10);
                    var minutes = parseInt(timeArray[1], 10);

                    // Determining AM or PM
                    var period = (hours >= 12) ? "PM" : "AM";

                    // Converting hours to 12-hour format
                    hours = (hours > 12) ? hours - 12 : hours;
                    hours = (hours == 0) ? 12 : hours;

                    // Creating the 12-hour time string
                    var time12Hour = hours.toString().padStart(2, '0') + ':' + minutes.toString()
                        .padStart(2, '0') + ' ' + period;

                    return time12Hour;
                },
                init() {
                    var self = this;

                    this.$watch('priest', (value) => {
                        console.log(value)
                        if (!!value) {
                            self.showSched = [];

                            var x = self.schedules.filter((val) => {
                                return val.priest_id == value;
                            })
                            self.sched = x;
                            self.showSched = true;


                        } else {
                            self.showSched = [];
                            self.showSched = false;

                        }
                    })



                }
            }))
</script>

@endscript
