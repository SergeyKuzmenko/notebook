@extends('layouts.master')
@section('title', 'Все записи')
@section('content-title', 'Все записи')
@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/sweetalert2.min.css') }}">
  <style>
    .modal-body {
      margin: -16px;
      margin-bottom: -32px;
    }

    .widget-user-image > img {
      width: 90px;
    }

    .widget-user-username {
      font-size: 30px;
      margin-top: 10px;
    }

    .quote-secondary {
      margin: 0;
    }
  </style>
@endsection

@section('content')
  <section class="content">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-default">
                <div class="widget-user-image">
                  <img class="img-circle elevation-2 widget-user-photo" src="">
                </div>
                <h3 class="widget-user-username"></h3>
                <h5 class="widget-user-desc"><a href="" class="widget-user-email"></a></h5>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column data-list">
                  <li class="nav-item">
                    <span class="nav-link">
                      Номер телефона <a href="" class="float-right widget-user-phone"></a>
                    </span>
                  </li>
                  <li class="nav-item">
                    <span class="nav-link">
                      Страна рождения <a class="float-right widget-user-country"></a>
                    </span>
                  </li>
                  <li class="nav-item">
                    <span class="nav-link">
                      Город рождения <a class="float-right widget-user-city"></a>
                    </span>
                  </li>
                  <li class="nav-item facebook-item" style="display: none;">
                    <span class="nav-link">
                      Facebook <p class="float-right"><a href="" target="_blank" class="widget-user-facebook"></a></p>
                    </span>
                  </li>
                </ul>
              </div>
              <blockquote class="quote-secondary widget-user-contact-note" style="display: none;">
                <p class="widget-user-contact-note-text"></p>
                <small>Заметка о контакте</small>
              </blockquote>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <a href="" class="btn btn-block btn-outline-primary action-update-note">Редактировать</a>
            <a href="" class="btn btn-block btn-outline-danger action-delete-note">Удалить</a>
            <a href="#close" class="btn btn-block btn-outline-default" data-dismiss="modal">Закрыть</a>
          </div>
        </div>
      </div>
    </div>
    @if(session('deleted'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Удалено</h5>
        {{ session('deleted') }}
      </div>
    @endif
    <div class="card">
      <div class="card-body table-responsive p-0">
        @if(count($notes) > 0)
          <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
              <th>@sortablelink('id', '#')</th>
              <th>@sortablelink('last_name', 'Фамилия Имя')</th>
              <th>@sortablelink('phone', 'Номер телефона')</th>
              <th>@sortablelink('email', 'Электронная почта')</th>
              <th>@sortablelink('birthday', 'Дата рождения')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($notes as $key => $note)
              <tr>
                <td>
                  <a href="{{ route('note.view.get', ['id' => $note['id']]) }}" data-note-id="{{ $note['id'] }}"
                     class="view-details">
                    @if($note['photo'])
                      <img src="{{ asset('public/photos/') . '/' .  $note['photo'] . '?' . rand()}}"
                           alt="{{ $note['id'] }}"
                           class="img-circle img-size-32 mr-2">
                    @else()
                      <img src="{{ asset('public/img/contact-default-icon.png') }}" alt="{{ $note['id'] }}"
                           class="img-circle img-size-32 mr-2">
                    @endif
                  </a>
                </td>
                <td>
                  <a href="{{ route('note.view.get', ['id' => $note['id']]) }}" data-note-id="{{ $note['id'] }}"
                     class="view-details">
                    {{ $note['last_name'] }} {{ $note['first_name'] }}
                  </a>
                </td>
                <td>{{ $note['phone'] }}</td>
                <td>
                  {{ $note['email'] }}
                </td>
                <td>
                  {{ $note['birthday'] }}
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        @else
          <div class="card-body">
            <p class="lead">Ещё нет ни одной записи... <a href="{{ route('note.new.get') }}">Добавить</a></p>
          </div>
        @endif
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script src="{{ asset('public/js/sweetalert2.all.min.js') }}"></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('.view-details').on('click', function (e) {
      e.preventDefault();
      let id = $(this).data('note-id');
      $.ajax({
        type: 'POST',
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: '{{ route('note.view.post') }}' + '?' + Math.random(),
        dataType: 'json',
        data: {id},
        beforeSend: function () {
          Swal.showLoading()
        },
        success: function (data) {
          if (data.response) {
            // Magic ... >_<
            let patronymic;
            if (data.data.patronymic !== null) {
              patronymic = data.data.patronymic
            } else {
              patronymic = '';
            }
            $('.widget-user-username').text(`${data.data.last_name} ${data.data.first_name} ${patronymic}`);
            $('.widget-user-email').text(`${data.data.email}`).attr('href', `mailto:${data.data.email}`);
            $('.widget-user-phone').text(`${data.data.phone}`).attr('href', `tel:${data.data.phone}`);
            $('.widget-user-photo').attr('src', `${data.data.photo}` + '?' + Math.random());
            $('.widget-user-country').text(`${data.data.country.name}`).attr('href', `note/search/country/${data.data.country.id}`);
            $('.widget-user-city').text(`${data.data.city.text}`).attr('href', `note/search/city/${data.data.city.id}`);

            if (data.data.link_facebook !== null) {
              $('.facebook-item').css('display', 'block');
              $('.widget-user-facebook').text(`${data.data.link_facebook}`).attr('href', `${data.data.link_facebook}`)
            } else {
              $('.facebook-item').css('display', 'none');
            }

            if (data.data.contact_note !== null && data.data.contact_note !== '') {
              $('.widget-user-contact-note').css('display', 'block');
              $('.widget-user-contact-note-text').html(`${data.data.contact_note}`);
            } else {
              $('.widget-user-contact-note').css('display', 'none');
            }

            if (data.data.social_networks) {
              // delete previous link
              let selectors = $('body').find('.social-link-item');
              $.each(selectors, function (key, item) {
                $(item).remove();
              })
              // print current link
              $.each(data.data.social_networks, function (key, item) {
                $('.data-list').append(`<li class="nav-item social-link-item"><span class="nav-link">${item.name}<p class="float-right"><a href="${item.url}" target="_blank">${item.url}</a></p></span></li>`)
              })
            }
            $('.action-delete-note').attr('href', data.data.delete_link);
            $('.action-update-note').attr('href', data.data.update_link);
            $('#modal').modal('show');

            Swal.close()
          } else {
            Toast.fire({
              icon: 'warning',
              title: 'Произошла ошибка'
            })
          }
        },
        error: function (data) {
          Swal.close()
          Toast.fire({
            icon: 'warning',
            title: 'Произошла ошибка'
          })
        }
      });
    })
  </script>
@endsection