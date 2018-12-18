<?php

use App\Model\ExchangeRate;
use App\Model\Currency;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Currency::create([
      'id' => 'USD',
      'value' => 'United States Dollar'
    ]);

    Currency::create([
      'id' => 'IDR',
      'value' => 'Indonesian Rupiah'
    ]);

    Currency::create([
      'id' => 'AUD',
      'value' => 'Australian Dollar'
    ]);

    Currency::create([
      'id' => 'BGN',
      'value' => 'Bulgarian Lev'
    ]);

    Currency::create([
      'id' => 'BRL',
      'value' => 'Brazil Real'
    ]);

    Currency::create([
      'id' => 'CAD',
      'value' => 'Canadian Dollar'
    ]);

    Currency::create([
      'id' => 'CHF',
      'value' => 'Swiss Franc'
    ]);

    Currency::create([
      'id' => 'CNY',
      'value' => 'Chinese Yuan'
    ]);

    Currency::create([
      'id' => 'CZK',
      'value' => 'Czech Koruna'
    ]);

    Currency::create([
      'id' => 'DKK',
      'value' => 'Danish Krone'
    ]);

    Currency::create([
      'id' => 'EUR',
      'value' => 'Euro'
    ]);

    Currency::create([
      'id' => 'GBP',
      'value' => 'British Pound'
    ]);

    Currency::create([
      'id' => 'HKD',
      'value' => 'Hong Kong Dollar'
    ]);

    Currency::create([
      'id' => 'HRK',
      'value' => 'Croatian Kuna'
    ]);

    Currency::create([
      'id' => 'HUF',
      'value' => 'Hungarian Forint'
    ]);

    Currency::create([
      'id' => 'ILS',
      'value' => 'Israeli Sheqel'
    ]);

    Currency::create([
      'id' => 'INR',
      'value' => 'Indian Rupee'
    ]);

    Currency::create([
      'id' => 'JPY',
      'value' => 'Japanese Yen'
    ]);

    Currency::create([
      'id' => 'KRW',
      'value' => 'South Korean Won'
    ]);

    Currency::create([
      'id' => 'MXN',
      'value' => 'Mexico Peso'
    ]);

    Currency::create([
      'id' => 'MYR',
      'value' => 'Malaysia Ringgit'
    ]);

    Currency::create([
      'id' => 'NOK',
      'value' => 'Norway Krone'
    ]);

    Currency::create([
      'id' => 'NZD',
      'value' => 'New Zealand Dollar'
    ]);

    Currency::create([
      'id' => 'PHP',
      'value' => 'Philippine Peso'
    ]);

    Currency::create([
      'id' => 'PLN',
      'value' => 'Poland Zloty'
    ]);

    Currency::create([
      'id' => 'RON',
      'value' => 'Romanian Lei'
    ]);

    Currency::create([
      'id' => 'RUB',
      'value' => 'Russian Ruble'
    ]);

    Currency::create([
      'id' => 'SEK',
      'value' => 'Swedish Krona'
    ]);

    Currency::create([
      'id' => 'SGD',
      'value' => 'Singapore Dollar'
    ]);

    Currency::create([
      'id' => 'THB',
      'value' => 'Thailand Baht'
    ]);

    Currency::create([
      'id' => 'TRY',
      'value' => 'Turkish Lira'
    ]);

    Currency::create([
      'id' => 'ZAR',
      'value' => 'South African Rand'
    ]);


    ExchangeRate::create([
      'buy' => 'USD',
      'sell' => 'IDR',
      'value' => 13500,
      'in_use' => true
    ]);

    ExchangeRate::create([
      'buy' => 'IDR',
      'sell' => 'USD',
      'value' => 0.00007407407,
      'in_use' => false
    ]);

    ExchangeRate::create([
      'buy' => 'USD',
      'sell' => 'IDR',
      'value' => 13300,
      'in_use' => false
    ]);

    ExchangeRate::create([
      'buy' => 'IDR',
      'sell' => 'USD',
      'value' => 0.00007507407,
      'in_use' => true
    ]);
  }
}
