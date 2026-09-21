<div class="account-settings-page">
    <div class="account-settings-card">
        <div class="account-settings-nav">
            <flux:navlist aria-label="{{ __('Settings') }}">
                <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
                <flux:navlist.item :href="route('security.edit')" wire:navigate>{{ __('Security') }}</flux:navlist.item>
                <flux:navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="account-settings-content">
            <div class="account-settings-heading">
                <flux:heading>{{ $heading ?? '' }}</flux:heading>
                <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
            </div>

            <div class="account-settings-form">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
