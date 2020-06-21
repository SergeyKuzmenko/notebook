@extends('layouts.master')
@section('title', 'Список стран')
@section('content-title', 'Список стран')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/sweetalert2.min.css') }}">
@endsection

@section('content')
  <section class="content">
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Редактировать страну: <span class="country_name"></span></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" id="countryIdInput" value="" hidden="hidden">
                <input type="text" class="form-control" id="countryNameInput" value="" placeholder="Название страны">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button class="btn btn-block btn-outline-success action-update-country">Сохранить</button>
            <button class="btn btn-block btn-outline-default" data-dismiss="modal">Закрыть</button>
          </div>
        </div>
      </div>
    </div>
    @if(session('country_added'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Добавлено</h5>
        {!! session('country_added') !!}
      </div>
    @endif
    @if(session('country_deleted'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-check"></i> Удалено</h5>
        {!! session('country_deleted') !!}
      </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <form action="{{ route('list.countries.post') }}" method="POST">
                  @csrf
                  <div class="input-group mb-3">
                    <input type="text" class="form-control rounded-0" name="country_name"
                           placeholder="Введите название...">
                    <span class="input-group-append">
                      <button type="submit" class="btn btn-block btn-outline-success">Добавить</button>
                    </span>
                  </div>
                </form>
              </div>
              <div class="card-body table-responsive p-0">
                @if(count($countries) > 0)
                  <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                      <th>@sortablelink('id', '#')</th>
                      <th>@sortablelink('name', 'Название')</th>
                      <th>Количество городов</th>
                      <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($countries as $country)
                      <tr>
                        <td>{{ $country['id'] }}</td>
                        <td class="country_name_table_{{ $country['id'] }}">{{ $country['name'] }}</td>
                        <td>{{ $citiesCount->where('country_id', $country['id'])->count() }}</td>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-outline-info"
                                    onclick="editCountry({{ $country['id'] }}, '{{ $country['name'] }}')">Редактировать
                            </button>
                            <a href="{{ route('list.country.delete', ['id' => $country['id']]) }}" type="button"
                               class="btn btn-outline-danger">Удалить</a>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                    </tbody>
                  </table>
                @else
                  <div class="card-body">
                    <p class="lead">Список стран пуст</p>
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
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      onAfterClose: function () {
        location.reload()
      }
    })

    $('.action-update-country').click(function () {
      let id = $('#countryIdInput').val();
      let name = $('#countryNameInput').val();
      updateCountry(id, name)
    });

    function editCountry(id, name) {
      $('.country_name').text(name);
      $('#countryIdInput').val(id);
      $('#countryNameInput').val(name);
      $('#modal').modal('show');
    }

    function updateCountry(id, name) {
      $.ajax({
        type: 'POST',
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: '{{ route('list.countries.update') }}',
        dataType: 'json',
        data: {id: id, name: name},
        beforeSend: function () {
          Swal.showLoading()
        },
        success: function (data) {
          if (data.response) {
            $('.country_name_table_' + id).text(name)
            Swal.close()
            $('#modal').modal('hide');
            Toast.fire({
              icon: 'success',
              title: 'Страна изменена'
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