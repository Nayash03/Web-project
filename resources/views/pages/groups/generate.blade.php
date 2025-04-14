<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Groupes') }}
                
            </span>
        </h1>


 

        
        @if(auth()->user()->hasAdminRole())

            

            
        
             
            









            <p>Nombre d'étudiant par groupe :</p>

        @endif







    



        

    </x-slot>
</x-app-layout>
