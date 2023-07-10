<div class="clearfix">
    <button type="button" id="delete" class="btn btn-sm btn-danger float-right d-none"><i class="fa fa-trash"></i> Delete</button>
</div>
<form action="javasript:void(0)" id="form-event">
    <div class="form-row align-items-center">
        <input type="hidden" id="id" value="0" readonly>
        <div class="col-12">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control mb-2" autocomplete="off" required>
        </div>
        <div class="col-12">
            <label for="date">Date</label>
            <input type="text" name="date" id="date" class="form-control mb-2 input-daterange-datepicker" autocomplete="off" required>
        </div>
        <div class="col-12">
            <label for="color">Color</label>
            <select name="color" id="color" class="form-control mb-2" required>
                <option value="">Select color</option>
                @foreach ($colors as $color)
                <option value="{{ $color->code }}" style="background: {{$color->code}}; color: white;">{{ $color->code }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 mb-3">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Select type</option>
                <option value="Libur">Libur</option>
                <option value="Ganti Hari 1">Ganti Hari Shift 1</option>
                <option value="Ganti Hari 2">Ganti Hari Shift 2</option>
                <option value="Stock Opname">Stock Opname</option>
            </select>
        </div>
        <div class="col-12 mb-2">
            <button type="submit" id="submit" class="btn btn-custom btn-block">Create Event</button>
        </div>
        <div class="col-12">
            <button type="button" id="cancel" class="btn btn-block">Cancel</button>
        </div>
    </div>
</form>