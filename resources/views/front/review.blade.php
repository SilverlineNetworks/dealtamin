@extends('layouts.front')

@push('styles')
    <style type="text/css">
    .deal_detail_box h3 {
        font-size: 20px;
        font-weight: 500;
        font-stretch: normal;
        font-style: normal;
        letter-spacing: normal;
        color: var(--primary-color);
        margin-top: 7px;
        margin-bottom: 17px;
    }
    .deal_detail_section {
        padding: 100px 0px;
    }
    .services {
        color: #000 !important;
        border-radius: 20px;
        box-shadow: 2px 2px 2px #d9d9d9;
        padding-right: 10px;
        padding-left: 10px;
        margin-right: 10px;
    }
    /* Rating Star Widgets Style */
    .rating-stars {
        margin-top: 20px;
    }
.rating-stars ul {
  list-style-type:none;
  padding:0;

  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;

}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
.submitb {
    border-radius: 5px;
    box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16);
    background-color: var(--secondary-color);
    font-size: 14px;
    font-weight: 300;
    font-stretch: normal;
    font-style: normal;
    letter-spacing: normal;
    text-align: center;
    color: #fff;
    padding: 10px;
    width: 150px;
    height: 40px;
    transition: 1s ease;
    margin-top:10px;
}
    </style>
@endpush

@section('content')

    <!-- BREADCRUMB START -->
        <section class="breadcrumb_section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-5">
                        <h1 class="mb-0"> Customer Review </h1>
                    </div>
                    <div class="col-lg-6 col-md-7 d-none d-lg-block d-md-block">
                        <nav>
                            <ol class="breadcrumb mb-0 justify-content-center">
                                <li class="breadcrumb-item"><a href="/">@lang('app.home')</a></li>
                                <li class="breadcrumb-item active"><span> Reviews </span></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    <!-- BREADCRUMB END -->

    <!-- CART START -->
    <section class="deal_detail_section">
        <div class="container">
            <div class="row ">
                <?php
                    if ($count > 0) {
                ?>
                    <div class="col-lg-12 col-12 mb-30 text-center">
                        Already submitted the review.
                    </div>
                <?php
                }
                ?>
            </div>
            @php
                if ($count == 0) {
            @endphp
            <div class="row deal_detail_box">
                <div class="col-lg-12 col-12 mb-30">
                <form class="form-horizontal ajax-form" id="review" method="POST">
                    @csrf
                    @method('PUT')
                <div style="display:flex;flex-direction:row"><h3>Name : </h3> <h3 style="color:black;margin-left: 10px;"> {{$booking->user->name}}</h3></div>
                <div style="width:100%; display:flex;flex-direction:row"><h3>Services : </h3>
                <div style="margin-left: 10px;">
                <?php
                foreach($services AS $s) {
                ?>
                <h3 class="services">{{$s->name}}</h3>
                <?php
                }
                ?>
                </div>
                </div>
                <section class='rating-widget'>
                    <!-- Rating Stars Box -->
                    <div class='rating-stars'>
                        <ul id='stars'>
                            <li class='star' data-value='1'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' data-value='2'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' data-value='3'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' data-value='4'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                            <li class='star' data-value='5'>
                                <i class='fa fa-star fa-fw'></i>
                            </li>
                        </ul>
                    </div>
                </section>
                <textarea id="review_comments" name="review_comments" style="margin-top:40px;height: 111px;" class="form-control" placeholder="Share details of your own experience at this place.."></textarea>
                <input type="hidden" name="id" id="id" value="{{$id}}"/>
                <input type="hidden" name="rating" id="rating" value="0"/>

                <div class="text-center">
                    <button type="button" class="btn btn-custom ml-lg-3 ml-md-3 ml-0 submitb" id="submit-item">
                    Submit Review
                    </button>
                </div>
                </form>

                </div>
            </div>
            @php
            }
            @endphp
        </div>
    </section>
    <!-- CART END -->
@endsection

@push('footer-script')

    <script>
    $(document).ready(function(){

      /* 1. Visualizing things on Hover - See next part for action on click */
      $('#stars li').on('mouseover', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e){
          if (e < onStar) {
            $(this).addClass('hover');
          }
          else {
            $(this).removeClass('hover');
          }
        });

      }).on('mouseout', function(){
        $(this).parent().children('li.star').each(function(e){
          $(this).removeClass('hover');
        });
      });


      /* 2. Action to perform on click */
      $('#stars li').on('click', function(){
        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
          $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
          $(stars[i]).addClass('selected');
        }

        // JUST RESPONSE (Not needed)
        var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
        $('#rating').val(ratingValue);
        var msg = "";
      });
    });

    $('body').on('click', '#submit-item', function() {

        if (document.getElementById('rating').value == 0) {
            alert('Please rate service');
            return false;
        }

        if (document.getElementById('review_comments').value.length == 0) {
            alert('Please enter your experience details');
            return false;
        }

        var csrf = $('input[name="_token"]').val();
        $.easyAjax({
            url: '{{route('front.review.update', $id)}}',
            data: {
                'id': document.getElementById('id').value,
                'rating': document.getElementById('rating').value,
                'review_comments': document.getElementById('review_comments').value,
                '_token': csrf
            },
            type: "POST",
            redirect: true,
            file:false,
        })


        /*$.ajax({
            url: '{{route('front.review.update', $id)}}',
            type: "POST",
            data: {
                'id': document.getElementById('id').value,
                'rating': document.getElementById('rating').value,
                'review_comments': document.getElementById('review_comments').value,
                '_token': csrf
            },
            success: function (response) {
                //window.location = response.url;
            }
        });*/

    });

    </script>
@endpush
