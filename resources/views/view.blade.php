@extends('layouts.master')
@section('title', $note->get_full_name())

@section('styles')
  <style>
    .profile-user-img {
      width: 200px;
    }
  </style>
@endsection

@section('content')
  <section class="content">
    @if(session('deleted'))
      {{ redirect('index') }}
    @endif
    <div class="row">
      <div class="col-md-12">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="{{ $note->get_photo_url($note['id']) }}"
                   alt="{{ $note->get_full_name() }}">
            </div>

            <h3 class="profile-username text-center">{{ $note->get_full_name() }}</h3>
            <p>
              <a href="mailto:{{ $note['email'] }}" class="btn btn-default btn-block">{{ $note['email'] }}</a>
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>Номер телефона</b> <a href="tel:{{ $note['phone'] }}" class="float-right">{{ $note['phone'] }}</a>
              </li>
              <li class="list-group-item">
                <b>Страна рождения</b> <a href="{{ route('note.search.country', ['country_id' => ($note['country']) ? $note['country'] : 0 ]) }}" class="float-right">{{ $country->get_country_name($note['country'])['name'] }}</a>
              </li>
              <li class="list-group-item">
                <b>Город рождения</b> <a href="{{ route('note.search.city', ['city_id' => ($note['city']) ? $note['city'] : 0 ]) }}" class="float-right">{{ $city->get_city_name($note['city'])['text'] }}</a>
              </li>
              @if($note['link_facebook'])
                <li class="list-group-item">
                  <b>Facebook</b> <a href="{{ $note['link_facebook'] }}" class="float-right">{{ $note['link_facebook'] }}</a>
                </li>
              @endif
              @if($social_networks)
                @foreach($social_networks as $social_network)
                  <li class="list-group-item">
                    <b>{{ $social_network['name'] }}</b> <a href="{{ $social_network['url'] }}" class="float-right">{{ $social_network['url'] }}</a>
                  </li>
                @endforeach
              @endif
              @if($note['contact_note'])
                <blockquote class="quote-secondary" style="margin-left: 0px; margin-bottom: -30px; margin-top: 5px;">
                <p class="widget-user-contact-note-text">
                   {{ $note['contact_note'] }}
                </p>
                <small>Заметка о контакте</small>
              </blockquote>
              @endif
            </ul>

            </div>
          <div class="card-footer">
            <a href="{{ route('note.update.get', ['id' => $note['id']]) }}" class="btn btn-block btn-outline-primary"><b>Редактировать</b></a>
            <a href="{{ route('note.delete', ['id' => $note['id']]) }}" class="btn btn-block btn-outline-danger">Удалить</a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')

@endsection