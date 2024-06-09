<style>
    .align-top {
        vertical-align: top;
    }
</style>
<table class="@if (!isset($structure)) main-table @endif table table-bordered nowrap align-middle w-100">
    @if (!isset($structure))
        <thead>
            <th>Parameter</th>
            <th>Value</th>
        </thead>
    @endif
    @if (!isset($structure))
        <tbody>
    @endif
    @foreach ($property as $item => $child_property)
        <tr class="m-0 p-1">
            <td class="m-0 p-1 align-top text-start">
                <h6><b>{{ str_replace('$', '', str_replace('_', ' ', $item)) }}</b></h6>
            </td>
            <td class="m-0 p-1 align-top text-start">
                @if (isset($child_property['input_type']))
                    @if ($child_property['input_type'] == 'text')
                        <input type="text" class="form-control p-1"
                            name="property{{ isset($structure) ? $structure . '[' . $item . '][value]' : '[' . $item . '][value]' }}"
                            value="{{ $child_property['value'] }}">
                    @elseif ($child_property['input_type'] == 'checkbox')
                        <input type="hidden"
                            name="property{{ isset($structure) ? $structure . '[' . $item . '][value]' : '[' . $item . '][value]' }}"
                            value="false">
                        <input type="checkbox" class="form-check-input p-1"
                            @if ($child_property['value'] == 'true') checked @endif
                            name="property{{ isset($structure) ? $structure . '[' . $item . '][value]' : '[' . $item . '][value]' }}"
                            value="true">
                    @endif
                @elseif (is_array($child_property))
                    @include('maintenance.system_configuration.helper', [
                        'property' => $child_property,
                        'structure' => (isset($structure) ? $structure : '') . '[' . $item . ']',
                    ])
                @endif
            </td>
        </tr>
    @endforeach
    @if (!isset($structure))
        </tbody>
    @endif
</table>
