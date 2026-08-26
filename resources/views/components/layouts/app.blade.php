<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">

    <div class="flex min-h-screen">

        {{-- Sidebar --}}
        <aside class="w-64 shrink-0 bg-gray-900 text-white">
            <div class="flex h-16 items-center border-b border-gray-800 px-6">
                <span class="text-lg font-semibold">
                    {{ config('app.name') }}
                </span>
            </div>

            <nav class="space-y-1 px-3 py-4">

                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-grid-alt text-xl"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('products.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-package text-xl"></i>
                    <span>Products</span>
                </a>

                <a href="{{ route('raw-materials.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-cube text-xl"></i>
                    <span>Raw Materials</span>
                </a>

                <a href="{{ route('units.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    {{-- <i class="bx bx-cube text-xl"></i> --}}
                    <i class="bx bx-ruler text-xl"></i>
                    <span>Units</span>
                </a>

                <a href="{{ route('manufacturing-formulas.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-receipt text-xl"></i>
                    <span>Manufacturing Formulas</span>
                </a>

                <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-store text-xl"></i>
                    <span>Vendors</span>
                </a>

                <a href="{{ route('purchase-requests.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-file text-xl"></i>
                    <span>Purchase Requests</span>
                </a>

                <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-file-find text-xl"></i>
                    <span>Quotations</span>
                </a>

                <a href="#"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-cart text-xl"></i>
                    <span>Purchase Orders</span>
                </a>

                <a href="{{ route('invoices.index') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-300 transition hover:bg-gray-800 hover:text-white">
                    <i class="bx bx-receipt text-xl"></i>
                    <span>Invoices</span>
                </a>

              

            </nav>
        </aside>


        {{-- Main Content --}}
        <div class="flex min-w-0 flex-1 flex-col">

            {{-- Header --}}
        <header class="flex h-16 items-center justify-between border-b bg-white px-6">
            <h1 class="text-lg font-semibold">
                {{ $title ?? 'Dashboard' }}
            </h1>

            {{-- User Menu --}}
            @auth
                <div class="flex items-center gap-4">

                    {{-- User Information --}}
                    <div class="text-right">
                        <div class="text-sm font-semibold text-gray-900">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-xs text-gray-500">
                            {{ Auth::user()->email }}
                        </div>
                    </div>

                    {{-- User Avatar --}}
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button type="submit"
                            class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">
                            <i class="bx bx-log-out text-xl"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            @endauth
        </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@4.0.0/dist/jquery.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
@stack('scripts')

</body>
</html>