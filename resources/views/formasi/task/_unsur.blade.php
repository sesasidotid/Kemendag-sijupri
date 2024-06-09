@foreach ($child as $index => $item)
    @if ($item->childUnsur($formasi_id)->isNotEmpty())
        <div class="row pt-2" style="margin-left: {{ ($item->lvl - 1) * 20 }}px">
            <div class="col">
                <label class="fw-bold">
                    {{ $index + 1 }}. {{ $item->unsur }}
                </label>
            </div>
            <div class="col-2"></div>
            <div class="col-1"></div>
        </div>
        @include('formasi.task._unsur', ['child' => $item->childUnsur($formasi_id)])
    @else
        <div class="row pt-2 border-bottom border-dark" style="margin-left: {{ ($item->lvl - 1) * 20 }}px">
            <div class="col">
                <label>
                    {{ $index + 1 }}. {{ $item->unsur }}
                </label>
            </div>
            <div class="col-2">
                <input wire:model="request.{{ $item->id }}" type="number"
                    class="m-1 form-control @error('request.' . $item->id) is-invalid @enderror">
                @error('request.' . $item->id)
                    <span class="invalid-feedback">
                        <strong>{{ str_replace('request.' . $item->id, 'volume', $message) }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-1"><label>{{ $item->jenjang->name ?? '' }}</label></div>
        </div>
    @endif
@endforeach
