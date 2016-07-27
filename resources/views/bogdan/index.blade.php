@extends('layouts.app')

{{-- Web site Title --}}
@section('title') {!!  trans('site/user.login') !!} :: @parent @stop

@section('sidebar') @stop

{{-- Content --}}
@section('content')


      <div class="col-xs-12">
            <table class="table">
                  <tr>
                        <th>
                              icon
                        </th>
                        <th>
                              date
                        </th>
                        <th>
                              name
                        </th>
                        <th>
                              phone
                        </th>
                        <th>
                              email
                        </th>
                  </tr>


                  @if (count($user_data) > 0)

                        @foreach($user_data as $row)
                              <tr style="cursor: pointer" onclick="show_data({{$row->id}})" id="u-r-{{$row->id}}">

                                    <td>

                                    </td>
                                    <td>
                                          {{$row->date}}
                                    </td>
                                    <td>
                                          {{$row->name}}
                                    </td>
                                    <td>
                                          {{$row->phone}}
                                    </td>
                                    <td>
                                          {{$row->email}}
                                    </td>
                              </tr>
                        @endforeach
                  @endif
            </table>
          <div id="test1">

          </div>
      </div>


@endsection
