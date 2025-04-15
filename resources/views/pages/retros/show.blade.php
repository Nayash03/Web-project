<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-800">Rétrospective - {{ $retro->title }}</h1>
    </x-slot>

    <div class="max-w-6xl mx-auto mt-6 bg-white shadow p-6 rounded-xl">
        <!-- Conteneur Kanban -->
        <div id="kanban-container" class="overflow-x-auto"></div>
    </div>

    <!-- CDN jKanban v1.2.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jkanban@1.2.0/dist/jkanban.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jkanban@1.2.0/dist/jkanban.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const kanban = new jKanban({
                element: '#kanban-container',
                gutter: '15px',
                widthBoard: '300px',
                dragBoards: false,

                dropEl: function (el, target, source, sibling) {
                    const cardId = el.dataset.id;
                    const newColumnId = target.parentElement.dataset.id;

                    fetch(`/cards/${cardId}/move`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ column_id: newColumnId })
                    })
                    .then(res => res.json())
                    .then(data => console.log("Carte déplacée :", data))
                    .catch(err => console.error("Erreur :", err));
                },

                boards: [
                    @foreach($retro->columns as $column)
                    {
                        id: '{{ $column->id }}',
                        title: `<div>
                                    <div class='font-semibold text-lg mb-2'>{{ $column->name }}</div>
                                    <form action="{{ route('cards.store', ['retro' => $retro->id, 'column' => $column->id]) }}" method="POST">
                                        @csrf
                                        <input type="text" name="content" class="w-full p-2 border border-gray-300 rounded" placeholder="Ajouter une carte..." required />
                                        <button type="submit" class="mt-2 w-full bg-blue-600 text-white rounded py-1 text-sm">Ajouter</button>
                                    </form>
                                </div>`,
                        item: [
                            @foreach($column->cards as $card)
                            {
                                id: '{{ $card->id }}',
                                title: `<div class="p-3 bg-white rounded shadow" data-id="{{ $card->id }}">{{ $card->content }}</div>`,
                                class: "cursor-move",
                                dataset: { id: '{{ $card->id }}' }
                            },
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            });
        });
    </script>
</x-app-layout>
