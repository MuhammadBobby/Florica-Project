<x-layouts.auth title="Login" type="login">
    <form class="max-w-sm mx-auto mt-8">
        {{-- Email --}}
        <x-forms.label-input for="email" label="Email" type="email" placeholder="example@gmail" isRequired isFocus />

        {{-- Password --}}
        <x-forms.label-input for="password" label="Password" type="password" placeholder="••••••••" isRequired />

        <x-forms.button type="submit">
            Login
        </x-forms.button>
    </form>
</x-layouts.auth>
