@props([
    'amount' => null,
    'currency' => null,
    'convert' => false,
])

@php
    $normalized_amount = $amount ?? $slot->toHtml();

    if (!is_numeric($normalized_amount) && !($normalized_amount instanceof \Akaunting\Money\Money) && !($normalized_amount instanceof \NuvisAccounting\Money\Money)) {
        $normalized_amount = (float) $normalized_amount;
    }

    $money = money($normalized_amount, $currency, $convert);
@endphp

<span>{{ $money }}</span>
