<div x-data="main">
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS Niches</p>
                <p  class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        <div class="swiper m-4  " x-ref="container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper min-h-[50svh]  max-h-[50svh]  ">
                <!-- Slides -->
                @foreach ($buildings as $building)
               <div class="swiper-slide">
                <a href="{{ route('niches.building',['id'=>$building->id]) }}" class=" relative !flex !justify-center !h-full ">
                    <img class="min-h-[40svh] max-h-[40svh]"
                    src="{{ asset('storage/'.$building?->image) }}"
                    alt="carousel image"  />
                </a>
                <h1 class="text-center">{{ $building->name }}</h1>
               </div>
                @endforeach




            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
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

                this.swiper = new Swiper(this.$refs.container, {
                    effect: 'coverflow',
                    slideShadows: true,
                    direction: 'horizontal',
                    loop: true,


                    pagination: {
                        el: '.swiper-pagination',
                    },


                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },

                })
                console.log('dsad')
            }
        }))
    </script>
@endscript
