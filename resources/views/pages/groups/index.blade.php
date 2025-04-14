<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-1 text-sm font-normal">
            <span class="text-gray-700">
                {{ __('Groupes') }}
                
            </span>
        </h1>


 

        
        @if(auth()->user()->hasAdminRole())

             
            <form method="POST" action="{{ route('group.generate') }}">
                @csrf

                <label for="cohort_id">Sélectionner une promotion :</label>
                <select name="cohort_id" id="cohort_id" class="form-control" required>
                    <option value="">-- Choisissez une promotion --</option>
                    @foreach($cohorts as $cohort)
                        <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                    @endforeach
                </select>

                <label for="group_size">Nombre de personnes par groupe :</label>
                <input type="number" name="group_size" id="group_size" class="form-control" required min="1">

                <button type="submit">Générer les groupes</button>
            </form>









            <p>Nombre d'étudiant par groupe :</p>

        @endif







    



        

    </x-slot>
</x-app-layout>
