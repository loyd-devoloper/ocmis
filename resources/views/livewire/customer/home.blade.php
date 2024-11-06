<div x-data="main">
    <x-customer.header>
        <div class="w-full bg-darkGray min-h-[40svh] text-white flex justify-center items-center">
            <div>
                <p class="text-center text-4xl font-bold">OCMIS: Online Columbarium Management and Information System</p>
                <p  class="text-center text-xl">Guiding You Through Moments of Remembrance</p>
            </div>
        </div>


        <div class="swiper m-4  " x-ref="container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper  min-h-[50svh]  max-h-[50svh]  ">
                <!-- Slides -->
                <div class="swiper-slide relative !flex !justify-center !h-full ">
                    <img class="min-h-[40svh] max-h-[40svh]"
                    src="{{ asset('Asset/9eebdb4e-0bc2-4a8d-b7d4-94ed19c3be6b.jfif') }}"
                    alt="carousel image"  />
                </div>
                <div class="swiper-slide relative !flex !justify-center !h-full ">
                    <img class="min-h-[40svh] max-h-[40svh]"
                    src="{{ asset('Asset/columbarium2.png') }}"
                    alt="carousel image"  />
                </div>
                <div class="swiper-slide relative !flex !justify-center !h-full ">
                    <img class="min-h-[40svh] max-h-[40svh]"
                    src="{{ asset('Asset/columbarium3.png') }}"
                    alt="carousel image"  />
                </div>




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
