<x-layouts.auth title="Register" type="register">
    <form class="max-w-sm mx-auto mt-5">
        <div class="max-h-[40vh] overflow-auto px-0.5">
            {{-- Name --}}
            <x-forms.label-input for="name" label="Nama" type="text" placeholder="Jhon Doe" isRequired isFocus />

            {{-- Phone --}}
            <x-forms.label-input for="phone" label="Phone" type="text" placeholder="08123456789" isRequired />

            {{-- Email --}}
            <x-forms.label-input for="email" label="Email" type="email" placeholder="example@gmail" isRequired />

            {{-- Password --}}
            <x-forms.label-input for="password" label="Password" type="password" placeholder="••••••••" isRequired />

            {{-- Confirm Password --}}
            <x-forms.label-input for="password_confirmation" label="Confirm Password" type="password"
                placeholder="••••••••" isRequired />

            {{-- Avatar --}}
            <x-forms.label-input for="avatar" label="Avatar" type="file" placeholder="Pilih file gambar" />
        </div>

        <x-forms.button type="submit" buttonLabel="Register" />
    </form>

</x-layouts.auth>
