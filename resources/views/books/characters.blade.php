<x-app-layout>
    <div class="my-4">
        <form id="filterForm" method="GET" action="{{ route('books', ['type' => $type]) }}">
            <label for="category" class="sr-only">カテゴリ:</label>
            <select id="category" name="category" onchange="document.getElementById('filterForm').submit()">
                <option value="">全てのカテゴリ</option>
                <option value="Charm" @if(request('category')==='Charm') selected @endif>Charm</option>
                <option value="Spell" @if(request('category')==='Spell') selected @endif>Spell</option>
                <!-- 他のカテゴリのオプションを追加 -->
            </select>
        </form>
    </div>


    <div class="flex flex-wrap justify-between mx-auto py-8 w-4/5">
        @foreach($filteredDatas as $data)
        <div class="w-1/4 p-4 bg-orange-100 border-double border-4 border-black">
            <div class="font-bold">
                {{ $data["attributes"][$keyElem[1]] }}
            </div>
            @if($data["attributes"][$keyElem[0]])
            <img src="{{ $data['attributes'][$keyElem[0]] }}" alt="noimage" class=" w-44 h-44 object-cover">
            @else
            <img src="{{ asset($imagePath) }}" alt="noimage" class="w-44 h-44 object-cover">
            @endif

            @foreach($data["attributes"] as $key => $value)
            @if($key === 'wiki')
            <div><a href="{{ $value }}" class="text-blue-500 hover:underline">wiki</a></div>
            @elseif(is_array($value))
            <div class="overflow-hidden whitespace-nowrap overflow-ellipsis border-b-2 border-black">{{ $key }} : {{ implode(', ', $value) }}</div>
            @else
            <div class="overflow-hidden whitespace-nowrap overflow-ellipsis border-b-2 border-black">{{ $key }} : {{ $value }}</div>
            @endif
            @endforeach
        </div>
        @endforeach
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.getElementById('category').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        })
    </script>
@endpush