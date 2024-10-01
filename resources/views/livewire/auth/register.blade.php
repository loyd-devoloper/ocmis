<div>
    <x-customer.header />

    <form action="" class="bg-darkGray card max-w-xl mx-auto mt-20 p-5">
       <h2 class="text-white text-2xl font-medium pb-2"> Sign Up</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Last Name</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">First Name</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Middle Name</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Email</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Contact Number</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
            <label class="form-control w-full">
                <div class="label">
                    <span class="label-text">Username</span>

                </div>
                <input type="text" class="input input-bordered w-full " />
               @error('username')
                    <span class="label-text-alt text-red-500">Bottom Left label</span>
               @enderror
            </label>
        </div>
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Address</span>

            </div>
            <input type="text" class="input input-bordered w-full " />
           @error('username')
                <span class="label-text-alt text-red-500">Bottom Left label</span>
           @enderror
        </label>


        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">password</span>

            </div>
            <input type="text"  class="input input-bordered w-full " />
           @error('username')
                <span class="label-text-alt text-red-500">Bottom Left label</span>
           @enderror
        </label>
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Confirm password</span>

            </div>
            <input type="text"  class="input input-bordered w-full " />
           @error('username')
                <span class="label-text-alt text-red-500">Bottom Left label</span>
           @enderror
        </label>

        <button class="btn btn-info w-full mt-4">Register</button>
        <p class="text-center pt-8">Have an account?<a href="{{ route('login') }}"class="link link-primary link-hover font-bold">Sign In</a></p>
    </form>
</div>
