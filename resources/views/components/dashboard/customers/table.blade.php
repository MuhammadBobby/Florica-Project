@php
    use App\Enums\RoleUser;
@endphp
@props(['customers'])

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    <table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    No.
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Nama
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    No. Telepon
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Role
                </th>
                <th scope="col" class="px-6 py-3 font-medium text-center">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $index => $cust)
                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                    <th scope="row" class="w-fit px-6 py-4 font-medium text-heading max-w-xs">
                        {{ $index + 1 + ($customers->currentPage() - 1) * $customers->perPage() }}
                    </th>
                    <td class="px-6 py-4 font-semibold flex items-center gap-2">
                        <img src="{{ $cust->avatar ? asset('storage/' . $cust->avatar) : asset('assets/elements/avatar.webp') }}"
                            alt="Avatar {{ $cust->full_name }}" class="w-10 h-10 rounded-full object-cover shadow-xs">
                        {{ $cust->full_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $cust->email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $cust->phone }}
                    </td>
                    <td class="px-6 py-4 uppercase font-semibold">
                        {{ $cust->role }}
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-4">

                            {{-- Detail --}}
                            @if ($cust->role === RoleUser::Customer)
                                <a href="{{ route('customers.show', $cust) }}"
                                    class="text-yellow-500 hover:text-yellow-600" title="Detail">
                                    <svg class="w-6 h-6 aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('customers.destroy', $cust) }}" method="POST" class="delete-form">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 hover:text-red-700 cursor-pointer"
                                    title="Hapus">

                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 3V4H4V6H5V19C5 20.1 5.9 21 7 21H17C18.1 21 19 20.1 19 19V6H20V4H15V3H9ZM7 6H17V19H7V6Z" />
                                    </svg>

                                </button>

                            </form>

                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
