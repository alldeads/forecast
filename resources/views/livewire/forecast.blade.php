<div>
    <div class="form-group">
        <label for="country">Country</label>

        <select id="country" class="form-control @error('country') is-invalid @enderror" wire:model="inputs.country">

            <option> Select a country</option>

            @foreach ($countries as $country )
                <option value="{{ $country['Iso3'] . '---' . $country['name'] }}"> {{ $country['name'] }}</option>
            @endforeach

        </select>

        @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="form-group">
        <label for="city">City</label>

        <select id="city" class="form-control @error('city') is-invalid @enderror" wire:model.defer="inputs.city" wire.loading>

            <option> Select a city</option>

            @foreach ($cities as $city )
                <option value="{{ $city }}"> {{ $city }}</option>
            @endforeach

        </select>

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button class="btn btn-primary" wire:click.prevent="submit">Submit</button>
    
    <div class="card mt-5">
        <img class="card-img-top" src="{{ asset('forecast.jpg') }}" alt="Card image cap" width="300">

        <div class="card-body text-center">
            <p class="card-text" style="font-size: 30px;">{{ $avg }} °C</p>
        </div>
    </div>
</div>