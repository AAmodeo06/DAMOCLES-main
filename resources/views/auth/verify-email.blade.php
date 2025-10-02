<x-guest-layout>
    <div class="mb-4 text-sm text-sky-600">
        @lang('auth.verifyEmail.message')</div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            @lang('auth.verifyEmail.new')</div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    @lang('auth.verifyEmail.resend')
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-sky-600 hover:text-sky-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500">
                @lang('auth.verifyEmail.logout')
            </button>
        </form>
    </div>
</x-guest-layout>
