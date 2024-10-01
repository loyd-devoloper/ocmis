<div>
    <x-customer.header />

    <form action="" class="bg-darkGray card max-w-md mx-auto mt-20 p-5">
       <h2 class="text-white text-2xl font-medium pb-2"> Sign In</h2>
        <label class="form-control w-full">
            <div class="label">
                <span class="label-text">Username</span>

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
       <div class="flex justify-end">
        <a href=""class="link link-primary">Forget Password?</a>
       </div>
        <button class="btn btn-info w-full mt-4">Login</button>
        <p class="text-center pt-8">Don't have an account?<a href="{{ route('register') }}" class="link link-primary link-hover font-bold">Sign Up</a></p>
    </form>
</div>
