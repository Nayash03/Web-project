<form method="POST" action="{{ route('mistral.ask') }}">
    @csrf
    <label for="prompt">Entrez un prompt :</label><br>
    <textarea name="prompt" id="prompt" rows="4" cols="60" required></textarea><br><br>
    <button type="submit">Envoyer</button>
</form>
