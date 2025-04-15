<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Rétrospective - {{ $retro->title }}</h1>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 bg-white shadow p-6 rounded-xl">

        <!-- Liste des colonnes du Kanban -->
        <div id="kanban-container" class="flex overflow-x-auto space-x-4">
            @foreach($retro->columns as $column)
                <div class="kanban-column bg-gray-100 p-4 rounded-lg w-1/4">
                    <h2 class="font-semibold text-xl mb-4">{{ $column->name }}</h2>
                    <div class="kanban-cards">
                        @foreach($column->cards as $card)
                            <div class="kanban-card bg-white p-4 mb-2 rounded shadow-md">
                                <p>{{ $card->content }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="kanban-card-input mt-4">
                    <form action="{{ route('cards.store', ['retro' => $retro->id, 'column' => $column->id]) }}" method="POST">
                        @csrf
                        <input type="text" name="content" class="w-full p-2 rounded" placeholder="Ajouter une carte..." required>
                        <button type="submit" class="mt-2 w-full bg-blue-600 text-white rounded py-2">Ajouter</button>
                    </form>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Intégration de la librairie KanbanJS -->
    <script src="https://cdn.jsdelivr.net/npm/kanban-js@2.0.0/dist/kanban.min.js"></script>

    <script>
        // Code pour initialiser KanbanJS si tu veux l'utiliser dynamiquement
        document.addEventListener("DOMContentLoaded", function() {
            var kanban = new jKanban({
                element: '#kanban-container',
                boards: [
                    @foreach($retro->columns as $column)
                    {
                        'id': '{{ $column->id }}',
                        'title': '{{ $column->name }}',
                        'item': [
                            @foreach($column->cards as $card)
                            { 'title': '{{ $card->content }}' },
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            });
        });
    </script>
</x-app-layout>
