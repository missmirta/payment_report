<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Title</title>
    <style>
        @page {
            margin: 8pt 2pt;
        }

        * {
            box-sizing: border-box;
            font-family: Inter;
            color: #1a1e25;
        }

        span {
            margin: 0;
            font-size: 10pt;
            line-height: 15pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-color: #1a1e25;
        }

        th,
        td,
        span,
        div {
            font-size: 7.5pt;
        }

        td {
            text-align: center;
            font-weight: 500;
        }

        .report th {
            text-transform: uppercase;
        }

        .main-title {
            display: inline-block;
            font-size: 10pt;
            font-weight: 700;
            line-height: 14pt;
            letter-spacing: -0.01em;
            color: #343b8e;
            max-width: 105pt;
            text-align: left;
        }

        .region {
            text-transform: uppercase;
        }

        .district {
            font-weight: 600;
        }

        .thin {
            font-weight: 400;
        }

        .amount {
            text-align: right;
        }

        #region {
            border-top: 1px solid transparent;
            border-left: 1px solid transparent;
        }

        .filter {
            font-size: 6pt;
            font-weight: normal;
        }

        .filter.period {
            font-size: 6pt;
            font-weight: 600;
            color: #8a9090;
        }

        .bold {
            font-weight: 800;
        }

        .logo-wrapper > img {
            width: 30pt;
            height: 30pt;
        }
    </style>
