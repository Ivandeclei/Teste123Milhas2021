<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlightsTest extends TestCase
{
    public function test_lista_flights()
    {
        $response = $this->get('/api/flights');
        $response->assertStatus(200)
        ->assertJsonStructure([
            'flights' =>[
                '*' => [
                    'id',
                    'cia',
                    'fare',
                    'flightNumber',
                    'origin',
                    'destination',
                    'departureDate',
                    'arrivalDate',
                    'departureTime',
                    'arrivalTime',
                    'classService',
                    'price',
                    'tax',
                    'outbound',
                    'inbound',
                    'duration',
                ]
            ],
            'groups' => [
                '*' => [
                    'uniqueId',
                    'totalPrice',
                    'outbound' =>[
                        '*' => [

                            'id',
                            'cia',
                            'fare',
                            'flightNumber',
                            'origin',
                            'destination',
                            'departureDate',
                            'arrivalDate',
                            'departureTime',
                            'arrivalTime',
                            'classService',
                            'price',
                            'tax',
                            'outbound',
                            'inbound',
                            'duration',
                        ]
                    ],
                    'inbound' =>[
                        '*' => [

                            'id',
                            'cia',
                            'fare',
                            'flightNumber',
                            'origin',
                            'destination',
                            'departureDate',
                            'arrivalDate',
                            'departureTime',
                            'arrivalTime',
                            'classService',
                            'price',
                            'tax',
                            'outbound',
                            'inbound',
                            'duration',
                        ]
                    ]
                ]
            ],
            'totalGroups',
            'totalFlights',
            'cheapestPrice',
            'cheapestGroup',
        ]);
    }
}
