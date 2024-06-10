<thead>
    <tr class="[&>*]:border-b-base-300 bg-base-100 [&>*]:text-center">
        @foreach($heads as $head)
            <th
                @class($head['class'] ?? [])
            >
                {!! $head['text'] !!}
            </th>
        @endforeach
    </tr>
</thead>
