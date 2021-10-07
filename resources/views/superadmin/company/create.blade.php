@extends('layouts.master')

@section('content')

<style type="text/css">
.controls {
  background-color: #fff;
  border-radius: 2px;
  border: 1px solid transparent;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  box-sizing: border-box;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  height: 29px;
  margin-left: 17px;
  margin-top: 10px;
  outline: none;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 400px;
}

.controls:focus {
  border-color: #4d90fe;
}

.title {
  font-weight: bold;
}

#description {
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
}

#infowindow-content .title {
  font-weight: bold;
}

#infowindow-content {
  display: none;
}

#map #infowindow-content {
  display: inline;
}

.pac-card {
  background-color: #fff;
  border: 0;
  border-radius: 2px;
  box-shadow: 0 1px 4px -1px rgba(0, 0, 0, 0.3);
  margin: 10px;
  padding: 0 0.5em;
  font: 400 18px Roboto, Arial, sans-serif;
  overflow: hidden;
  font-family: Roboto;
  padding: 0;
}

#pac-container {
  padding-bottom: 12px;
  margin-right: 12px;
}

.pac-controls {
  display: inline-block;
  padding: 5px 11px;
}

.pac-controls label {
  font-family: Roboto;
  font-size: 13px;
  font-weight: 300;
}

#pac-input {
  background-color: #fff;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  margin-left: 12px;
  padding: 0 11px 0 13px;
  text-overflow: ellipsis;
  width: 400px;
}

#pac-input:focus {
  border-color: #4d90fe;
}

#title {
  color: #fff;
  background-color: #4d90fe;
  font-size: 25px;
  font-weight: 500;
  padding: 6px 12px;
}

#target {
  width: 345px;
}

#map {
    height: 400px !important;
}

</style>

