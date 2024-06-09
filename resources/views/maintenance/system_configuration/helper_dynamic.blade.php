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
                @if (isset($child_property['input_type']))
                    <div class="row">
                        <div class="col-sm">
                            <h6><b>{{ $item }}</b></h6>
                        </div>
                        <div class="col-sm">
                            <a class="btn btn-sm btn-soft-success float-end"
                                onclick="addInputRow('property{{ isset($structure) ? $structure . '[' . $item . '][values]' : '[' . $item . '][values]' }}')">Add</a>
                        </div>
                    </div>
                @else
                    <h6><b>{{ str_replace('$', '', str_replace('_', ' ', $item)) }}</b></h6>
                @endif
            </td>
            <td class="m-0 p-1 align-top text-center">
                @if (isset($child_property['input_type']))
                    <table
                        id="dynamic-table-property{{ isset($structure) ? $structure . '[' . $item . '][values]' : '[' . $item . '][values]' }}"
                        class="table table-bordered nowrap align-middle w-100">
                        @foreach ($child_property['values'] as $key => $value)
                            <tr>
                                <td>
                                    <div class="input-row btn-group w-100">
                                        <input type="{{ $child_property['input_type'] }}" class="form-control p-1"
                                            name="property{{ isset($structure) ? $structure . '[' . $item . '][values][' . $key . ']' : '[' . $item . '][values][' . $key . ']' }}"
                                            value="{{ $value }}">
                                        <a class="btn btn-sm btn-soft-danger" onclick="removeInputRow(this)">Remove</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @elseif (is_array($child_property))
                    @include('maintenance.system_configuration.helper_dynamic', [
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
<script>
    var increment = 0;

    function addInputRow(item) {
        var table = document.getElementById('dynamic-table-' + item);
        var rowCount = table.rows.length;
        var row = table.insertRow();
        var cell = row.insertCell();
        cell.innerHTML =
            '<div class="input-row btn-group w-100"><input type="text" class="form-control p-1" name="' + item + '[' +
            rowCount +
            ']" value=""><a class="btn btn-sm btn-soft-danger" onclick="removeInputRow(this)">Remove</a></div>';
    }

    function removeInputRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
