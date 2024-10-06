<div>
    <x-customer.header>
        <form wire:submit="register" class="bg-white card max-w-xl mx-auto my-20 p-5">
            <h2 class=" text-2xl font-medium pb-2"> Sign Up</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Last Name</span>

                    </div>
                    <input type="text" wire:model="lname" class="input input-bordered w-full " />
                    @error('lname')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">First Name</span>

                    </div>
                    <input type="text" wire:model="fname" class="input input-bordered w-full " />
                    @error('fname')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Middle Name</span>

                    </div>
                    <input type="text" wire:model="mname" class="input input-bordered w-full " />
                    @error('mname')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email</span>

                    </div>
                    <input type="text" wire:model="email" class="input input-bordered w-full " />
                    @error('email')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Contact Number</span>

                    </div>
                    <input type="text" wire:model="contact" class="input input-bordered w-full " />
                    @error('contact')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Username</span>

                    </div>
                    <input type="text" wire:model="username" class="input input-bordered w-full " />
                    @error('username')
                        <span class="label-text-alt text-red-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Address</span>

                </div>
                <input type="text" wire:model="address" class="input input-bordered w-full " />
                @error('address')
                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                @enderror
            </label>


            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">password</span>

                </div>
                <input type="password" wire:model="password" class="input input-bordered w-full " />
                @error('password')
                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                @enderror
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Confirm password</span>

                </div>
                <input type="password" wire:model="password_confirmation" class="input input-bordered w-full " />
                @error('password_confirmation')
                    <span class="label-text-alt text-red-500">{{ $message }}</span>
                @enderror
            </label>

            <button type="submit" class="btn btn-error text-white w-full mt-4">Register</button>
            <p class="text-center pt-8">Have an account? <a
                    href="{{ route('login') }}"class="link link-primary link-hover">Sign In</a></p>
        </form>
    </x-customer.header>
</div>
