<x-layouts.guest title="Login">
    @push('styles')
        <style>
            .error {
                color: red;
                margin-block: 10px;
            }
        </style>
    @endpush

    <div class="flex min-h-screen items-center justify-center px-4">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-sm">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold">Welcome Back</h1>
                <p class="mt-2 text-sm text-gray-500">
                    Sign in to your account
                </p>
            </div>

            {{-- Success Alert --}}
            @if (session()->has('success'))
                <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Danger/Error Alert --}}
            @if (session()->has('error'))
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <div class="mb-4">
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-lg border-gray-300 px-4 py-2.5 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                    >

                    @error('email')
                        <span class="my-2 block text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-6">
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
                        <span class="my-2 block text-red-600">{{ $message }}</span>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800"
                >
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-gray-900 hover:underline">
                    Register
                </a>
            </p>

        </div>
    </div>
</x-layouts.guest>