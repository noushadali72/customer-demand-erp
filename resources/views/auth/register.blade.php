<x-layouts.guest title="Register">
    @push('styles')
        <style>
            .error{
                color:red;
                margin-block: 10px;
            }
        </style>
    @endpush
    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-sm">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold">Create Account</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Create your account to get started
                </p>
            </div>

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                        Name
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        required
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                      @error('name')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>


                                <div class="mb-4">
                    <label for="name" class="mb-1 block text-sm font-medium text-gray-700">
                        Username
                    </label>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        required
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                      @error('username')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        required
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                      @error('email')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                      @error('password')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >
                      @error('password_confirmation')
                        <span class="error">{{$message}}</span>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Already have an account?
                <a href="{{ route('login') }}" class="font-medium text-gray-900 hover:underline">
                    Login
                </a>
            </p>

        </div>
    </div>
</x-layouts.guest>