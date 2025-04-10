<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Groupes') }}
                
            </span>
        </h1>


 

        
        @if(auth()->user()->hasAdminRole())

            <select class="select" name="select">
                <option value="1">
                    Option 1
                </option>
                <option value="2">
                    Option 2
                </option>
                <option value="3">
                    Option 3
                </option>
            </select>



            <p>Mot réservé aux admins</p>
        @endif







    



        

    </x-slot>
</x-app-layout>
