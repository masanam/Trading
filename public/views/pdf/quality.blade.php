<html>
<head>
  <meta name="viewport" content="width=device-width" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Report</title>
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
      /*mso-table-lspace: 0pt;*/
      /*mso-table-rspace: 0pt;*/
      width: 100%; }
    table td {
      font-family: sans-serif;
      font-size: 14px; }
    table .header {
      border: 1px solid #000 !important;
      padding: 5px;
      vertical-align: middle; }

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
      border: 1px solid #000 !important;
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
<body border="0" cellpadding="0" cellspacing="0" class="table-bordered">
  <table>
    <thead>
      <tr><th colspan="13" text-align="center">MV. CHS Magnigicence</th></tr>
      <tr><th colspan="13" text-align="center">PINE(ADANI) - SHIPMENT ORDER</th></tr>
      <tr><th colspan="13" text-align="center">Laycan : dd - dd mm yyyy </th></tr>
      <tr><th colspan="13" text-align="center">QUALITY SPECIFICATION (as Marketing & Operation Aprroval)</th></tr>
    </thead>
  </table>

  <table class="header">
    <thead>
      <tr>
        <td colspan="3">Contract No.</td>
        <td colspan="4">: </td>
        <td colspan="6">Document Required:</td>
      </tr>
      <tr>
        <td colspan="3">Buyer Name (destination)</td>
        <td colspan="4">: </td>
        <td colspan="6">1. Commercial Invoice (3/3)</td>
      </tr>
      <tr>
        <td colspan="3">Shipment No</td>
        <td colspan="4">: </td>
        <td colspan="6">2. Buls of Landing (3/4)</td>
      </tr>
      <tr>
        <td colspan="3">Cargo Tonnage</td>
        <td colspan="4">: </td>
        <td colspan="6">3. Certificate of Analysis (1/4)</td>
      </tr>
      <tr>
        <td colspan="3">Coal Brand</td>
        <td colspan="4">: </td>
        <td colspan="6">4. Draft Survey Report (1/4)</td>
      </tr>
      <tr>
        <td colspan="3">Term (FOB/C&F/CIF)</td>
        <td colspan="4">: </td>
        <td colspan="6">5. Certificate of Weight (1/4)</td>
      </tr>
      <tr>
        <td colspan="3">Standard Analysis (ASTM/ISO/etc)</td>
        <td colspan="4">: </td>
        <td colspan="6">6. Certificate of Origin (1/4)</td>
      </tr>
      <tr>
        <td colspan="3">Superintending / Surveyor Company</td>
        <td colspan="4">: </td>
        <td colspan="6">7. Certificate of Origin Government (1/13)</td>
      </tr>
      <tr>
        <td colspan="3">Witness Company</td>
        <td colspan="4">: </td>
        <td colspan="6"></td>
      </tr>
      <tr>
        <td colspan="3">Shipping Agent</td>
        <td colspan="4">: </td>
        <td rowspan="4"colspan="1">Note :</td>
        <td rowspan="4"colspan="5"></td>
      </tr>
      <tr>
        <td colspan="3">Vessel Name's (Crane;Grab)</td>
        <td colspan="4">: </td>
      </tr>
      <tr>
        <td colspan="3">Loading Rate (Demm/Desp)</td>
        <td colspan="4">: </td>
      </tr>
      <tr>
        <td colspan="3">ETA</td>
        <td colspan="4">: </td>
      </tr>
    </thead>
  </table>
    <br />
    <br />
    <br />
  <table border="1">
    <thead>
      <tr>
        <th rowspan="2" colspan="3">QUALITY SPECIFICATION</th>
        <th colspan="4">GUARANTY SPECIFICATION</th>
        <th colspan="3">REJECTION LIMIT</th>
        <th colspan="3">TARGET & RESULT</th>
      </tr>
      <tr>
        <th>ARB</th>
        <th>ADB</th>
        <th>DAF</th>
        <th>DB</th>
        <th>Basis</th>
        <th>Value</th>
        <th>Max/Min</th>
        <th>Basis</th>
        <th>Target</th>
        <th>Result</th>
      </tr>
      <tr>
        <th colspan="13">PROXIMATE ANALYSIS</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Gross Calorific Value</td>
        <td>GAR</td>
        <td>Kcal/Kg</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <th colspan="13">Ash Fusion Temperature (Reducing Atmosphere)</th>
      </tr>
      <tr>
        <td>Initial Deformation</td>
        <td></td>
        <td>degree C</td>
        <td colspan="4"></td>
        <td colspan="3"></td>
        <td colspan="2"></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <br /><br /><br />

  <table>
    <thead>
      <tr>
        <th colspan="10">Adjustment of Base Price</th>
        <th colspan="3">Notes / Remarks</th>
      </tr>
      <tr>
        <th colspan="10">isi formula</th>
        <th rowspan="8" colspan="3">----</th>
      </tr>
      <tr>
        <th colspan="2">APROVAL TABLE</th>
        <th colspan="2">NAME</th>
        <th colspan="2">SIGN / DATE</th>
        <th colspan="4">DISTRIBUTION LIST</th>
      </tr>
      <tr>
        <td rowspan="3" colspan="2">MARKETING & SALSES DIV</td>
        <td rowspan="3" colspan="2"></td>
        <td rowspan="3" colspan="2"></td>
        <td colspan="2">GM</td>
        <td colspan="2">isi gm</td>
      </tr>
      <tr>
        <td colspan="2">Mining</td>
        <td colspan="2">isi mining</td>
      </tr>
      <tr>
        <td colspan="2">PQDC</td>
        <td colspan="2">isi pdc</td>
      </tr>
      <tr>
        <td rowspan="3" colspan="2">MDG DIVISION</td>
        <td rowspan="3" colspan="2"></td>
        <td rowspan="3" colspan="2"></td>
        <td colspan="2">Shipping</td>
        <td colspan="2">isi shipping</td>
      </tr>
      <tr>
        <td rowspan="2" colspan="2">Mkt & Sales</td>
        <td colspan="2">M&S isinya yg baris satu</td>
      </tr>
      <tr>
        <td colspan="2">M&S isinya yg baris kedua</td>
      </tr>
    </thead>
  </table>

</body>
</html>
