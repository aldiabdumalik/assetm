<form action="javasript:void(0)" id="form-event-generate">
    <div class="form-row align-items-center">
        <div class="col-12 mb-2">
            @php
                $current_y = date('Y');
                $month = date('m');
            @endphp
            <label for="year">Year</label>
            <select name="year" id="year" class="form-control mb-2" required>
                <option value="">Select year</option>
                @if ($month == 12)
                    @for ($x=$current_y; $x <= $current_y+1; $x++)
                        <option value="{{ $x }}">{{ $x }}</option>
                    @endfor
                @else
                    <option value="{{ $current_y }}">{{ $current_y }}</option>
                @endif
            </select>
        </div>
        <div class="col-12 mb-2">
            <button type="submit" id="btn_generate" class="btn btn-custom btn-block">Generate From API</button>
        </div>
    </div>
</form>