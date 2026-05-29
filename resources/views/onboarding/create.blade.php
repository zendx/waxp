<x-guest-layout>
    <form method="POST" action="{{ route('onboarding.store') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="store_name" :value="__('Store name')" />
            <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name"
                value="{{ old('store_name') }}" required autofocus />
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="subdomain" :value="__('Store subdomain')" />
            <div class="flex items-center gap-2">
                <x-text-input id="subdomain" class="block mt-1 w-full" type="text" name="subdomain"
                    value="{{ old('subdomain') }}" required />
                <span class="mt-1 text-sm text-gray-500">.{{ env('TENANCY_BASE_DOMAIN', 'waxp.test') }}</span>
            </div>
            <x-input-error :messages="$errors->get('subdomain')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-primary-button>
                {{ __('Create store') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
