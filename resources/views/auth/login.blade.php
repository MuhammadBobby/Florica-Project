<x-layouts.auth title="Login" type="login">
    <form method="POST" action="{{ route('login.store') }}" class="max-w-sm mx-auto mt-8">
        @csrf

        {{-- Email --}}
        <x-forms.label-input for="email" label="Email" type="email" placeholder="example@gmail" isRequired isFocus />

        {{-- Password --}}
        <x-forms.label-input for="password" label="Password" type="password" placeholder="••••••••" isRequired />

        {{-- Remember --}}
        <div class="flex items-center">
            <input id="checkbox-remember" type="checkbox" name="remember" value=""
                class="w-4 h-4 text-primary border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-secondary">
            <label for="checkbox-remember" class="ms-2 text-sm font-medium text-heading">Remember me</label>
        </div>

        <x-forms.button type="submit">
            Login
        </x-forms.button>
    </form>
</x-layouts.auth>
