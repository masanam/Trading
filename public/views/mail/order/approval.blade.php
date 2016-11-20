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
                                    <td align="left">ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td align="center">{{ $order->trader->name }}</td>
                                    <td align="right">{{ date('Y-m-d', strtotime($order->created_at)) }}</td>
                                  </tr>
                                  <tr>
                                    <td colspan=3>
                                      Reason: {{ $order->request_reason }}
                                    </td>
                                  </tr>
                                  <tr align="center">  
                                    <td style="font-size:36pt">
                                      {{ $order->sells[0]->typical_quality }}
                                    </td>
                                    <td>
                                      <p style="font-size:12pt">GC NEWC</p>
                                      <p style="font-size:24pt">$ 62.89</p>
                                    </td>
                                    <td>
                                      <p style="font-size:12pt">LayCan Period</p>
                                      {{ $order->sells[0]->ready_date }}<br>
                                      {{ $order->sells[0]->expired_date }}
                                    </td>
                                  </tr>
                                  <tr align="center">
                                    <td>
                                      <p style="font-size:12pt">BUY</p>
                                      <p style="font-size:24pt">$ {{ $order->sells[0]->pivot->price }}</p>
                                      <small>{{ round(($order->sells[0]->pivot->price-62.89)*100 / (62.89), 2) }} %</small>
                                    </td>
                                    <td>
                                      <p style="font-size:12pt">MARGIN</p>
                                      <p style="font-size:24pt">$ {{ $order->buys[0]->pivot->price - $order->sells[0]->pivot->price }}</p>
                                    </td>
                                    <td>
                                      <p style="font-size:12pt">SELL</p>
                                      <p style="font-size:24pt">$ {{ $order->buys[0]->pivot->price }}</p>
                                      <small>{{ round(($order->buys[0]->pivot->price-62.89)*100 / (62.89), 2) }} %</small>
                                    </td>
                                  </tr>
                                  
                                  <tr>
                                    <td colspan=3>
                                      <table border="0" cellpadding="0" cellspacing="0" class="table-bordered">
                                        @foreach ($order->sells as $sell)
                                        <tr>
                                          <td class="btn-danger">BUY</td>

                                            <p>{{ $sell->seller->company_name }}</p>
                                            <small>{{ $sell->trader->name }}</small>
                                          </td>

                                          <td>
                                            <p>{{ $sell->pivot->trading_term }}</p>
                                            <p>{{ $sell->pivot->payment_term }}</p>
                                          </td>

                                          <td>$ {{ $sell->pivot->price }}</p>
                                          <td>{{ $sell->pivot->volume }} mt</p>
                                          </td>
                                        </tr>
                                        @endforeach

                                        @foreach ($order->buys as $buy)
                                        <tr>
                                          <td class="btn-primary">SELL<td>

                                            <p>{{ $buy->buyer->company_name }}</p>
                                            <small>{{ $buy->trader->name }}</small>
                                          </td>

                                          <td>
                                            <p>{{ $buy->pivot->trading_term }}</p>
                                            <p>{{ $buy->pivot->payment_term }}</p>
                                          </td>

                                          <td>$ {{ $buy->pivot->price }}</p>
                                          <td>{{ $buy->pivot->volume }} mt</p>
                                          </td>
                                        </tr>
                                        @endforeach
                                      </table>
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
                                        <a href="http://coaltrade.volantech.io/api/order/{{ $order->id }}/reject-now">
                                          Reject
                                        </a>
                                      </td>
                                      <td class="btn btn-primary">
                                        <a href="http://coaltrade.volantech.io/api/order/{{ $order->id }}/approve-now">
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