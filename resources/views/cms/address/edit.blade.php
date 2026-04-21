@extends('cms.parent')
@section('title', 'Edit Address')
@section('main-title', 'Edit Address')
@section('sub-title', 'Edit Address')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit Address</h3>
                </div>
                <form>
                    <div class="card-body">

                        {{-- اختار الدولة --}}
                        <div class="form-group">
                            <label>Country</label>
                            <select class="form-control" id="country_id">
                                <option value="">-- Select Country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}"
                                        @if($address->city && $address->city->country_id == $country->id) selected @endif>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- المدن --}}
                        <div class="form-group">
                            <label>City</label>
                            <select class="form-control" id="city_id">
                                <option value="">-- Select City --</option>
                                {{-- المدينة الحالية تظهر افتراضي --}}
                                @if($address->city)
                                    <option value="{{ $address->city->id }}" selected>
                                        {{ $address->city->name }}
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" class="form-control" id="street" value="{{ $address->street }}">
                        </div>

                        <div class="form-group">
                            <label>Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" value="{{ $address->postal_code ?? '' }}">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_default"
                                    @if($address->is_default) checked @endif>
                                <label class="custom-control-label" for="is_default">Set as Default Address</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="button" onclick="performUpdate({{ $address->id }})" class="btn btn-primary">Update</button>
                        <a href="{{ route('addresses.index') }}" class="btn btn-secondary">Go To Index</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // لما تتغير الدولة جيب مدنها
    document.getElementById('country_id').addEventListener('change', function() {
        let countryId = this.value;
        let citySelect = document.getElementById('city_id');

        citySelect.innerHTML = '<option value="">-- Select City --</option>';
        document.getElementById('street').value = '';

        if (!countryId) return;

        fetch('/cms/Admin/cities-by-country/' + countryId)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    citySelect.innerHTML += `<option value="${city.id}" data-street="${city.street}">${city.name}</option>`;
                });
            });
    });

    // لما تتغير المدينة حدّث الشارع
    document.getElementById('city_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let street = selected.getAttribute('data-street');
        if (street) document.getElementById('street').value = street;
    });

    function performUpdate(id) {
        let formData = new FormData();
        formData.append('street',      document.getElementById('street').value);
        formData.append('postal_code', document.getElementById('postal_code').value);
        formData.append('city_id',     document.getElementById('city_id').value);
        formData.append('is_default',  document.getElementById('is_default').checked ? 1 : 0);

        storeRoute('/cms/Admin/addresses_update/' + id, formData);
    }
</script>
@endsection
