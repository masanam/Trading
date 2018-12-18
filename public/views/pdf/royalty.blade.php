<html>
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Royalty Request {{$date->toFormattedDateString()}}.pdf</title>
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
      font-size: 12px;
      line-height: 1.4;
      margin: 0;
      padding: 0;
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%; }
    table {
      border-collapse: separate;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      width: 100%; }
      table td {
        font-family: sans-serif;
        font-size: 12px; }
    /* -------------------------------------
        BODY & CONTAINER
    ------------------------------------- */
    .body {
      background-color: #ffffff;
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
      text-transform: capitalize; }
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
      border: 1px solid #000;
      padding: 5px;
      vertical-align: middle;
    }
    .footer-table td{
      text-align: center;
      border: 0px;
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
        border-color: #34495e !important; } }
  </style>
</head>
<body border="0" cellpadding="0" cellspacing="0" class="table-bordered">
  <div class="row">
    <div style="float: left;">
      <img src="./images/berau.jpg" style="width:60px; margin-right: 10px;">
    </div>
    <div style="text-align: center;">
      <h2>
        <b>RENCANA SHIPMENT PT BERAU COAL</b><br/>
        <span style="font-size:13px;">{{date("M d, Y", strtotime($date))}}</span>
      </h2>
    </div>
  </div>
  <br>
  <!-- <div class="row">
    <div style="float: left;">
      <span>week : </span>
      @if($week == 1)
      <span>1st week of {{date("F", mktime(0, 0, 0, $date->month, 1))}} {{$date->year}}</span>
      @elseif($week == 2)
      <span>2nd week of {{date("F", mktime(0, 0, 0, $date->month, 1))}} {{$date->year}}</span>
      @elseif($week == 3)
      <span>3rd week of {{date("F", mktime(0, 0, 0, $date->month, 1))}} {{$date->year}}</span>
      @elseif($week == 4)
      <span>4th week of {{date("F", mktime(0, 0, 0, $date->month, 1))}} {{$date->year}}</span>
      @endif
      <br>
      <span>date : </span>
      <span>{{date("M d, Y", strtotime($date))}}</span>
      <br><br>
    </div>
  </div> -->
  <br><br>
  <div class="row">
    <table style="border-spacing:0px;">
    <thead>
      <tr>
        <th>Month</th>
        <th>No</th>
        <th>Buyer</th>
        <th>Vessel Name</th>
        <th>Brand</th>
        <th>Typical</th>
        <th>Tonnage</th>
        <th>LD</th>
        <th>ETA</th>
        <th>ETD</th>
        <th>ETC</th>
        <th>Price (USD)</th>
        <th>Price (IDR)</th>
        <th>AMOUNT (USD)</th>
        <th>AMOUNT (IDR)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($shipments as $key=>$s)
      <tr>
        <td>{{date("F", mktime(0, 0, 0, $date->month, 1))}}</td>
        <td>{{$key+1}}</td>
        <td>{{$s->customer->company_name}}</td>
        <td>{{$s->vessel->vessel_name}}</td>
        <td>{{$s->products->name_product_variant}}</td>
        <td>{{$s->products->product->typical_quality}}</td>
        <td style="padding-right: 33px;">{{number_format($s->volume)}} mt</td>
        <td>{{ date("d/M/Y", strtotime($s->laycan_start_actual)) }} ~ {{ date("d/M/Y", strtotime($s->laycan_end_actual)) }}</td>
        <td>{{ date("d/M/Y", strtotime($s->eta)) }}</td>
        <td>{{ date("d/M/Y", strtotime($s->etd)) }}</td>
        <td>{{ date("d/M/Y", strtotime($s->etc)) }}</td>
        <td style="padding-right: 30px;">{{$s->currency == 'USD' ? number_format($s->price) : '-'}}</td>
        <td style="padding-right: 30px;">{{$s->currency == 'IDR' ? number_format($s->price) : '-'}}</td>
        <td>{{$s->currency == 'USD' ? number_format($s->volume*$s->price) : '-'}}</td>
        <td>{{$s->currency == 'IDR' ? number_format($s->volume*$s->price) : '-'}}</td>
      </tr>
      @endforeach
      <tr>
        <th colspan=13 style="text-align: right;">Total Amount</th>
        <th>USD {{number_format($total_usd)}}</th>
        <th>IDR {{number_format($total_idr)}}</th>
      </tr>
    </tbody>
    </table>
  </div>
  <br><br>
  <div class="row">
    <table class="footer-table">
      <tbody>
        <tr>
          <td>Dibuat oleh:</td>
          <td>Mengetahui:</td>
        </tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr>
          <td>{{$creator}}</td>
          <td>{{$acknowledger}}</td>
        </tr>
        <tr><td></td><td></td></tr>
        <tr>
          <td colspan=2>Menyetujui:</td>
        </tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr><td></td><td></td></tr>
        <tr>
          <td colspan=2>{{$approver}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
</html>