</head>
<body>
<div class="container">
    <table>
        <th style="margin-top: 10pt; width: 200px; text-align: left">
            <div class="filter period">PERIOD</div>
            <div class="filter bold">{{ $data['period'] }}</div>
        </th>
        <th>
            <div style="font-size: 10pt">GWCL Paypoints</div>
            <div style="font-size: 10pt; color: #343b8e">{{ $data['data']['paypoint_number'] }}</div>
        </th>
        <th style="width: 200px">
            <div class="logo-wrapper" style="text-align: right">
                <img
                        class="logo"
                        src="https://lh3.googleusercontent.com/fife/AGXqzDlzFjiumn1dAKRxpeljyjsKvft0tVdAzobkikNLYSvX7WTfi9YezLt-vUZ1IznNC7x4kLSjshuwOrMs5t2C8WAbY1MBLFhsWG_3KMb9sks78RufFPDn_dLxpyItrA7Ru0MZ5hEzghVJ4Udbx_cULP8CPzYPn15f9Ye7OxqhZn8J0LZVtgP5bZluM9goQCFXHAfWOadw6gOKw1equIL8GKQkHiCprKeT78P4munyMHTFB59T6VS1NNpBxLb8QeT5JtvLfwWQMA_vGycWFTxPnP88Q3zL6-F-kFLCkukKDbPL6qxwXMuLsoqMg0qKOtXf9GdRIAJl1G14xJYLyQfhZgPGVvrh3bVWaHBP8Hbl_CBhV4SaY05AsFUAnS6Z4HRWXdqYHmL5dBNZ7_EMycHMP_Hi9ziu1RKmcZqSGWG3odjJfmyezlZ_Rl8V0Bv2Xl4LHuLFk5dM0_XXRY4HAwqz7Nwi1Z9J5eyGeICJZluYRiCH3Fbe7BMX_PU4DfAYywEDuNOuw9-E7Qr3r74uXK6-Cv6dMDQe7XHNiOIOVLQTcONntkg4k1T_difsa3mE9Rt4NCCQntL8OTMwQN3Qz9fHGmZm_7_lbnQUFEw5y8ODnzcdkxE6NizUNymqr7MMcXVcGXQb88N8DrCbql4kuMv1aT1rUGOhmLPCNS0N1rQilc8iTvdbD84xTp-dRm-j9nxPdyT46M7DfW3qSJl5bykPDFizCKveFmWcYdQeErYJB8M2m74QlDZvk4LrQXuOa0t98WKp1HwRSlH3azf4x8FmjGmzSNSRPRWwOzlgU7ji-PgBeovSG1kGWzjUzWrpFoMPrsn157hK7MkHifLxfpf5c4Bz_G6qzTVfVwQJA95bIHOJKJ8GL83Nq4di9NNTqPCjLn-qdC5iWQVwNN3use6xIR6nQ9KBMtp6OWUT5aPw43-L0L5mnDPqqdLKBOC2j-Il_wmN8LYtSs1n4fT_gi-Tphc_blUp40BlUuxuDBcc_B9_eLsi-FuurqaJFTflEwByBlpVsCo9vu3TuX5kuEB8urIIwJVRXeNJuzLm07VjWhVgvEStDdr96WKV6lbCJz4e4mZaS202Mp12epmSe5B1gnGAypAY5HvIeBvFDOuHfC9jwuPXYNoXMcGey4XVKDR_3fRuPvSKzW0U-Qmb0Z5DYYkluvWZv69oA7zt0pnCvjPRQDVF53TKo5CYReBM1d0PJuUUSdyrn6L8yO6wMpRFEzzWicQ2QlLW2YXKFo-2yGSst7c8cr4aIpZ0PSFheJuag_wJd8XpqZFSFiFM1ImmhZbxGCQXnek1RMAUR7jJpVKKMCJIBs_qmCrYKUZWvhQneY1BAlG_19h6tbdi4YgKfUBv6D2CHfy0BcrgVHoWP15wGuyD-q8k5nB05v4a3krPZ63h_xKtGM0us-RJKt0bzvpuX06TMQYRvOsM5QuDWvbhRSjClAVeT7OdRq2AKAnAJ8Ci7CBoPpMsAzD6pexnHGqcTAmlKLfsHW2WwA3aukRikU94KqEADCcUigNN_k7ttdrPo8ZF3LCbRMEd02Fuv31gMQrmQyf3-RJzT6q7aI5Z4zqnFvL_=w3456-h1918"
                />
                <span class="main-title" style="max-width: 85pt">Ghana Water Company Limited</span>
            </div>
        </th>
    </table>
    <div style="height: 1pt; width: 100%; background: #343b8e; margin: 12pt 0"></div>

    <!--  REPORT   -->

    <table class="report" border="1">
        <thead>
        <tr>
            <th class="bold" id="paypoint">Paypoint</th>
            <th class="bold" id="location">Location</th>
            <th class="bold" id="contacts">Contacts</th>
            <th class="bold" id="cashiers" style="max-width: 36pt">Cashiers</th>
            <th class="bold" id="payments">Payments</th>
            <th class="bold" id="added_on">Added On</th>
        </tr>
        </thead>

        <!--    BODY     -->

        <tbody>
        @php
            $itemsPerPage = 20;
            $totalItems = count($data['data']);
            $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = 1;
            $keyInt = 1;
        @endphp
        @foreach ($data['data'] as $key => $row)
            @if(is_array($row))
                @php
                    $keyInt++;
                @endphp
                @if(in_array($data['basis'], ['RG', 'DS']))
                    <tr>
                        <td class="bold region" headers="region" colspan="6">{{ $key }}</td>
                    </tr>
                @endif
                @foreach ($row as $rowKey => $rowRow)
                    @if($data['basis'] == 'DS')
                        <tr>
                            <td class="district" headers="district">{{ $rowKey }}</td>
                            <td class='district' colspan='5'></td>
                        </tr>
                    @endif
                @foreach ($rowRow as $k => $v)
                <tr>
                    <td headers="paypoint">{{ $v['name'] }}</td>
                    <td headers="location">
                        <div class="thin" data-name="arrea">{{ $v['location'] }}</div>
                        <div class="thin" data-name="postal_code">{{ $v['address'] }}</div>
                    </td>
                    <td headers="contacts">
                        <div class="thin" data-name="email">{{ $v['email'] }}</div>
                        <div class="thin" data-name="phone">{{ $v['phone_number'] }}</div>
                    </td>
                    <td class="amount" headers="cashiers">{{ $v['cashiers_count'] }}</td>
                    <td class="amount" headers="payments">{{ $v['payment_total'] ?? 0 }}</td>
                    <td headers="added_on" style="max-width: 50px">
                        {{ \Carbon\Carbon::make($v['created_at'])->format('F d, Y') }}
                    </td>
                </tr>
                    @if ($keyInt % $itemsPerPage == 0)
                        @php $currentPage++; @endphp
                    @endif
                @endforeach
                @endforeach
            @endif
        @endforeach
        </tbody>
    </table>
    <div style="height: 8pt"></div>
    <table>
        <tr>
            <th
                    id="date"
                    style="
              margin-top: 10pt;
              width: 200px;
              text-align: left;
              font-weight: normal;
              padding: 6pt 0;
              border-top: 1pt solid #676d79;
            "
            >
                @php
                    $currentDate = \Carbon\Carbon::now()->format('D d F, Y H:i:s');
                @endphp
                {{$currentDate}}
            </th>
            <th style="border-top: 1pt solid #676d79">
                <div style="text-align: right">
                    <span id='currentPage'>{{ $currentPage }}</span>
                    <span id='totalPages' style='color: #8A9090'>/ {{ $totalPages }}</span>
                </div>
            </th>
        </tr>
    </table>
</div>
</body>
</html>
