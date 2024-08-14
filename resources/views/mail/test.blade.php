<x-mail::message>
# Служебное письмо

Спасибо за участие

<x-mail::button :url="'https://sedesys.ru'">
Перейти
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
