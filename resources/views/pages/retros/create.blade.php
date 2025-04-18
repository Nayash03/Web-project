<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Créer une rétrospective</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto mt-6 bg-white shadow p-6 rounded-xl">
        <form method="POST" action="{{ route('retro.store') }}">
            @csrf

            <!-- Name of the retro -->
            <div class="mb-4">
                <label for="title" class="block font-medium text-gray-700">Titre de la rétro</label>
                <input type="text" name="title" id="title" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <!-- Select cohort -->
            <div class="mb-4">
                <label for="cohort_id" class="block font-medium text-gray-700">Promotion</label>
                <select name="cohort_id" id="cohort_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">-- Choisissez une promotion --</option>
                    @foreach($cohorts as $cohort)
                        <option value="{{ $cohort->id }}">{{ $cohort->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Column  -->
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Colonnes du Kanban</label>
                <div id="columns-container">
                    <input type="text" name="columns[]" placeholder="Ex: Ce qui a bien fonctionné"
                        class="mt-2 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <button type="button" onclick="addColumnInput()"
                    class="mt-2 px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Ajouter une colonne
                </button>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Créer la rétro
                </button>
            </div>
        </form>
    </div>

    <script>
        function addColumnInput() {
            const container = document.getElementById('columns-container');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'columns[]';
            input.placeholder = 'Nom de la colonne';
            input.className = 'mt-2 block w-full rounded-md border-gray-300 shadow-sm';
            input.required = true;
            container.appendChild(input);
        }
    </script>
</x-app-layout>
