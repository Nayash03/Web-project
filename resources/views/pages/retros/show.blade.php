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
                    const cardId = el.dataset.eid;
                    const newColumnId = target.closest('[data-id]')?.dataset.id;

                    if (!cardId || !newColumnId) return;

                    fetch(`/cards/${cardId}/move`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ column_id: newColumnId })
                    })
                    .then(res => res.json())
                    .then(data => console.log("✅ Carte déplacée :", data))
                    .catch(err => console.error("❌ Erreur :", err));
                },

                boards: [
                    @foreach($retro->columns as $column)
                    {
                        id: '{{ $column->id }}',
                        title: `
                            <div data-id="{{ $column->id }}">
                                <div class='font-semibold text-lg mb-2'>{{ $column->title }}</div>
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
                                title: `
                                    <div class="card-content p-3 bg-white rounded shadow cursor-move" data-eid="{{ $card->id }}">
                                        {{ $card->content }}
                                    </div>`,
                                class: "cursor-move",
                                dataset: { eid: '{{ $card->id }}' }
                            },
                            @endforeach
                        ]
                    },
                    @endforeach
                ]
            });

            // 🎯 Édition inline au double-clic
            document.addEventListener('dblclick', function (e) {
                const cardDiv = e.target.closest('.card-content');
                if (!cardDiv) return;

                const cardId = cardDiv.dataset.eid;
                const oldContent = cardDiv.textContent.trim();

                // Crée un champ input pour édition
                const input = document.createElement('input');
                input.type = 'text';
                input.value = oldContent;
                input.className = 'w-full border p-1 rounded';

                // Remplace le contenu par l'input
                cardDiv.innerHTML = '';
                cardDiv.appendChild(input);
                input.focus();

                // Sauvegarde au ENTER
                input.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const newContent = input.value.trim();

                        if (!newContent || newContent === oldContent) {
                            cardDiv.textContent = oldContent;
                            return;
                        }

                        fetch(`/cards/${cardId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ content: newContent })
                        })
                        .then(res => res.json())
                        .then(data => {
                            cardDiv.textContent = data.content || newContent;
                        })
                        .catch(err => {
                            console.error("❌ Erreur :", err);
                            cardDiv.textContent = oldContent;
                        });
                    }
                });

                // Annule l'édition au blur
                input.addEventListener('blur', function () {
                    cardDiv.textContent = oldContent;
                });
            });
        });
    </script>
</x-app-layout>
