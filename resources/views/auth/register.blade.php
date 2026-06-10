<x-layouts.auth title="Register" type="register">
    <form method="POST" action="{{ route('register.store') }}" enctype="multipart/form-data" class="max-w-sm mx-auto mt-5">
        @csrf
        <div class="max-h-[40vh] overflow-auto px-0.5">
            {{-- Name --}}
            <x-forms.label-input for="full_name" label="Nama" type="text" placeholder="Jhon Doe" isRequired isFocus />

            {{-- Phone --}}
            <x-forms.label-input for="phone" label="Phone" type="text" placeholder="08123456789" maxlength="13"
                isRequired />

            {{-- Email --}}
            <x-forms.label-input for="email" label="Email" type="email" placeholder="example@gmail" isRequired />

            {{-- Password --}}
            <x-forms.label-input for="password" label="Password" type="password" placeholder="••••••••" minlength="8"
                isRequired />

            {{-- Confirm Password --}}
            <x-forms.label-input for="password_confirmation" label="Confirm Password" type="password"
                placeholder="••••••••" minlength="8" isRequired />

            {{-- Avatar --}}
            <x-forms.label-input for="avatar" label="Avatar" type="file" placeholder="Pilih file gambar" />
        </div>

        <x-forms.button type="submit">
            Register
        </x-forms.button>
    </form>

</x-layouts.auth>
