<div >
    <x-customer.header>


        <div>
            <div class="container mx-auto mb-5 mt-5 h-full">
                <div class="flex gap-10 h-full">
                    <div class="w-full lg:w-2/3 h-full">
                        <div class="bg-white shadow-lg rounded-lg h-full">
                            <div class="p-6">
                                <img src="{{ asset('Asset/candles.jpg') }}" class="w-full h-72 object-cover" alt="Building Image">
                                <h3 class="text-center text-2xl font-semibold mt-4">{{$memorial->deceased_name}}'s Memorial</h3>
                                <p class="mt-2">
                                    Welcome to {{$memorial->deceased_name}}'s memorial. This space is dedicated to the memory of
                                    {{$memorial->deceased_name}}. Share your thoughts, memories, and condolences with family and friends.
                                </p>

                                <p class="mt-2">
                                    Date of Event: {{ \Carbon\Carbon::parse($memorial->date_time)->format('Y-m-d') }}
                                    <br>
                                    Time: {{ \Carbon\Carbon::parse($memorial->date_time)->format('h:i A') }}
                                </p>

                                <p class="mt-2">
                                    Event Details: Join us in commemorating {{$memorial->deceasedname}}. Feel free to leave
                                    messages, photos, and share your favorite memories.
                                    We will also be hosting a Zoom meeting to connect virtually. The meeting details are as follows:
                                </p>

                                <p class="mt-2">
                                    Zoom Meeting:
                                    @if(strtotime($memorial->date_time) > now()->timestamp)
                                        <span>Meeting Has Not Started Yet</span>
                                    @elseif(strtotime($memorial->date_time) < strtotime('-40 minutes', now()->timestamp))
                                        <span>Zoom Meeting Ended</span>
                                    @else
                                        <a href="{{$memorial->link}}" target="_blank" class="text-blue-600 hover:underline">Join Zoom Meeting</a>
                                    @endif
                                    <br>
                                    Pass: {{ $memorial->password }}
                                </p>

                                <p class="mt-2">
                                    Please join us to celebrate the life of {{$memorial->deceasedname}} and share in the love and
                                    support of friends and family.
                                </p>

                                <p class="mt-2">
                                    <strong>Note:</strong> The memorial Zoom link is valid for 40 minutes and expires thereafter.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/3 h-full">
                        <div class="flex h-1/2 mb-2">
                            <div class="w-full">
                                <div class="bg-white shadow-lg rounded-lg h-full">
                                    <div class="p-6">
                                        <h5 class="text-xl font-semibold">Photos</h5>
                                        <div class="p-1 h-full">
                                            <swiper-container class="mySwiper" pagination="true" effect="coverflow"
                                                grab-cursor="true" centered-slides="true" slides-per-view="auto"
                                                coverflow-effect-rotate="50" coverflow-effect-stretch="0"
                                                coverflow-effect-depth="100" coverflow-effect-modifier="1"
                                                coverflow-effect-slide-shadows="true">
                                                <swiper-slide>
                                                    <div class="flex justify-center items-center">
                                                        <img src="/storage/{{$memorial->images}}" class="h-52 w-64 object-cover" alt="Building Image">
                                                    </div>
                                                </swiper-slide>
                                                {{-- @foreach ($images as $img )

                                                @endforeach --}}
                                            </swiper-container>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex h-1/2">
                            <div class="w-full">
                                <div class="bg-white shadow-lg rounded-lg h-full">
                                    <div class="p-6">
                                        <h5 class="text-xl font-semibold">Message from Event Organizer</h5>
                                        <p class="mt-2">
                                            Dear friends and family,
                                        </p>

                                        <p class="mt-2">
                                            On behalf of the event organizer, we would like to express our gratitude for joining us
                                            in celebrating {{$memorial->deceasedname}}'s life.
                                            Your presence and support mean a lot to us and to the family during this time of
                                            remembrance.
                                        </p>

                                        <p class="mt-2">
                                            If you have any questions or need assistance during the event, feel free to contact the
                                            organizer.
                                            We hope you find comfort and solace in the
                                            shared memories and stories that will be cherished during this memorial.
                                        </p>
                                        <p class="mt-2">P.S {{$memorial->message}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-customer.header>

</div>
