@component('mail::message')
    

# New Product Published

A new product has been published **{{$product->title}} ** on our platform.

@php
  $productId =  \Crypt::encrypt($product->id)
@endphp
@component('mail::button', ['url' => url('/detail/'. $productId)])
Visit Product
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
