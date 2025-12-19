<x-app-layout>
    <h2>Short URLs</h2>

    @can('create', App\Models\ShortUrl::class)
        <form method="POST" action="{{ route('short-urls.store') }}">
            @csrf
            <input type="url" name="original_url" placeholder="Original URL" required>
            <button type="submit">Create</button>
        </form>
    @endcan

    <ul>
        @foreach($urls as $url)
            <li>
                {{ $url->original_url }} →
                <a href="{{ url('/s/'.$url->short_code) }}" target="_blank">
                    {{ url('/s/'.$url->short_code) }}
                </a>
            </li>
        @endforeach
    </ul>
</x-app-layout>