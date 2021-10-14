<!DOCTYPE html>
<html lang="en" >
    <head>
      <meta charset="UTF-8">
      <title>Your Booking is Completed</title>
      <style type="text/css">
      body{
          width:100% !important;
          -webkit-text-size-adjust:100%;
          -ms-text-size-adjust:100%;
          margin:0 auto;
          padding:0;
          background-color:#e3e3e3;
          text-align: center;
          align-items: center;
          display: flex;
          justify-content: center;
      }
          * {-webkit-font-smoothing:antialiased}
          .ExternalClass * {line-height:100%}
          table td {border-collapse:collapse; max-width:100% !important; word-break:break-word; -webkit-hyphens:auto; -moz-hyphens:auto; hyphens:auto; overflow:auto; white-space:normal;}
          .wlf {width:610px}
          @media only screen and (max-width:610px) {
              .full-width {width:100% !important}
              .t-none {display:none}
              .t-center-txt {text-align:center}
              .t-width {width:100% !important;max-width:100% !important;display:table !important}
          }
          img {
              width: 200px;
          }
      </style>
    </head>

    <body>
        <div style="display:none;font-size:1px;color:#333333;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;">
            Your Booking is Completed
        </div>
        <div style="padding:10px;width: 60%;background-color:#fff; text-align:left">
            <div style="text-align:center">
                <img src="{{asset('user-uploads/logo/1ce0be83858744699542be0e4daf93e2.png')}}" class="logo" alt="Laravel Logo">
            </div>
        <table width="100%">
            <tr>
                <td>Hi {{ $name }}</td>
            </tr>
            <tr>
                <td>
                    <div style="margin-top:10px;margin-bottom:10px;">Thank you for choosing {{$vendor_name}}. We appreciate your business.</div>

                    <table style="width:60%">
                        <tr>
                            <td colspan="2">Here are your booking details:</td>
                        </tr>
                        <tr>
                            <td style="color:#109191;">Booking Number</td>
                            <td>{{$booking_id}}</td>
                        </tr>
                        <tr>
                            <td style="color:#109191;">Booking Date and Time</td>
                            <td>{{$booking_date}}</td>
                        </tr>
                        <tr>
                            <td style="color:#109191;">Booking Status</td>
                            <td>Completed</td>
                        </tr>
                    </table>

                    <p>Your feedback is valuable and essential to us. Please take a moment to share your experience <a href="{{url('review', $id)}}">Review</a></p>

                    <p>We’re committed to addressing any issues that come up during your service with us. If you have any comments on how we can improve, please give us a call at +971554592638</p>

                    <p>We hope that you’ll book with us again soon.</p>
                </td>
            </tr>
        </table>
        </div>
    </body>
</html>
