<html>
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Approval Detail</title>
  <style>
    /* -------------------------------------
        GLOBAL RESETS
    ------------------------------------- */
    img {
      border: none;
      -ms-interpolation-mode: bicubic;
      max-width: 100%; }
    body {
      background-color: #ffffff;
      font-family: sans-serif;
      -webkit-font-smoothing: antialiased;
      font-size: 14px;
      line-height: 1.4;
      margin: 0;
      padding: 0;
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%; }
    table {
      border-collapse: separate;
      border-spacing: 0px;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      width: 100%; }
      table td {
        font-family: sans-serif;
        font-size: 14px; }
    table tbody {
      margin-top: 10px !important;
    }
    /* -------------------------------------
        BODY & CONTAINER
    ------------------------------------- */
    .body {
      background-color: #f6f6f6;
      width: 100%; }
    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
    .container {
      display: block;
      Margin: 0 auto !important;
      /* makes it centered */
      max-width: 580px;
      padding: 10px;
      width: auto !important;
      width: 580px; }
    /* This should also be a block element, so that it will fill 100% of the .container */
    .content {
      box-sizing: border-box;
      display: block;
      Margin: 0 auto;
      max-width: 580px;
      padding: 10px; }
    /* -------------------------------------
        HEADER, FOOTER, MAIN
    ------------------------------------- */
    .main {
      background: #fff;
      border-radius: 3px;
      width: 100%; }
    .wrapper {
      box-sizing: border-box;
      padding: 20px; }
    .footer {
      clear: both;
      padding-top: 10px;
      text-align: center;
      width: 100%; }
      .footer td,
      .footer p,
      .footer span,
      .footer a {
        color: #999999;
        font-size: 12px;
        text-align: center; }
    /* -------------------------------------
        TYPOGRAPHY
    ------------------------------------- */
    h1,
    h2,
    h3,
    h4 {
      color: #000000;
      font-family: sans-serif;
      font-weight: 400;
      line-height: 1.4;
      margin: 0;
      Margin-bottom: 30px; }
    h1 {
      font-size: 35px;
      font-weight: 300;
      text-align: center;
      }
    p,
    ul,
    ol {
      font-family: sans-serif;
      font-size: 14px;
      font-weight: normal;
      margin: 0;
      Margin-bottom: 15px; }
      p li,
      ul li,
      ol li {
        list-style-position: inside;
        margin-left: 5px; }
    a {
      color: #3498db;
      text-decoration: underline; }
    /* -------------------------------------
        BUTTONS
    ------------------------------------- */
    .btn {
      box-sizing: border-box;
      width: 100%; }
      .btn > tbody > tr > td {
        padding-bottom: 15px; }
      .btn table {
        width: auto; }
      .btn table td {
        background-color: #ffffff;
        border-radius: 5px;
        text-align: center; }
      .btn a {
        background-color: #ffffff;
        border: solid 1px #3498db;
        border-radius: 5px;
        box-sizing: border-box;
        color: #3498db;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin: 0;
        padding: 12px 25px;
        text-decoration: none;
        text-transform: capitalize; }
    .btn-primary table td {
      background-color: #3498db; }
    .btn-primary a {
      background-color: #3498db;
      border-color: #3498db;
      color: #ffffff; }
    .btn-danger a {
      background-color: #c12e2a;
      border-color: #b92c28;
      color: #ffffff; }
    /* -------------------------------------
        OTHER STYLES THAT MIGHT BE USEFUL
    ------------------------------------- */

    .table-bordered th,
    .table-bordered td {
      border: 1px solid #000 !important;
      border-spacing: 0px !important;
      padding: 10px;
      vertical-align: middle;
    }
    .last {
      margin-bottom: 0; }
    .first {
      margin-top: 0; }
    .align-center {
      text-align: center; }
    .align-right {
      text-align: right; }
    .align-left {
      text-align: left; }
    .clear {
      clear: both; }
    .mt0 {
      margin-top: 0; }
    .mb0 {
      margin-bottom: 0; }
    .preheader {
      color: transparent;
      display: none;
      height: 0;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
      mso-hide: all;
      visibility: hidden;
      width: 0; }
    .powered-by a {
      text-decoration: none; }
    hr {
      border: 0;
      border-bottom: 1px solid #f6f6f6;
      Margin: 20px 0; }
    /* -------------------------------------
        RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 620px) {
      table[class=body] h1 {
        font-size: 28px !important;
        margin-bottom: 10px !important; }
      table[class=body] p,
      table[class=body] ul,
      table[class=body] ol,
      table[class=body] td,
      table[class=body] span,
      table[class=body] a {
        font-size: 16px !important; }
      table[class=body] .wrapper,
      table[class=body] .article {
        padding: 10px !important; }
      table[class=body] .content {
        padding: 0 !important; }
      table[class=body] .container {
        padding: 0 !important;
        width: 100% !important; }
      table[class=body] .main {
        border-left-width: 0 !important;
        border-radius: 0 !important;
        border-right-width: 0 !important; }
      table[class=body] .btn table {
        width: 100% !important; }
      table[class=body] .btn a {
        width: 100% !important; }
      table[class=body] .img-responsive {
        height: auto !important;
        max-width: 100% !important;
        width: auto !important; }}
    /* -------------------------------------
        PRESERVE THESE STYLES IN THE HEAD
    ------------------------------------- */
    @media all {
      .ExternalClass {
        width: 100%; }
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%; }
      .apple-link a {
        color: inherit !important;
        font-family: inherit !important;
        font-size: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
        text-decoration: none !important; }
      .btn-primary table td:hover {
        background-color: #34495e !important; }
      .btn-primary a:hover {
        background-color: #34495e !important;
        border-color: #34495e !important;
      }
    }
  </style>
</head>

<body border="0" cellpadding="0" cellspacing="0">
  <div style="float: right;">
    @if(!$showBuy)
    <img src="./images/berau.jpg" style="width:60px; margin-right: 10px;">
    @else
    <img src="./images/sinarmas.png" style="width:60px; margin-right: 10px;">
    @endif
  </div>

  <div class="big-loader">
  @foreach($orderData as $data)
    <div class="col-lg-8" id="order-detail">
      <div class="box" >
        <div class="box-header with-border" style="margin-left: 70px">
          <h1 class="box-title">ORD#{{ substr(("10000"+$data->id),1,4) }} - {{ $data->trader->name }}</h1>
        </div>
        <span class="badge badge-primary">
          {{ ($data->status == 'c') ? 'Combined' :
          (($data->status == 'p') ? 'Pending Approval' :
          (($data->status == 'd') ? 'Draft' :
          (($data->status == 'a') ? 'Approved' :
          (($data->status == 'f') ? 'In Shipment' : 'cancel')))) }}
        </span>
        <div class="box-header">
          <small>
            <em class="text-muted">
            Created at
            {{ date("M d, Y", strtotime($data->created_at)) }},
            Last Update
            {{ date("M d, Y", strtotime($data->updated_at)) }}
            </em>
          </small>
        </div>
        <div id="order-detail">
          <table>
            <thead style="text-align: center;">
              <tr>
                <th colspan="3">
                  <span style="font-size:20pt">Approval Details</span>
                </th>
              </tr>
            </thead>

            <br>
          </table>
          <table class="table-bordered">
            <tbody>
              <tr>
                @if($showBuy)
                <th colspan=4 style="text-align:center; background: #989c9f;">
                @else
                <th colspan=2 style="text-align: center;background: #989c9f; width: 50%">
                @endif
                  <span>Order Details</span>
                </th>
              </tr>
            </tbody>

            <tbody id="detail-section">
              @if ($showBuy)
              <tr style="text-align: center;font-weight: bold;">
                <td></td>
                <td></td>
                <td>Buy</td>
                <td>Sell</td>
              </tr>
              @endif

              @for ($i = 0; $i < max(count($data->buys), count($data->sells)); $i++)
              @if($showBuy)<td rowspan="9" width="10px" style="text-align: center;">{{$i+1}}</td>@endif
                <tr>
                  <td>Company</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->company->company_name)){{ $data->buys[$i]->company->company_name }}@else - @endif</td>
                  @endif
                  <td>@if(isset($data->sells[$i]->company->company_name)){{ $data->sells[$i]->company->company_name }}@else - @endif</td>
                </tr>
                <tr>
                  <td>Volume (mt) - Price</td>
                  @if ($showBuy)
                  <td><span>@if(isset($data->buys[$i]->pivot->volume)){{ number_format($data->buys[$i]->pivot->volume, 2) }}mt - {{ $data->buys[$i]->pivot->deal_currency_id }} {{ number_format($data->buys[$i]->pivot->deal_price, 2) }} || {{ $data->buys[$i]->pivot->base_currency_id }} {{ number_format($data->buys[$i]->pivot->base_price, 2) }}@else - @endif</span></td> <!-- if buy -->
                  @endif
                  <td>
                    <span>@if(isset($data->sells[$i]->pivot->volume)){{ number_format($data->sells[$i]->pivot->volume, 2) }}mt - {{ $data->sells[$i]->pivot->deal_currency_id }} {{ number_format($data->sells[$i]->pivot->deal_price, 2) }} || {{ $data->sells[$i]->pivot->base_currency_id }} {{ number_format($data->sells[$i]->pivot->base_price, 2) }}@else - @endif</span>
                  </td>
                </tr>
                <tr>
                  <td>Input Date</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->created_at)){{date("M d, Y",strtotime($data->buys[$i]->created_at))}}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->created_at)){{date("M d, Y",strtotime($data->sells[$i]->created_at))}}@else - @endif</td>
                </tr>
                <tr>
                  <td>Validity Period</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->order_expired)){{ date("M d, Y", strtotime($data->buys[$i]->order_expired)) }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->order_expired)){{ date("M d, Y", strtotime($data->sells[$i]->order_expired)) }}@else - @endif</td>
                </tr>
                <tr>
                  <td>LayCan</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->laycan_start)){{  date("M d, Y", strtotime($data->buys[$i]->laycan_start)) }} - {{  date("M d, Y", strtotime($data->buys[$i]->laycan_end)) }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->laycan_start)){{  date("M d, Y", strtotime($data->sells[$i]->laycan_start)) }} - {{  date("M d, Y", strtotime($data->sells[$i]->laycan_end)) }}@else - @endif</td>
                </tr>
                <tr>
                  <td>Shipping Term</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->pivot->trading_term)){{ $data->buys[$i]->pivot->trading_term }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->pivot->trading_term)){{ $data->sells[$i]->pivot->trading_term }}@else - @endif</td>
                </tr>
                <tr>
                  <td>Payment Term</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->pivot->payment_term)){{ $data->buys[$i]->pivot->payment_term }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->pivot->payment_term)){{ $data->sells[$i]->pivot->payment_term }}@else - @endif</td>
                </tr>
                <tr>
                  <td>Location</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->city)){{ $data->buys[$i]->city }} / {{ $data->buys[$i]->country }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->city)){{ $data->sells[$i]->city }} / {{ $data->sells[$i]->country }}@else - @endif</td>
                </tr>
                <tr>
                  <td>Remarks</td>
                  @if ($showBuy)
                  <td>@if(isset($data->buys[$i]->remarks)){{ $data->buys[$i]->remarks }}@else - @endif</td> <!-- if buy -->
                  @endif
                  <td>@if(isset($data->sells[$i]->remarks)){{ $data->sells[$i]->remarks }}@else - @endif</td>
                </tr>
                @endfor
            </tbody>
          </table>

          <table class="table-bordered">
            <tbody>
              <tr>
                @if($quality === "typical")
                <th colspan=3 style="text-align:center; background: #989c9f;">
                  <span>Quality</span>
                </th>
                @else
                <th colspan=5 style="text-align:center; background: #989c9f;">
                  <span>Quality</span>
                </th>
                @endif
              </tr>

              <tr>
                @if($quality === "typical")
                <th colspan=3 style="text-align:center;">
                @else
                <th colspan=5 style="text-align: center; width: 50%">
                @endif
                  <span>{{ $data->sells[0]->product_name }}</span>
                </th>
              </tr>
            </tbody>

            <tbody style="margin-top: 20px !important;" id="quality-section">
            @if($quality === "typical")
              <tr style="font-weight: bold;">
                <td style="width: 30%;">Parameter</td>
                <td>Typical</td>
                <td>Rejection</td>
              </tr>

              @if($data->sells[0]->gcv_adb_min !== null )
              <tr>
                <td style="font-weight: bold">GCV ADB</td>
                <td>{{ number_format($data->sells[0]->gcv_adb_min, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->gcv_adb_reject }}@if($data->sells[0]->gcv_adb_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->gcv_arb_min !== null )
              <tr>
                <td style="font-weight: bold">GCV ARB</td>
                <td>{{ number_format($data->sells[0]->gcv_arb_min, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->gcv_arb_reject }}@if($data->sells[0]->gcv_arb_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ncv_min !== null )
              <tr>
                <td style="font-weight: bold">NCV ARB</td>
                <td>{{ number_format($data->sells[0]->ncv_min, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->ncv_reject }}@if($data->sells[0]->ncv_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->tm_min !== null )
              <tr>
                <td style="font-weight: bold">Total Moisture (ARB)</td>
                <td>{{ number_format($data->sells[0]->tm_min, 2) }} %</td>
                <td>{{ $data->sells[0]->tm_reject }}@if($data->sells[0]->tm_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->im_min !== null )
              <tr>
                <td style="font-weight: bold">Inherent Moisture (ADB)</td>
                <td>{{ number_format($data->sells[0]->im_min, 2) }} %</td>
                <td>{{ $data->sells[0]->im_reject }}@if($data->sells[0]->im_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->vm_min !== null )
              <tr>
                <td style="font-weight: bold">Volatile Matter (ADB)</td>
                <td>{{ number_format($data->sells[0]->vm_min, 2) }} %</td>
                <td>{{ $data->sells[0]->vm_reject }}@if($data->sells[0]->vm_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ash_min !== null )
              <tr>
                <td style="font-weight: bold">Ash (ADB)</td>
                <td>{{ number_format($data->sells[0]->ash_min, 2) }} %</td>
                <td>{{ $data->sells[0]->ash_reject }}@if($data->sells[0]->ash_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->fc_min !== null )
              <tr>
                <td style="font-weight: bold">Fixed Carbon (ADB)</td>
                <td>{{ number_format($data->sells[0]->fc_min, 2) }} %</td>
                <td>{{ $data->sells[0]->fc_reject }}@if($data->sells[0]->fc_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ts_min !== null )
              <tr>
                <td style="font-weight: bold">Total Sulphur (ADB)</td>
                <td>{{ number_format($data->sells[0]->ts_min, 2) }} %</td>
                <td>{{ $data->sells[0]->ts_reject }}@if($data->sells[0]->ts_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->hgi_min !== null )
              <tr>
                <td style="font-weight: bold">HGI</td>
                <td>{{ number_format($data->sells[0]->hgi_min, 2) }}</td>
                <td>{{ $data->sells[0]->hgi_reject }}</td>
              </tr>
              @endif

              @if($data->sells[0]->size_min !== null )
              <tr>
                <td style="font-weight: bold">SIZE (0-50mm)</td>
                <td>{{ number_format($data->sells[0]->size_min, 2) }} %</td>
                <td>{{ $data->sells[0]->size_reject }}@if($data->sells[0]->size_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->aft_min !== null )
              <tr>
                <td style="font-weight: bold">AFT (IDT)</td>
                <td>{{ number_format($data->sells[0]->aft_min, 2) }} Deg C</td>
                <td>{{ $data->sells[0]->aft_reject }}@if($data->sells[0]->aft_reject !== null) Deg C @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->na2o_min !== null)
              <tr>
                <td style="font-weight: bold">Na2O</td>
                <td>{{ number_format($data->sells[0]->na2o_min, 2) }} %</td>
                <td>{{ $data->sells[0]->na2o_reject }}@if($data->sells[0]->na2o_reject !== null) % @endif </td>
              </tr>
              @endif

            @else
              <tr style="font-weight: bold;">
                <td style="width: 30%;">Parameter</td>
                <td>Min</td>
                <td>Max</td>
                <td>Bonus</td>
                <td>Reject</td>
              </tr>

              @if($data->sells[0]->gcv_adb_min !== null || $data->sells[0]->gcv_adb_max !== null )
              <tr>
                <td style="font-weight: bold">GCV ADB</td>
                <td>{{ number_format($data->sells[0]->gcv_adb_min, 2) }} Kcal/Kg</td>
                <td>{{ number_format($data->sells[0]->gcv_adb_max, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->gcv_adb_bonus }}@if($data->sells[0]->gcv_adb_bonus !== null) Kcal/Kg @endif</td>
                <td>{{ $data->sells[0]->gcv_adb_reject }}@if($data->sells[0]->gcv_adb_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->gcv_arb_min !== null || $data->sells[0]->gcv_arb_max !== null )
              <tr>
                <td style="font-weight: bold">GCV ARB</td>
                <td>{{ number_format($data->sells[0]->gcv_arb_min, 2) }} Kcal/Kg</td>
                <td>{{ number_format($data->sells[0]->gcv_arb_max, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->gcv_arb_bonus }}@if($data->sells[0]->gcv_arb_bonus !== null) Kcal/Kg @endif</td>
                <td>{{ $data->sells[0]->gcv_arb_reject }}@if($data->sells[0]->gcv_arb_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ncv_min !== null || $data->sells[0]->ncv_max !== null )
              <tr>
                <td style="font-weight: bold">NCV ARB</td>
                <td>{{ number_format($data->sells[0]->ncv_min, 2) }} Kcal/Kg</td>
                <td>{{ number_format($data->sells[0]->ncv_max, 2) }} Kcal/Kg</td>
                <td>{{ $data->sells[0]->ncv_bonus }}@if($data->sells[0]->ncv_bonus !== null) Kcal/Kg @endif</td>
                <td>{{ $data->sells[0]->ncv_reject }}@if($data->sells[0]->ncv_reject !== null) Kcal/Kg @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->tm_min !== null || $data->sells[0]->tm_max !== null )
              <tr>
                <td style="font-weight: bold">Total Moisture (ARB)</td>
                <td>{{ number_format($data->sells[0]->tm_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->tm_max, 2) }} %</td>
                <td>{{ $data->sells[0]->tm_bonus }}@if($data->sells[0]->tm_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->tm_reject }}@if($data->sells[0]->tm_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->im_min !== null || $data->sells[0]->im_max !== null )
              <tr>
                <td style="font-weight: bold">Inherent Moisture (ADB)</td>
                <td>{{ number_format($data->sells[0]->im_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->im_max, 2) }} %</td>
                <td>{{ $data->sells[0]->im_bonus }}@if($data->sells[0]->im_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->im_reject }}@if($data->sells[0]->im_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->vm_min !== null || $data->sells[0]->vm_max !== null )
              <tr>
                <td style="font-weight: bold">Volatile Matter (ADB)</td>
                <td>{{ number_format($data->sells[0]->vm_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->vm_max, 2) }} %</td>
                <td>{{ $data->sells[0]->vm_bonus }}@if($data->sells[0]->vm_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->vm_reject }}@if($data->sells[0]->vm_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ash_min !== null || $data->sells[0]->ash_max !== null )
              <tr>
                <td style="font-weight: bold">Ash (ADB)</td>
                <td>{{ number_format($data->sells[0]->ash_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->ash_max, 2) }} %</td>
                <td>{{ $data->sells[0]->ash_bonus }}@if($data->sells[0]->ash_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->ash_reject }}@if($data->sells[0]->ash_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->fc_min !== null || $data->sells[0]->fc_max !== null )
              <tr>
                <td style="font-weight: bold">Fixed Carbon (ADB)</td>
                <td>{{ number_format($data->sells[0]->fc_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->fc_max, 2) }} %</td>
                <td>{{ $data->sells[0]->fc_bonus }}@if($data->sells[0]->fc_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->fc_reject }}@if($data->sells[0]->fc_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->ts_min !== null || $data->sells[0]->ts_max !== null )
              <tr>
                <td style="font-weight: bold">Total Sulphur (ADB)</td>
                <td>{{ number_format($data->sells[0]->ts_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->ts_max, 2) }} %</td>
                <td>{{ $data->sells[0]->ts_bonus }}@if($data->sells[0]->ts_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->ts_reject }}@if($data->sells[0]->ts_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->hgi_min !== null || $data->sells[0]->hgi_max !== null )
              <tr>
                <td style="font-weight: bold">HGI</td>
                <td>{{ number_format($data->sells[0]->hgi_min, 2) }}</td>
                <td>{{ number_format($data->sells[0]->hgi_max, 2) }}</td>
                <td>{{ $data->sells[0]->hgi_bonus }}</td>
                <td>{{ $data->sells[0]->hgi_reject }}</td>
              </tr>
              @endif

              @if($data->sells[0]->size_min !== null || $data->sells[0]->size_max !== null )
              <tr>
                <td style="font-weight: bold">SIZE (0-50mm)</td>
                <td>{{ number_format($data->sells[0]->size_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->size_max, 2) }} %</td>
                <td>{{ $data->sells[0]->size_bonus }}@if($data->sells[0]->size_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->size_reject }}@if($data->sells[0]->size_reject !== null) % @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->aft_min !== null || $data->sells[0]->aft_max !== null )
              <tr>
                <td style="font-weight: bold">AFT (IDT)</td>
                <td>{{ number_format($data->sells[0]->aft_min, 2) }} Deg C</td>
                <td>{{ number_format($data->sells[0]->aft_max, 2) }} Deg C</td>
                <td>{{ $data->sells[0]->aft_bonus }}@if($data->sells[0]->aft_bonus !== null) Deg C @endif</td>
                <td>{{ $data->sells[0]->aft_reject }}@if($data->sells[0]->aft_reject !== null) Deg C @endif</td>
              </tr>
              @endif

              @if($data->sells[0]->na2o_min !== null || $data->sells[0]->na2o_max !== null )
              <tr>
                <td style="font-weight: bold">Na2O</td>
                <td>{{ number_format($data->sells[0]->na2o_min, 2) }} %</td>
                <td>{{ number_format($data->sells[0]->na2o_max, 2) }} %</td>
                <td>{{ $data->sells[0]->na2o_bonus }}@if($data->sells[0]->na2o_bonus !== null) % @endif</td>
                <td>{{ $data->sells[0]->na2o_reject }}@if($data->sells[0]->na2o_reject !== null) % @endif </td>
              </tr>
              @endif

            @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-lg-4" id="order-approval">
      <div class="box">
        <div class="box-header" style="text-align:center;">
          <table class="table-bordered">
            <tbody>
              <tr>
                <th colspan=3 style="text-align:center; background: #989c9f; font-weight: bold !important;">
                  <span>Approval</span>
                </th>
              </tr>
            </tbody>

            <tbody>
              <tr style="font-weight: bold !important;">
                <td>Name</td>
                <td>Status</td>
                <td>Updated</td>
              </tr>
            </tbody>

            <tbody>
              @foreach($data->approvals as $approval)
              <tr>
                <td>
                  <img ng-src="{{$approval->image}}" class="img-circle div-img-circle small" style="float:left; margin:2px;" />
                  {{ $approval->name }}
                </td>
                <td>
                  {{  ($approval->pivot->status === 'a') ? 'Accepted' :
                    (($approval->pivot->status === 'r') ? 'Rejected' :
                    (($approval->pivot->status === 'y') ? 'Auto-Acc' :
                    (($approval->pivot->status === 'n') ? 'Auto-Rjct' : 'Pending'))) }}
                </td>
                <td>{{date("M d, Y H:i:s",strtotime($approval->pivot->updated_at))}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @endforeach
</body>
</html>
