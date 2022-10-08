<table class="table table-striped projects">
  <thead>
    <tr>
      <th>
        #
      </th>
      <th class="text-center">
        @lang('site.Parent Name')
      </th>
      <th class="text-center">
        @lang('site.Parent Phone')
      </th>
      <th class="text-center">
        @lang('site.Address')
      </th>
      <th class="text-center">
        @lang('site.Identification Number	')
      </th>
      <th class="text-center">
        @lang('site.Status')
      </th>
      <th class="text-center">
        @lang('site.payment_status.Status')
      </th>
      <th class="text-center">
        @lang('site.School')
      </th>
      <th class="text-center">
        @lang('site.Course')
      </th>
      <th class="text-center">
        @lang('site.Created At')
      </th>
      <th class="text-center">
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($reservations as $reservation )
    <tr>
      <td class="text-center">
        {{ $loop->iteration }}
      </td>
      <td class="text-center">
        {{ $reservation->parent_name }}
      </td>
      <td class="text-center">
        {{ $reservation->parent_phone }}
      </td>
      <td class="text-center">
        {{ $reservation->address }}
      </td>
      <td class="text-center">
        {{ $reservation->identification_number }}
      </td>
      <td class="text-center">
        @lang('site.reservation_status.'.$reservation->status)
      </td>
      <td class="text-center">
        @lang('site.reservation_status.'.$reservation->payment_status)
      </td>
      <td class="text-center">
        {{ $reservation->school?->title }}
      </td>
      <td class="text-center">
        @if($reservation->course_id)
        {{ $reservation->course?->title }}
        @endif
      </td>
      <td class="text-center">
        {{ $reservation->created_at }}
      </td>
    </tr>
    @endforeach

  </tbody>
</table>
