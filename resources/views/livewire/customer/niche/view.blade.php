<div x-data="main">
    <x-customer.header>
        <div class="max-w-screen-xl mx-auto p-6 text-white">
            <div class="bg-gray-700 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-lg font-semibold">
                            Niche:  {{ "$nicheInfo?->level - $nicheInfo?->niche_number" }}
                        </h2>
                        <p class="text-sm">
                            Location: {{ $nicheInfo?->buildingInfo?->name }}
                        </p>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/3">
                        <div class="bg-gray-600 p-4 rounded-lg text-center">
                            <img alt="Image of an urn" class="mx-auto mb-4 rounded-lg "
                                height="200"
                                src="{{ asset('Asset/urn.jpg') }}"
                                width="150" />
                            <h3 class="text-lg font-semibold">
                                Urn
                            </h3>
                            <p class="mt-2">
                               {{ $info ? "$info->fname $info->lname"  : ' [Firstname ,Lastname]' }}
                            </p>
                            <p class="text-sm mt-1">
                                {{ $info ? "$info->birthdate"  : ' [Birth Date]' }}

                            </p>
                            <p class="text-sm">
                                {{ $info ? "$info->deathdate"  : '[Death Date]' }}

                            </p>

                            <div class="mt-4  ">
                                {{ $this->modalFormAction }}
                            </div>

                        </div>
                    </div>
                    <div class="w-2/3 pl-6">
                        <h2 class="text-xl font-semibold mb-4">
                            In Loving Memory of Jose Rizal
                        </h2>
                        <div class="flex items-center mb-4">
                            @if ($info)
                            <img alt="Profile image placeholder" class="w-32 h-32 rounded-full mx-auto bg-gray-500"
                            height="100"
                            src="{{ asset('storage/'.$info->image) }}"
                            width="100" />
                            @else
                            <img alt="Profile image placeholder" class="w-32 h-32 rounded-full mx-auto bg-gray-500"
                            height="100"
                            src="https://storage.googleapis.com/a1aa/image/iBlIgq7Wv16xMBRLMJJcgDCbpekbu4mW1Y7VSuHmms95fVqTA.jpg"
                            width="100" />
                            @endif
                        </div>
                        <hr class="border-gray-500 mb-4" />
                        <p class="mb-4">
                            As we hold this urn, we hold not just the remains, but the cherished memories of a life
                            well-lived. {{ $info ? "$info->fname $info->lname" : "[Deceased Name]" }}'s laughter, kindness, and love will forever resonate in our
                            hearts.
                        </p>
                        <p class="mb-4">
                            Though we may part with the physical presence, the spirit of {{ $info ? "$info->fname $info->lname" : "[Deceased Name]" }} remains a
                            guiding light, illuminating our paths with warmth and wisdom.
                        </p>
                        <p class="mb-4">
                            May this urn serve as a vessel of remembrance, a sanctuary where love continues to bloom
                            eternally.
                        </p>
                        <p class="mb-4">
                            With deepest love and fondest memories,
                            <br />
                            {{ $info ? "$info->fname $info->lname" : " [Client's Name]" }}

                        </p>
                        <p>
                            Message from the family:
                            <br />
                            {{ $info ? "$info->message"  : ' [Message]' }}

                        </p>
                    </div>
                </div>
            </div>
        </div>


        <x-filament-actions::modals />

    </x-customer.header>
</div>
@script
    <script>
        Alpine.data('main', () => ({
            open: false,
            swiper: null,
            toggle() {
                this.open = !this.open
            },
            init() {


            }
        }))
    </script>
@endscript
