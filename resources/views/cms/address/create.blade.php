@extends('cms.parent')
@section('title', 'Create Address')
@section('main-title', 'Create Address')
@section('sub-title', 'Create Address')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create New Address</h3>
                </div>
                <form>
                    <div class="card-body">

                        {{-- اختار الدولة --}}
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" id="country_id">
                                <option value="">-- Select Country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- مدن الدولة --}}
                        <div class="form-group">
                            <label>City</label>
                            <select class="form-control" id="city_id" disabled>
                                <option value="">-- Select City --</option>
                            </select>
                        </div>

                        {{-- الشارع يجي افتراضي من المدينة --}}
                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" class="form-control" id="street" placeholder="Will be filled from city">
                        </div>

                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" placeholder="Enter postal code">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_default">
                                <label class="custom-control-label" for="is_default">Set as Default Address</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performStore()" class="btn btn-primary">Add Address</button>
                        <a href="{{ route('addresses.index') }}" class="btn btn-info">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // لما تتغير الدولة، جيب مدنها
    document.getElementById('country_id').addEventListener('change', function() {
        let countryId = this.value;
        let citySelect = document.getElementById('city_id');

        citySelect.innerHTML = '<option value="">-- Select City --</option>';
        citySelect.disabled = true;
        document.getElementById('street').value = '';

        if (!countryId) return;

        // جيب المدن من الـ cities اللي عندنا في الـ controller
        fetch('/cms/Admin/cities-by-country/' + countryId)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}" data-street="${city.street}">${city.name}</option>`;
                });
                citySelect.disabled = false;

                // ضع الشارع الافتراضي للمدينة الأولى
                if (cities.length > 0) {
                    document.getElementById('street').value = cities[0].street;
                }
            });
    });

    // لما تتغير المدينة، حدّث الشارع
    document.getElementById('city_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        document.getElementById('street').value = selected.getAttribute('data-street') || '';
    });

    function performStore() {
        let formData = new FormData();
        formData.append('street',      document.getElementById('street').value);
        formData.append('postal_code', document.getElementById('postal_code').value);
        formData.append('city_id',     document.getElementById('city_id').value);
        formData.append('is_default',  document.getElementById('is_default').checked ? 1 : 0);

        store('/cms/Admin/addresses', formData);
    }
</script>
@endsection
