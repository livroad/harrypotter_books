<x-app-layout>
    <div class="flex flex-wrap justify-between mx-auto py-8 w-4/5">
        @foreach($datas as $data)
            <div class="w-1/4 p-4 bg-orange-100 border-double border-4 border-black">
                <div class="font-bold">
                    {{ $data["attributes"]["slug"] }}
                </div>
                @if($data["attributes"]["poster"])
                    <img src="{{ $data['attributes']['poster'] }}" alt="noimage" class=" w-44 h-44 object-cover">
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
