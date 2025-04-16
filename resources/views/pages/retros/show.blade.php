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
                    // Vérifie si l'élément (la carte) contient bien l'attribut 'data-eid' au lieu de 'data-id'
                    console.log("Carte déplacée", el);  // Débogue l'élément de la carte
                    const cardId = el.dataset.eid;  // Utilise data-eid au lieu de data-id
                    if (!cardId) {
                        console.error("Carte sans ID détectée !");
                        return;
                    }

                    // Vérifie si l'élément de la colonne contient bien l'attribut 'data-id'
                    console.log("Cible du déplacement", target);  // Débogue l'élément cible
                    const newColumnId = target.closest('[data-id]')?.dataset.id;
                    if (!newColumnId) {
                        console.error("Colonne sans ID détectée !");
                        return;
                    }

                    console.log("Déplacement de la carte", cardId, "vers la colonne", newColumnId); // Log les IDs pour déboguer

                    // Envoie la requête pour mettre à jour la carte dans la nouvelle colonne
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
                                title: `
                                    <div class="p-3 bg-white rounded shadow cursor-move" data-eid="{{ $card->id }}">  <!-- Changement ici : data-eid au lieu de data-id -->
                                        {{ $card->content }}
                                    </div>`,
                                class: "cursor-move",
                                dataset: { eid: '{{ $card->id }}' }  <!-- Changement ici : dataset.eid au lieu de dataset.id -->
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
