<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $invoice->name }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 10px;
            margin: 36pt;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        strong {
            font-weight: bolder;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        h4,
        .h4 {
            margin-bottom: 0.5rem;
            font-weight: 500;
            line-height: 1.2;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
        }

        .table.table-items td {
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .mt-5 {
            margin-top: 3rem !important;
        }

        .pr-0,
        .px-0 {
            padding-right: 0 !important;
        }

        .pl-0,
        .px-0 {
            padding-left: 0 !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-uppercase {
            text-transform: uppercase !important;
        }

        * {
            font-family: "DejaVu Sans";
        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        table,
        th,
        td,
        p,
        div {
            line-height: 1.1;
        }

        .party-header {
            font-size: 1.5rem;
            font-weight: 400;
        }

        .total-amount {
            font-size: 12px;
            font-weight: 700;
        }

        .border-0 {
            border: none !important;
        }

        .cool-gray {
            color: #6B7280;
        }

        #c-table td {
            padding-bottom: 10px !important;
        }
    </style>
</head>


<body>
    {{-- Header --}}
    <table class="table" style="border-bottom: 1px solid black;">
        <tr>
            <td width="25%"> @if($invoice->notes)
                <img src="{{ $invoice->notes }}" height="80" alt="">
                @endif
            </td>
            <td style="text-align: center; padding-top: 25px;">
                @if($invoice->seller->name)
                <p style="font-size: 18px;">
                    <strong>{{ $invoice->seller->name }}</strong>
                </p>
                @endif
                @if($invoice->seller->address)
                <p style="margin-top: -10px;">
                    {{ $invoice->seller->address }}
                </p>
                @endif
                <table style="margin-top: -20px; padding-left: 30px;">
                    <tr>
                        @foreach($invoice->seller->custom_fields as $key => $value)
                        <td class="seller-custom-field" width='50%'>
                            {{ ucfirst($key) }}: {{ $value }}
                        </td>
                        @endforeach
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>
    </table>

    <h4 class="text-uppercase" style="text-align: center;">
        <strong>{{ $invoice->name }}</strong>
    </h4>





    <table id="c-table" style="margin-top: 30px;">
        <tr>
            <td width='20%'>Nama</td>
            <td width="15%" style="padding-left: 20px;">:</td>
            <td>
                @if($invoice->buyer->name)
                <div class="buyer-name" style="margin-left: 20px;">
                    {{ $invoice->buyer->name }}
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td width='20%'>Alamat</td>
            <td width="15%" style="padding-left: 20px;">:</td>
            <td>
                @if($invoice->buyer->address)
                <div class="buyer-address" style=" margin-left: 20px;">
                    {{ $invoice->buyer->address }}
                </div>
                @endif
            </td>
        </tr>

        <tr>
            <td width='20%'>Nomor Handphone</td>
            <td width="15%" style="padding-left: 20px;">:</td>
            <td>
                @if($invoice->buyer->phone)
                <div class="buyer-phone" style="margin-left: 20px;">
                    {{ $invoice->buyer->phone }}
                </div>
                @endif
            </td>
        </tr>
        <tr>
            <td width='20%'>Tanggal Nota Dibuat</td>
            <td width="15%" style="padding-left: 20px;">:</td>
            <td>
                <div style="margin-left: 20px;">
                    {{$invoice->getDate() }}
                </div>
            </td>
        </tr>
    </table>


    {{-- Table --}}
    <table class="table table-items">
        <thead>
            <tr>
                <th scope="col" class="border-0 pl-0">
                    <!-- {{ __('invoices::invoice.description') }} -->
                    Deskripsi
                </th>
                @if($invoice->hasItemUnits)
                <th scope="col" class="text-center border-0">
                    {{ __('invoices::invoice.units') }}
                </th>
                @endif
                <th scope="col" class="text-center border-0">
                    {{ __('invoices::invoice.quantity') }}
                </th>
                <th scope="col" class="text-right border-0">
                    <!-- {{ __('invoices::invoice.price') }} -->
                    Harga
                </th>
                @if($invoice->hasItemDiscount)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.discount') }}</th>
                @endif
                @if($invoice->hasItemTax)
                <th scope="col" class="text-right border-0">{{ __('invoices::invoice.tax') }}</th>
                @endif
                <th scope="col" class="text-right border-0 pr-0">
                    <!-- {{ __('invoices::invoice.sub_total') }} -->
                    Total
                </th>
            </tr>
        </thead>
        <tbody>
            {{-- Items --}}
            @foreach($invoice->items as $item)
            <tr>
                <td class="pl-0">
                    {{ $item->title }}

                    @if($item->description)
                    <p class="cool-gray">{{ $item->description }}</p>
                    @endif
                </td>
                @if($invoice->hasItemUnits)
                <td class="text-center">{{ $item->units }}</td>
                @endif
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->price_per_unit) }}
                </td>
                @if($invoice->hasItemDiscount)
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->discount) }}
                </td>
                @endif
                @if($invoice->hasItemTax)
                <td class="text-right">
                    {{ $invoice->formatCurrency($item->tax) }}
                </td>
                @endif

                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($item->sub_total_price) }}
                </td>
            </tr>
            @endforeach
            {{-- Summary --}}
            @if($invoice->hasItemOrInvoiceDiscount())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.total_discount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_discount) }}
                </td>
            </tr>
            @endif
            @if($invoice->taxable_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.taxable_amount') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->taxable_amount) }}
                </td>
            </tr>
            @endif
            @if($invoice->tax_rate)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.tax_rate') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->tax_rate }}%
                </td>
            </tr>
            @endif
            @if($invoice->hasItemOrInvoiceTax())
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.total_taxes') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->total_taxes) }}
                </td>
            </tr>
            @endif
            @if($invoice->shipping_amount)
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">{{ __('invoices::invoice.shipping') }}</td>
                <td class="text-right pr-0">
                    {{ $invoice->formatCurrency($invoice->shipping_amount) }}
                </td>
            </tr>
            @endif
            <tr>
                <td colspan="{{ $invoice->table_columns - 2 }}" class="border-0"></td>
                <td class="text-right pl-0">
                    <!-- {{ __('invoices::invoice.total_amount') }} -->
                    Total Yang Dibayarkan
                </td>
                <td class="text-right pr-0 total-amount">
                    {{ $invoice->formatCurrency($invoice->total_amount) }}
                </td>
            </tr>
        </tbody>
    </table>



    <!-- <p>
            {{ __('invoices::invoice.amount_in_words') }}: {{ $invoice->getTotalAmountInWords() }}
        </p>
        <p>
            {{ __('invoices::invoice.pay_until') }}: {{ $invoice->getPayUntilDate() }}
        </p> -->

    @if($invoice->logo)
    <div style="float: right; margin-top: 50px; display: flex; flex-direction: row;">

        <div style="position: relative;">
            <p style="text-align: center;">Sragen, {{$invoice->getDate() }}</p>

            @if($invoice->notes)
            <img src="{{ $invoice->notes }}" height="80" alt="" style="position: absolute; left: 20px; top: 40px;" />
            @endif
            <img src="{{ $invoice->getLogo() }}" alt="logo" height="100" style="z-index: 99; position: absolute; left: 70px;" />
            @if($invoice->seller->name)
            <p class="seller-name" style="margin-top: 100px; text-align: center;">
                <strong>{{ $invoice->seller->name }}</strong>
            </p>
            @endif
        </div>
    </div>
    @endif

    <script type="text/php">
        if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "{{ __('invoices::invoice.page') }} {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }
        </script>
</body>

</html>