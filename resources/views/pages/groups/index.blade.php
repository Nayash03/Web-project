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

            
            <form method="POST" action="{{ route('group.index') }}"> <!-- Ou la route que tu veux -->
            @csrf  <!-- Assure-toi d'inclure CSRF token si tu soumets un formulaire -->

            <label for="cohort_id">Sélectionner une promotion :</label>
            <select name="cohort_id" id="cohort_id" class="form-control">
                <option value="">-- Choisissez une promotion --</option>
                
                @foreach($cohorts as $cohort)
                    <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                @endforeach
            </select>

            <button type="submit">Envoyer</button>
</form>






            <p>Nombre d'étudiant par groupe :</p>

        @endif







    



        

    </x-slot>
</x-app-layout>
