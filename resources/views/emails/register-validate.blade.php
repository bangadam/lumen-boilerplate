@component('mail::message')
#Dear User Baru,

Silahkan Klik Tautan Dibawah ini :

@component('mail::panel')
<a href="{{env('APP_URL')}}/api/v1/registers/validate?token={{$data->validateToken}}">{{env('APP_URL')}}/api/v1/registers/validate?token={{$data->validateToken}}</a>
@endcomponent

Thanks,<br>
{{ env('APP_URL') }}
@endcomponent
