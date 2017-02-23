<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Simple Transactional Email</title>
    <style>
      /* -------------------------------------
          GLOBAL RESETS
      ------------------------------------- */
      img {
        border: none;
        -ms-interpolation-mode: bicubic;
        max-width: 100%; }
      body {
        background-color: #f6f6f6;
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
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
        width: 100%; }
        table td {
          font-family: sans-serif;
          font-size: 14px; }
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
        border: 1px solid #eee !important;
        padding: 5px;
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
          border-color: #34495e !important; } }
    </style>
  </head>
  <body class="">
    <table border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <table class="main">

              <!-- START MAIN CONTENT AREA -->
              <tr>
                <td class="wrapper">
                  <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td>
                        <p>Hi there,</p>
                        <p>An order is waiting for you approval.</p>
                        <table border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr style="padding:10px 0;"><td>
                              <table class="table-bordered" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                  <tr>
                                    <td align="left">
                                      <small style="color:#333">Order ID</small><br>
                                      #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td align="center">
                                      <small style="color:#333">Requestor</small><br>
                                      {{ $order->trader->name }}
                                    </td>
                                    <td align="right">
                                      <small style="color:#333">Order Created</small><br>
                                      {{ date('d M y', strtotime($order->created_at)) }}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan=3>
                                      <table border="0" cellpadding="0" cellspacing="0" class="table-bordered">
                                        @foreach ($order->buys as $buy)
                                        <tr>
                                          <td>
                                            <small style="color:#333">Seller</small>
                                            <p>{{ $buy->company->company_name }}</p>
                                            @if(count($order->buys)>1)
                                            <small>Sales: {{ $buy->trader->name }}</small>
                                            @endif
                                          </td>

                                          <td>
                                            <p>{{ $buy->pivot->trading_term }}</p>
                                            <p>{{ $buy->pivot->payment_term }}</p>
                                          </td>

                                          <td>
                                            <small style="color:#333">Price</small>
                                            <p>{{ $buy->pivot->base_currency_id }} {{ number_format($buy->pivot->base_price, 2) }}</p>
                                          </td>
                                          <td>
                                            <small style="color:#333">Volume</small>
                                            <p>
                                              {{ $buy->pivot->volume }} mt
                                            </p>
                                          </td>
                                        </tr>
                                        @endforeach

                                        @foreach ($order->sells as $sell)
                                        <tr>

                                          <td>
                                            <small style="color:#333">Buyer</small>
                                            <p>{{ $sell->company->company_name }}</p>
                                            @if(count($order->sells)>1)
                                            <small>Sales: {{ $sell->trader->name }}</small>
                                            @endif
                                          </td>

                                          @if(config('app.showBuy'))
                                          <td>
                                            <p>{{ $sell->pivot->trading_term }}</p>
                                            <p>{{ $sell->pivot->payment_term }}</p>
                                          </td>
                                          @endif

                                          <td>
                                            <small style="color:#333">Price</small>
                                            <p>{{ $sell->pivot->base_currency_id }} {{ number_format($sell->pivot->base_price, 2) }}</p>
                                          </td>
                                          <td>
                                            <small style="color:#333">
                                              @if($sell->pivot->volume < 10000)
                                              Volume:
                                              @else
                                              Tonnage:
                                              @endif
                                            </small>
                                            <p>
                                              {{ $sell->pivot->volume }} MT
                                            </p>
                                          </td>
                                        </tr>
                                        @endforeach
                                      </table>
                                    </td>
                                  </tr>

                                  @if (count($order->buys) > 0 && count($order->sells) > 0)
                                  <tr align="center">
                                    <td>
                                      <p>BUY</p>
                                      <p style="font-size:18pt">{{ config('app.defaultCurrency') }} {{ number_format($order->average_buy_price, 2) }}</p>
                                      <small>{{ round(($order->average_buy_price-$index_price)*100 / $index_price, 2) }} %</small>
                                    </td>
                                    <td>
                                      <p>MARGIN</p>
                                      <p style="font-size:14pt">{{ config('app.defaultCurrency') }} {{ $order->average_sell_price - $order->average_buy_price }}</p>
                                      <small>Additional Cost: {{ config('app.defaultCurrency') }} {{ number_format($order->total_additional_costs, 2) }}</small>
                                    </td>
                                    <td>
                                      <p>SELL</p>
                                      <p style="font-size:14pt">{{ config('app.defaultCurrency') }} {{ number_format($order->average_sell_price, 2) }}</p>
                                      <small>{{ round(($order->average_sell_price-$index_price)*100 / $index_price, 2) }} %</small>
                                    </td>
                                  </tr>
                                  @elseif (count($order->buys) > 0 || !count($order->sells))
                                  <tr align="center">
                                    <td colspan="3">
                                      <p>TOTAL PRICE</p>
                                      <p style="font-size:14pt">{{ config('app.defaultCurrency') }} {{ number_format($order->total_buy_price, 2) }}</p>
                                      <small>Volume: {{ number_format($order->total_buy_volume, 0) }} MT</small>
                                      <small>Additional Cost: {{ config('app.defaultCurrency') }} {{ number_format($order->total_additional_costs, 2) }}</small>
                                    </td>
                                  </tr>
                                  @elseif (count($order->sells) > 0 || !count($order->buys))
                                  <tr align="center">
                                    <td colspan="3">
                                      <p>TOTAL PRICE</p>
                                      <p style="font-size:14pt">{{ config('app.defaultCurrency') }} {{ number_format($order->total_sell_price, 2) }}</p>
                                      <small>Volume: {{ number_format($order->total_sell_volume, 0) }} MT</small>
                                      <small>Additional Cost: {{ config('app.defaultCurrency') }} {{ number_format($order->total_additional_costs, 2) }}</small>
                                    </td>
                                  </tr>
                                  @endif

                                  <tr align="center">
                                    <td>
                                      <p>Typical Quality</p>
                                      @if (count($order->buys) > 0)
                                      <p style="font-size:14pt">{{ $order->buys[0]->typical_quality }}</p>
                                      @elseif (count($order->sells) > 0)
                                      <p style="font-size:14pt">{{ $order->sells[0]->typical_quality }}</p>
                                      @endif
                                    </td>
                                    <td>
                                      <p>{{ $index_name }}</p>
                                      <p style="font-size:14pt">
                                        {{ config('app.defaultCurrency') }}
                                        {{ $index_price }}
                                      </p>
                                    </td>
                                    <td>
                                      <p>LayCan Period</p>
                                      <p style="font-size:10pt">{{ date('dd/MM/yy', strtotime($order->laycan_start)) }}<br>
                                      {{ date('dd/MM/yy', strtotime($order->laycan_end)) }}</p>
                                    </td>
                                  </tr>

                                  <tr align="center">
                                    <td colspan=3>
                                      Reason: {{ $order->request_reason }}
                                    </td>
                                  </tr>
                                  
                                </tbody>
                              </table>
                            </td></tr>
                            <tr>
                              <td colspan="3" align="left">
                                <table border="0" cellpadding="0" cellspacing="0">
                                  <tbody>
                                    <tr>
                                      <td class="btn btn-danger">
                                        <a href="{{ config('app.baseUrl') }}/api/orders/{{ $order->id }}/approval?status=r&approval_token={{ $approval_token }}">
                                          Reject
                                        </a>
                                      </td>
                                      <td class="btn btn-primary">
                                        <a href="{{ config('app.baseUrl') }}/api/orders/{{ $order->id }}/approval?status=a&approval_token={{ $approval_token }}">
                                          Approve
                                        </a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>

              <!-- END MAIN CONTENT AREA -->
              </table>

            <!-- START FOOTER -->
            <div class="footer">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block">
                    <span class="apple-link">Sinarmas Mining</span>
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by">
                    Powered by <a href="http://volantech.io">volantech</a>.
                  </td>
                </tr>
                <tr>
                  <td class="content-block powered-by">
                    This email and any files transmitted with it are confidential and intended solely for the use of the individual or entity to whom they are addressed. If you have received this email in error please notify the system manager. Please note that any views or opinions presented in this email are solely those of the author and do not necessarily represent those of the company. Finally, the recipient should check this email and any attachments for the presence of viruses. The company accepts no liability for any damage caused by any virus transmitted by this email.
                  </td>
                </tr>
              </table>


            </div>

            <!-- END FOOTER -->

<!-- END CENTERED WHITE CONTAINER --></div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
