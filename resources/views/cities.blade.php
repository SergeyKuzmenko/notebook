@extends('layouts.master')
@section('title', 'Список городов')
@section('content-title', 'Список городов')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/sweetalert2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
  <section class="content">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Редактировать город: <span class="city_name"></span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" id="cityIdInput" value="" hidden="hidden">
                <div class="form-group">
                  <label>Страна</label>
                  <select class="form-control select2" name="country_id_modal" id="country_id_modal"
                          style="width: 100%;" data-placeholder="Выбрать страну">
                    <option selected="selected"></option>
                    @foreach($countries as $key => $country)
                      <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Город</label>
                  <input type="text" class="form-control" id="cityNameInput" value="" placeholder="Название города">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-block btn-outline-success action-update-city">Сохранить</button>
            <button class="btn btn-block btn-outline-default" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    @if(session('city_added'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Добавлено</h5>
        {!! session('city_added') !!}
      </div>
    @endif
    @if(session('city_added_failed'))
      <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Ошибка</h5>
        {!! session('city_added_failed') !!}
      </div>
    @endif
    @if(session('city_deleted'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Удалено</h5>
        {!! session('city_deleted') !!}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <form action="{{ route('list.cities.post') }}" method="POST">
                  @csrf
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Страна</label>
                        <select class="form-control select2 {{ (session('city_added_failed')) ? 'is-invalid' : '' }}" name="country_id" id="country_id"
                                style="width: 100%;" data-placeholder="Выбрать страну">
                          <option selected="selected"></option>
                          @foreach($countries as $key => $country)
                            <option value="{{ $country['id'] }}">{{ $country['name'] }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Название города</label>
                        <input type="text" class="form-control rounded-0 {{ (session('city_added_failed')) ? 'is-invalid' : '' }}" name="city_name"
                               placeholder="Введите название...">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <button type="submit" class="btn btn-block btn-outline-success" style="margin-top: 32px;">
                          Добавить
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div class="card-body table-responsive p-0">
                @if(count($cities) > 0)
                  <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th>@sortablelink('id', '#')</th>
                      <th>@sortablelink('text', 'Название')</th>
                      <th>@sortablelink('country_id', 'Страна')</th>
                      <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $city)
                      <tr data-city-id="{{ $city['id'] }}">
                        <td>{{ $city['id'] }}</td>
                        <td>{{ $city['text'] }}</td>
                        <td>{{ $countryName->find($city['country_id'])->name }}</td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-outline-info"
                                    onclick="editCity({{ $city['id'] }}, {{ $city['country_id'] }}, '{{ $city['text'] }}')">
                              Редактировать
                            </button>
                            <a href="{{ route('list.cities.delete', ['id' => $city['id']]) }}" type="button"
                               class="btn btn-outline-danger">Удалить</a>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                @else
                  <div class="card-body">
                    <p class="lead">Список городов пуст</p>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
  <script src="{{ asset('public/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('public/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('public/js/select2.lang.ru.js') }}"></script>
  <script>
    $(function () {
      $('#country_id').select2({
        theme: 'bootstrap4',
        placeholder: 'Выбрать страну',
        language: "ru"
      })
      $('#country_id_modal').select2({
        theme: 'bootstrap4',
        placeholder: 'Выбрать страну',
        language: "ru"
      })
    })
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      onAfterClose: function () {
        location.reload()
      }
    })

    $('.action-update-city').click(function () {
      let id = $('#cityIdInput').val();
      let country = $('#country_id_modal').val();
      let name = $('#cityNameInput').val();
      updateCity(id, country, name)
    });

    function editCity(id, country, name) {
      $('.city_name').text(name);
      $('#cityIdInput').val(id);
      $('#country_id_modal').val(country).trigger('change');
      $('#cityNameInput').val(name);
      $('#modal').modal('show');
    }

    function updateCity(id, country, name) {
      $.ajax({
        type: 'POST',
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: '{{ route('list.cities.update') }}',
        dataType: 'json',
        data: {id: id, country_id: country, name: name},
        beforeSend: function () {
          Swal.showLoading()
        },
        success: function (data) {
          if (data.response) {
            Swal.close()
            $('#modal').modal('hide');
            Toast.fire({
              icon: 'success',
              title: 'Город изменен'
            })
          } else {
            Swal.close()
            Toast.fire({
              icon: 'error',
              title: 'Произошла ошибка',
              text: data.message
            })
          }
        },
        error: function (data) {
          Swal.close()
          $('#modal').modal('hide');
          Toast.fire({
            icon: 'error',
            title: 'Произошла внутреняя ошибка'
          })
        }
      });
    }

  </script>
@endsection