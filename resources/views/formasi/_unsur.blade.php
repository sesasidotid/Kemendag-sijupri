@foreach ($child as $index => $item)
    @if ($item->childUnsur($formasiData->id)->isNotEmpty())
        <div class="row pt-2" style="margin-left: {{ ($item->lvl - 1) * 20 }}px">
            <div class="col">
                <label class="fw-bold">
                    {{ $index + 1 }}. {{ $item->unsur }}
                </label>
            </div>
            <div class="col-2"></div>
            <div class="col-1"></div>
        </div>
        @include('formasi._unsur', ['child' => $item->childUnsur($formasiData->id)])
    @else
        <div class="row pt-2 border-bottom border-dark" style="margin-left: {{ ($item->lvl - 1) * 20 }}px">
            <div class="col">
                <label>
                    {{ $index + 1 }}. {{ $item->unsur }}
                </label>
            </div>
            <div class="col-2">
                <label type="number" class="m-1">{{ $item->volume }}</label>
            </div>
            <div class="col-1"><label>{{ $item->jenjang->name ?? '' }}</label></div>
        </div>
    @endif
@endforeach
