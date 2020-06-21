@extends('layouts.master')
@section('title', 'Новая запись')
@section('content-title', 'Добавить новую запись')

@section('styles')
  <link rel="stylesheet" href="{{ asset('public/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('public/css/sweetalert2.min.css') }}">

@endsection

@section('content')
  <div class="content">
    <div class="container-fluid">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-check"></i>Запись успешно добавлена</h5>
          <a href="{!! session('url') !!}"><i class="icon fas fa-link" style="margin-right: 0; "></i>
            Посмотреть</a>
        </div>
      @endif
      @if(count($errors) >  0)
        @foreach($errors->all() as $message)
          <div class="alert alert-warning  alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-ban"></i> Упс, что-то пошло не так...</h5>
            Исправьте ошибки и попробуйте снова:
            <ul>
              <li>{{ $message }}</li>
            </ul>
          </div>
        @endforeach
      @endif
      <div class="row">
        <div class="col-md-12">
          <form role="form" method="POST" action="{{ route('note.new.post') }}" id="add-form"
                enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Основные данные</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="last_name">Фамилия</label>
                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Фамилия"
                                 value="{{ old('last_name') }}">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="first_name">Имя</label>
                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Имя"
                                 value="{{ old('first_name') }}">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="patronymic">Отчество</label>
                          <input type="text" class="form-control" name="patronymic" id="patronymic"
                                 placeholder="Отчество" value="{{ old('patronymic') }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card" style="height: auto;">
                  <div class="card-header">
                    <h3 class="card-title">Фото контакта</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="photo">Фото</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="photo" name="photo">
                        <label class="custom-file-label" for="photo">Выбрать фото</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="preview-image">
                            <div class="text-center">
                              <img class="profile-user-img img-fluid img-circle" style="width: 155px;"
                                   src="{{ asset('public/img/default-photo.png') }}">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="photo_name">Тип файла</label>
                            <input type="text" class="form-control" id="photo_type" disabled="disabled">
                          </div>
                          <div class="form-group" style="margin-bottom: -5px;">
                            <label for="photo_size">Размер файла</label>
                            <input type="text" class="form-control" id="photo_size" disabled="disabled">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Дата и место рождения</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Дата рождения</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" data-inputmask-alias="datetime"
                               data-inputmask-inputformat="dd/mm/yyyy" data-inputmask-placeholder="дд/мм/гггг"
                               data-mask="" im-insert="false" name="birthday" value="{{ old('birthday') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Страна</label>
                      <select class="form-control select2" name="country" id="country"
                              style="width: 100%;">
                        <option selected="selected"></option>
                        @foreach($countries as $key => $value )
                          <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Город</label>
                      <select class="form-control select2" name="city" id="city"
                              disabled="disabled" style="width: 100%;">
                        <option selected="selected"></option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Контактные данные</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>E-mail:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="text" class="form-control" data-inputmask-alias="email" data-mask=""
                               im-insert="true" name="email" value="{{ old('email') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Номер телефона:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control" data-inputmask="'mask': '+38(999)99-99-999'"
                               data-mask=""
                               im-insert="true" name="phone" value="{{ old('phone') }}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Facebook:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                        </div>
                        <input type="url" class="form-control" data-inputmask=""
                               data-mask=""
                               im-insert="true" name="link_facebook" value="{{ old('link_facebook') }}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Социальные сети</h3>
                  </div>
                  <div class="card-body">
                    <div class="row social_networks_items">
                      <div class="col-md-12">
                        <div class="form-group social_networks_item_0" data-soc-link="0">
                          <div class="row">
                            <div class="col-md-4">
                              <input type="text" class="form-control" name="social_networks[name][0]"
                                     placeholder="Название">
                            </div>
                            <br>
                            <div class="col-md-8">
                              <input type="url" class="form-control" name="social_networks[link][0]"
                                     placeholder="Ссылка">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row bnt-add-soc-link">
                      <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-outline-info action-add-soc-link">+ Добавить
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Заметка о контакте</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group" style="margin-bottom: 5px;">
                      <textarea class="form-control" rows="3" name="contact_note"
                                placeholder="Текст заметки..." value="{{ old('contact_note') }}"></textarea>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right">Записать</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('public/js/jquery.inputmask.bundle.js') }}"></script>
  <script src="{{ asset('public/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('public/js/select2.lang.ru.js') }}"></script>
  <script src="{{ asset('public/js/bs-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('public/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('public/js/additional-methods.min.js') }}"></script>

  <script>
    $(function () {
      $('#datemask').inputmask('dd.mm.yyyy', {'placeholder': 'дд.мм.гггг'})
      $('[data-mask]').inputmask()
      $('#country').select2({
        theme: 'bootstrap4',
        placeholder: 'Выбрать страну',
        language: "ru"
      })
      $('#city').select2({
        theme: 'bootstrap4',
        placeholder: 'Для начала виберите страну',
        language: "ru"
      })
      bsCustomFileInput.init();

      $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
      }, 'Размер файла не должен быть больше 5 MB');

      jQuery.extend(jQuery.validator.messages, {
        url: "Пожалуйста, введите корректный URL-адрес."
      });

      $('#add-form').validate({
        rules: {
          last_name: {
            required: true
          },
          first_name: {
            required: true
          },
          birthday: {
            required: true
          },
          email: {
            required: true,
            email: true,
          },
          phone: {
            required: true
          },
          facebook_link: {
            required: false
          },
          photo: {
            required: false,
            extension: "jpg,jpeg,png,gif",
            filesize: 5242880,
          }
        },
        messages: {
          last_name: {
            required: "Заполните обязательное поле"
          },
          first_name: {
            required: "Заполните обязательное поле"
          },
          birthday: {
            required: "Заполните обязательное поле"
          },
          email: {
            required: "Заполните обязательное поле",
            email: "Введите валидный E-mail"
          },
          phone: {
            required: "Заполните обязательное поле"
          },
          facebook_link: {
            url: 'Пожалуйста, введите действительный URL'
          },
          photo: {
            extension: 'Выберите файл с доступным расширением: jpg, jpeg, png, gif',
            filesize: 'Размер файла не должен быть больше 5 MB'
          }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
    })

    const Toast = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 5000
    });

    function bytesToSize(bytes) {
      var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      if (bytes == 0) return '0 Byte';
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
      return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

    function previewPhoto(input) {
      if (input.files && input.files[0]) {
        if (input.files[0].type.match('image.*')) {
          var reader = new FileReader();
          reader.onload = function (e) {
            $('#photo_type').val(input.files[0].type).addClass('is-valid')
            if (input.files[0].size <= 5242880) // Max size = 5 MB
            {
              $('#photo_size').val(bytesToSize(input.files[0].size)).addClass('is-valid')
            } else {
              $('#photo_size').val(bytesToSize(input.files[0].size)).addClass('is-invalid')
            }
            $('.profile-user-img').attr('src', e.target.result)
            $('.preview-image').show()
          }
          reader.readAsDataURL(input.files[0]);
        } else {
          $('#photo_type').val(0).addClass('is-invalid')
          $('#photo_size').val(0).addClass('is-invalid')
          Toast.fire({
            icon: 'warning',
            title: 'Выберите другой файл'
          })
        }
      }
    }

    $(".custom-file-input").change(function () {
      previewPhoto(this);
    });

    let counter = 1;
    $(".action-add-soc-link").click(function () {
      let tpl = `<div class="col-md-12 social_networks_item_${counter}" data-soc-link="${counter}">
                     <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <input type="text" class="form-control" name="social_networks[name][${counter}]"
                                 placeholder="Название">
                        </div>
                        <br>
                        <div class="col-md-7">
                          <input type="url" class="form-control" name="social_networks[link][${counter}]" placeholder="Ссылка">
                        </div>
                        <div class="col-md-1">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="deleteSocLink(${counter})">&times;</button>
                        </div>
                      </div>
                    </div>
                   </div>`
      $('.social_networks_items').append(tpl);
      counter++
    });

    function deleteSocLink(id) {
      $('.social_networks_item_' + id).remove();
    }

    $('#country').on('change', function (e) {
      $.ajax({
        type: 'GET',
        url: '../api/cities/' + this.value,
        dataType: 'json'
      }).then(function (data) {
        $('#city').empty().trigger("change");
        return data
      }).then(function (data) {
        if (data.response) {
          $("#city").select2('destroy');
          $('#city').select2({
            theme: 'bootstrap4',
            placeholder: 'Выбрать город',
            language: "ru",
            data: data.cities
          })
          $('#city').removeAttr("disabled")
          $('#city').data("placeholder", "Выбрать город...")
        }
      })

    })
  </script>
@endsection