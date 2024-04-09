<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 2</title>
  </head>
  <body style="position: relative;width: 21cm;margin: 0 auto;color: #555555;background: #FFFFFF;font-family: 'Source Sans Pro', sans-serif;font-size: 14px;">
    
    <table style="width: 100%;border-collapse: collapse;border-spacing: 0;margin-bottom: 20px;margin: 0 auto;">
      <tr>
        <td id="logo" style="padding: 20px;background: #EEEEEE;text-align: right;border-bottom: 1px solid #FFFFFF;float: left;margin-top: 8px;background-color: transparent !important;">
            <img class="mini-thumbnail thumbnail" src="{{$message->embed(public_path().'/images/logogif.gif')}}" style="height: 70px; width:70px;" />
        </td>
        <td id="company" style="padding: 20px;background: #EEEEEE;text-align: right;border-bottom: 1px solid #FFFFFF;float: right;background-color: transparent;">
          <h2 class="name" style="font-size: 1.4em;font-weight: normal;margin: 0;">Exporter Medical</h2>
          <div>{!! App\Http\Traits\HelperTrait::returnFlag(519) !!}</div>
          <div>{{ App\Http\Traits\HelperTrait::returnFlag(59) }}</div>
          <div><a href="mailto:{{ App\Http\Traits\HelperTrait::returnFlag(218) }}" style="color: #0087C3;text-decoration: none;">{{ App\Http\Traits\HelperTrait::returnFlag(218) }}</a></div>
        </td>
      </tr>
    </table>
    <main>
      <table id="details" style="width: 100%;border-collapse: collapse;border-spacing: 0;margin-bottom: 50px;margin: 0 auto;">
        <tr>
          <td style="padding: 20px;background: #EEEEEE;text-align: center;border-bottom: 1px solid #FFFFFF;padding-left: 15px;border-left: 6px solid #0087C3;float: left;background-color: transparent;" id="client">
            <div class="to" style="color: #777777;">INVOICE TO:</div>
            <h2 class="name" style="font-size: 1.4em;font-weight: normal;margin: 0;">{{ $fname }} {{ $lname }}</h2>
            <div class="address">{{ $address }}</div>
            <div class="email"><a href="mailto:{{ $email }}" style="color: #0087C3;text-decoration: none;">{{ $email }}</a></div>
          </td>
          <td id="invoice" style="padding: 20px;background: #EEEEEE;text-align: right;border-bottom: 1px solid #FFFFFF;float: right;background-color: transparent;">
            <h1 style="color: #0087C3;font-size: 2.4em;line-height: 1em;font-weight: normal;margin: 0  0 10px 0;">INVOICE {{ $order_id }}</h1>
            <div class="date" style="font-size: 1.1em;color: #777777;">Date of Invoice: {{ \Carbon\Carbon::now()->format('d F Y') }}</div>
            <div class="date" style="font-size: 1.1em;color: #777777;">Transaction#: {{ $trans_id }}</div>
          </td>
        </tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;border-collapse: collapse;border-spacing: 0;margin-bottom: 20px;margin: 0 auto;">
        <thead>
          <tr>
            <th class="no" style="padding: 20px;background: #4e97fd;text-align: center;border-bottom: 1px solid #FFFFFF;white-space: nowrap;font-weight: normal;color: #FFFFFF;font-size: 1.6em;">#</th>
            <th class="desc" style="padding: 20px;background: #EEEEEE;text-align: left;border-bottom: 1px solid #FFFFFF;white-space: nowrap;font-weight: normal;">DESCRIPTION</th>
            <th class="unit" style="padding: 20px;background: #DDDDDD;text-align: center;border-bottom: 1px solid #FFFFFF;white-space: nowrap;font-weight: normal;">UNIT PRICE</th>
            <th class="total" style="padding: 20px;background: #4e97fd;text-align: center;border-bottom: 1px solid #FFFFFF;white-space: nowrap;font-weight: normal;color: #FFFFFF;">TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="no" style="padding: 20px;background: #4e97fd;text-align: right;border-bottom: 1px solid #FFFFFF;color: #FFFFFF;font-size: 1.6em;">01</td>
            <td class="desc" style="padding: 20px;background: #EEEEEE;text-align: left;border-bottom: 1px solid #FFFFFF;"><h3 style="color: #4e97fd;font-size: 1.2em;font-weight: normal;margin: 0 0 0.2em 0;">Pay Online Form</h3>{{ $notes }}</td>
            <td class="unit" style="padding: 20px;background: #DDDDDD;text-align: right;border-bottom: 1px solid #FFFFFF;font-size: 1.2em;">${{ $amount }}</td>
            <td class="total" style="padding: 20px;background: #4e97fd;text-align: right;border-bottom: 1px solid #FFFFFF;color: #FFFFFF;font-size: 1.2em;">${{ $amount }}</td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="1" style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;border: none;"></td>
            <td colspan="2" style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;">SUBTOTAL</td>
            <td style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;">${{ $amount }}</td>
          </tr>
          <tr>
            <td colspan="1" style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;border: none;"></td>
            <td colspan="2" style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;">GRAND TOTAL</td>
            <td style="padding: 10px 20px;background: #FFFFFF;text-align: right;border-bottom: none;font-size: 1.2em;white-space: nowrap;border-top: 1px solid #AAAAAA;">${{ $amount }}</td>
          </tr>
        </tfoot>
      </table>
      <div style="font-size: 2em;margin-bottom: 50px;"><h2>Description</h2><p style="font-size: 18px;">{{$notes}}</p></div>
      <div id="thanks" style="font-size: 2em;margin-bottom: 50px;">Thank you!</div>
      <p style="margin-top: 10px;">Thank you for your order: All sales are bound by our terms and conditions, available at <a href="https://exportermedical.com/pages/return-policy">https://exportermedical.com/pages/return-policy</a>Exporter Medical LLC is registered in the United States.</p>
    </main>
  </body>
</html>