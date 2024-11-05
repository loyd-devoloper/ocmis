<div>
    <x-customer.header>



        {{-- section --}}
        <main class="container mx-auto p-6">
            <section class="bg-white p-8 rounded shadow-md">
                <img src="{{ asset('Asset/Picture2.jpg') }}" class="float-right rounded-md" alt="">
                <h2 class="text-3xl font-bold mb-4">About Us</h2>
                <p class="mb-4">Welcome to the Online Columbarium Management and Information System (OCMIS)—your modern solution for efficient and compassionate columbarium management.</p>
                <p class="mb-4">At OCMIS, we understand the importance of honoring and remembering loved ones in a peaceful and organized environment. Our platform provides a seamless and user-friendly system for managing columbarium spaces, allowing families and individuals to reserve, locate, and manage columbarium units with ease.</p>
                <h3 class="text-2xl font-bold mb-2">Key Features:</h3>
                <ul class="list-disc list-inside mb-4">
                    <li class="mb-2"><strong>Online Reservations:</strong> Reserve columbarium niches from the comfort of your home.</li>
                    <li class="mb-2"><strong>Secure Payments:</strong> Multiple payment options, including cash and digital transactions.</li>
                    <li class="mb-2"><strong>Product Access:</strong> Easily purchase necessary products like candles, flowers, and other memorial items directly through the platform.</li>
                    <li class="mb-2"><strong>Information Management:</strong> Authorized users can privately access and manage columbarium unit records, ensuring data privacy and security.</li>
                </ul>
                <p>OCMIS is designed to bring peace of mind during a sensitive time, offering a respectful and well-managed environment for the eternal rest of your loved ones.</p>
            </section>
        </main>

    </x-customer.header>
</div>

@script
    <script>
        Alpine.data('dropdown', (invoice, ref) => ({
            invoice: invoice,
            ref: ref,

            init() {
                var self = this;
                this.$watch('invoice', function(val) {
                    if (val) {
                        console.log(val)
                        self.$refs.modal.showModal();
                    }
                })
            }
        }))
    </script>
@endscript
