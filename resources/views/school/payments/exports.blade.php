<table class="table table-striped projects">
  <thead>
    <tr>
      <th style="width: 1%">
        #
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.School')
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.Reservation Number')
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.Customer')
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.payment_status.Status')
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.Amount')
      </th>
      <th style="width: 20%" class="text-center">
        @lang('site.Created At')
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($payments as $payment )
    <tr>
      <td class="text-center">
        {{ $loop->iteration }}
      </td>
      <td class="text-center">
        {{ $payment->school?->title }}
      </td>
      <td class="text-center">
        {{ $payment->reservation_id }}
      </td>
      <td class="text-center">
        @php $customer = $payment->reservation->customer @endphp
        @if(isset($customer))
        {{ $customer->full_name }} - {{ $customer->phone }}
        @endif
      </td>
      <td class="text-center">
        {{ $payment->payment_status }}
      </td>
      <td class="text-center">
        {{ $payment->total_fees }} {{ appCurrency() }}
      </td>

      <td class="text-center">
        {{ $payment->created_at }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
