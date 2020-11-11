<body>
    <!--mpdf
    <htmlpageheader name="myheader">
        <div class="header">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 20%;">
                            <img
                                class="brand-logo"
                                src="https://i.ibb.co/3SK9FY7/imagotipo.png"
                                alt="About The Fit logo"
                                border="0"
                            />
                        </td>
                        <td style="width: 60%;font-size: 14pt;">
                            5230 Newell Road <br />
                            Palo Alto <br />
                            CA 94020 <br />
                            @aboutthefit
                        </td>
                        <td style="width: 20%; text-align: right;">
                            <p class="invoice-no-title" style="font-size: 18px;">Invoice No.</p>
                            <span class="invoice-number" style="font-size: 18px; font-weight: bold;padding-top:5px;">
                                {{ $details->id }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </htmlpageheader>
    <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
        Page {PAGENO} of {nb}
        </div>
    </htmlpagefooter>

    <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myfooter" value="on" />
    mpdf-->

    <div class="content">
        <h1>Invoice</h1>
        <table>
            <tbody>
                <tr>
                    <td>
                        <strong>Date:</strong> {{ $details->created_at }}
                    </td>
                    <td style="text-align: right;">
                        <strong>Customer ID:</strong> {{ $details->user }}
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="purchases" style="font-size: 11pt; margin-top: 20px;" cellpadding="8">
            <thead>
                <tr>
                    <td width="10%">Ref. No.</td>
                    <td width="15%">Quantity</td>
                    <td width="40%">Description</td>
                    <td width="20%">Unit Price</td>
                    <td width="15%">Amount</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td align="center" width="15%">{{ $item->product_id }}</td>
                    <td align="center" width="10%">{{ $item->quantity }}</td>
                    <td width="45%">{{ $item->description }}</td>
                    <td align="center" width="15%">${{ $item->total / $item->quantity}}</td>
                    <td align="center" width="15%">${{ $item->total }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="blanktotal" colspan="3" rowspan="6"></td>
                    <td class="totals">Subtotal:</td>
                    <td class="totals">
                        @php
                            $amount = 0;
                            foreach($items as $item) {
                                $amount += $item->total;
                            }
                        @endphp
                        ${{$amount}}
                    </td>
                </tr>
                <tr>
                    <td class="totals">Shipping:</td>
                    <td class="totals">${{ $details->shipping }}</td>
                </tr>
                <tr>
                    <td class="totals"><b>TOTAL:</b></td>
                    <td class="totals"><b>${{ $details->amount }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>