<div class="row">
   <div class="col-md-12">
      <div class="card card-dark">
         <div class="card-header">
            <h3 class="card-title">@lang('app.add') @lang('app.company')</h3>
         </div>
         <!-- /.card-header -->
         <div class="card-body">
            <form class="form-horizontal ajax-form" id="createForm" method="POST">
               @csrf
               <h5>@lang('modules.company.companyDetails')</h5>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="company_name"
                           class="control-label">@lang('app.company') @lang('app.name')</label>
                        <input type="text" class="form-control  form-control-lg"
                           id="company_name" name="company_name">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="company_email"
                           class="control-label">@lang('app.company') @lang('app.email')</label>
                        <input type="text" class="form-control  form-control-lg"
                           id="company_email" name="company_email">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label for="company_phone"
                           class="control-label">@lang('app.company') @lang('app.phone')</label>
                        <input type="text" class="form-control  form-control-lg"
                           id="company_phone" name="company_phone">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="input-file-now">@lang('app.logo')</label>
                        <div class="card">
                           <div class="card-body">
                              <input type="file" id="input-file-now" name="logo"
                                 accept=".png,.jpg,.jpeg" class="dropify"
                                 />
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="address">@lang('app.address')</label>
                        <textarea class="form-control form-control-lg" name="address" id="address"
                           cols="30" rows="5"></textarea>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="date_format" class="control-label">
                              @lang('app.date_format')
                              </label>
                              <select name="date_format" id="date_format"
                                 class="form-control form-control-lg select2">
                                 @foreach($dateFormats as $key => $dateFormat)
                                 <option value="{{ $key }}">{{
                                    $key.' ('.$dateObject->format($key).')' }}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group">
                              <label for="time_format" class="control-label">
                              @lang('app.time_format')
                              </label>
                              <select name="time_format" id="time_format"
                                 class="form-control form-control-lg select2">
                                 @foreach($timeFormats as $key => $timeFormat)
                                 <option value="{{ $key }}">{{
                                    $key.' ('.$dateObject->format($key).')' }}
                                 </option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="website"
                           class="control-label">@lang('app.company') @lang('app.website')</label>
                        <input type="text" class="form-control form-control-lg" id="website"
                           name="website">
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="timezone"
                           class="control-label">@lang('app.timezone')</label>
                        <select name="timezone" id="timezone"
                           class="form-control form-control-lg select2">
                           @foreach($timezones as $tz)
                           <option>
                              {{ $tz }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="currency_id"
                           class="control-label">@lang('app.currency')</label>
                        <select name="currency_id" id="currency_id"
                           class="form-control  form-control-lg">
                           @foreach($currencies as $currency)
                           <option value="{{ $currency->id }}">
                              {{ $currency->currency_symbol.' ('.$currency->currency_code.')' }}
                           </option>
                           @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <label for="locale"
                           class="control-label">@lang('app.language')</label>
                        <select name="locale" id="locale"
                           class="form-control form-control-lg">
                           @forelse($enabledLanguages as $language)
                           <option value="{{ $language->language_code }}">
                              {{ $language->language_name }}
                           </option>
                           @empty
                           <option value="en">English
                           </option>
                           @endforelse
                        </select>
                     </div>
                  </div>

                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="location" class="control-label">@lang('app.location')</label>
                          <input type="hidden" class="form-control form-control-lg" id="location" name="location"
                          value="___">
                          <input type="hidden" id="lat" name="latitude" value="9.981636"/>
                          <input type="hidden" id="lng" name="longitude" value="76.299881"/>
                      </div>

                        <div>
                          <input
                            id="pac-input"
                            class="controls"
                            type="text"
                            placeholder="Enter a location"
                          />
                        </div>
                        <div id="map"></div>
                        <div id="infowindow-content">
                          <span id="place-name" class="title"></span><br />
                          <strong>Place ID</strong>: <span id="place-id"></span><br />
                          <span id="place-address"></span>
                        </div>
                  </div>


               </div>
               <hr>
               <h5>@lang('modules.company.employeeDetails')</h5>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="name">@lang('modules.company.employeeName')</label>
                        <input id="name" class="form-control form-control-lg" type="text" name="name">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="email">@lang('modules.company.employeeEmail')</label>
                        <input id="email" class="form-control form-control-lg" type="email" name="email">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="password">@lang('modules.company.employeePassword')</label>
                        <input id="password" class="form-control form-control-lg" type="password" name="password">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="confirm_password">@lang('modules.company.employeeConfirmPassword')</label>
                        <input id="confirm_password" class="form-control form-control-lg" type="password" name="password_confirmation">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <button id="save-form" type="button" class="btn btn-success"><i
                           class="fa fa-check"></i> @lang('app.create')</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->
   </div>
</div>
@endsection

@push('footer-js')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8z669FCD9gRnRPuD81MLdATevU2jFqwY&callback=initAutocomplete&libraries=places&v=weekly" async></script>

    <script>
        let markers = [];
        var marker = null;

        function initAutocomplete() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -33.8688, lng: 151.2195 },
                zoom: 13,
                mapTypeId: "roadmap",
            });
            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });



            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.

            /*google.maps.event.addListener(map, "click", function(evt) {
                    //initialService.textSearch(request, callback);
                    markers.forEach((marker) => {
                        marker.setMap(null);
                    });
                    markers = [];

                    const myLatLng = { lat: evt.latLng.lat(), lng: evt.latLng.lng() };
                    new google.maps.Marker({
                        position: myLatLng,
                        map,
                        title: "",
                    });
            });*/

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach((marker) => {
                    marker.setMap(null);
                });
                markers = [];
                if (marker != null)
                    marker.setMap(null);

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();

                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                }

                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lng').value = place.geometry.location.lng();

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                function handleEvent(event) {
                    document.getElementById('lat').value = event.latLng.lat();
                    document.getElementById('lng').value = event.latLng.lng();
                }

                // Create a marker for each place.
                markers.push(

                );

                marker = new google.maps.Marker({
                    map,
                    icon,
                    title: place.name,
                    position: place.geometry.location,
                    draggable: true
                })

                marker.addListener('drag', handleEvent);
                marker.addListener('dragend', handleEvent);

                if (place.geometry.viewport) {
                // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                });
                    map.fitBounds(bounds);
            });
        }



        /*google.maps.event.addDomListener(window, 'load', function () {
            var places = new google.maps.places.Autocomplete(document.getElementById('location'));
            google.maps.event.addListener(places, 'place_changed', function () {
                var place = places.getPlace();
                var address = place.formatted_address;
                var latitude = place.geometry.location.A;
                var longitude = place.geometry.location.F;
                var mesg = "Address: " + address;
                mesg += "\nLatitude: " + latitude;
                mesg += "\nLongitude: " + longitude;
                document.getElementById('lat').value = latitude;
                document.getElementById('lng').value = longitude;
            });
        });*/

        $('.dropify').dropify({
            messages: {
                default: '@lang("app.dragDrop")',
                replace: '@lang("app.dragDropReplace")',
                remove: '@lang("app.remove")',
                error: '@lang('app.largeFile')'
            }
        });

        $('body').on('click', '#save-form', function() {
            $.easyAjax({
                url: '{{route('superadmin.companies.store')}}',
                container: '#createForm',
                type: "POST",
                redirect: true,
                file:true,
            })
        });
    </script>
@endpush
