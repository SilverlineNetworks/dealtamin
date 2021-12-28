<style type="text/css">
  .single_deal_box .card-text .deal_card_name {
    padding: 0 !important;
  }
</style>
<div class="mt-4  d-flex flex-wrap">
    @foreach ($services as $service)
        <div class="col-md-4 mobile-no-padding">
            <div class="card single_deal_box border-0">
                <div class="card-image position-relative">
                    <a href="{{$service->service_detail_url}}">
                        <img class="card-img-top" src="{{ $service->service_image_url }}" alt="Card image" >
                    </a>
                    @if($service->discount > 0)
                    <span>
                        @if($service->discount_type == 'fixed')
                            {{ $settings->currency->currency_symbol }}
                        @endif
                        {{$service->discount}}
                        @if($service->discount_type == 'percent')
                            %
                        @endif
                        @lang('app.off')
                    </span>
                    @endif
                </div>
                <div class="card-body">
                    <a href="{{ $service->service_detail_url }}">
                        <h4 class="card-title">{{ ucwords($service->name) }}</h4>
                    </a>
                    <p class="card-text">
                        <span class="deal_card_current_price">{{ $settings->currency->currency_symbol }}{{ $service->discounted_price }}</span>
                        @if($service->discount > 0)
                        <span class="deal_card_old_price">{{ $settings->currency->currency_symbol }}{{ $service->price }}</span>
                        @endif
                        <br/>
                        <span class="deal_card_name">{{ $service->company->company_name }}</span>
                        <div class="deal_card_location">{{ $service->location->name }}</div>
                    </p>
                    <a
                        id="service{{ $service->id }}"
                        href="{{$service->service_detail_url}}"
                        class="btn w-100 add-to-cart"
                        data-type="service"
                        data-unique-id="{{ $service->id }}"
                        data-id="{{ $service->id }}"
                        data-price="{{$service->discounted_price}}"
                        data-name="{{ ucwords($service->name) }}"
                        data-company-id="{{ $service->company->id }}"
                        aria-expanded="false">
                        @lang('front.addToCart')
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="deals_pagination mt-4 d-flex justify-content-center" id="pagination">
    {{ $services->links() }}
</div>
