<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Retrospectives') }}

                @php
                    $isAdmin = auth()->user()->hasAdminRole();
                @endphp

                @if($isAdmin)
                    <button onclick="window.location='{{ route('retro.create') }}'" class="btn btn-primary">
                        Créer une rétrospective
                    </button>
                @endif

                

            </span>
        </h1>
    </x-slot>
</x-app-layout>
