<?php

namespace App\Http\Controllers\Flights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

use App\Http\Controllers\IntegracaoApi\IntegracaoController;

/**
 * @OA\Get(
 *     tags={"Flights"},
 *     path="/flights",
 *     description=" Retorna os voos agrupados e não agrupados",
 *     @OA\Parameter(
 *       in="query",
 *       name="orderBy",
 *       description="Ordena os grupos pelo preço total de cada grupo.  o padrão é do Menor para o maior [ASC]",
 *       @OA\Schema(
 *           type="string",
 *           enum={"ASC", "DESC"},
 *       ),
 *     ),
 *     @OA\Response(response="200", description="Success")
 * )
 */

class FlightsController extends Controller
{
    public function index(Request $request, IntegracaoController $integracao)
    {
        try {
            $dados = [];

            $flights = $integracao->dadosApi();
            $group =  $this->agroup($flights);
            $cheapestPrice = $this->cheapesPrice($group);

            if ($request->get('orderBy') != null && $request->get('orderBy') != "ASC" &&  $request->get('orderBy') != "DESC") {
                return response()->json(["Parametro de ordenação Inválido"], 400);
            }

            $group = $this->orderFlights($group, $request->get('orderBy'));

            $dados['flights'] = $flights;
            $dados['groups'] =  $group;
            $dados['totalGroups'] = count($group);
            $dados['totalFlights'] = count($flights);
            $dados['cheapestPrice'] =  $cheapestPrice['totalPrice'];
            $dados['cheapestGroup'] =  $cheapestPrice['uniqueId'];

            return response()->json($dados, 200);

        } catch (\Throwable $th) {
            return response()->json(["Erro Interno do Servidor"], 500);
        }
    }

    public function agroup($flights)
    {
        if (count($flights) <= 0) {
            return [];
        }

        $groups = [];
        $group  = [];

        $flightCollection = new Collection($flights);

        $groupingOutbound = $flightCollection->where('outbound', 1)->groupBy(['fare', 'price'], true);
        $groupingIbound = $flightCollection->where('inbound', 1)->groupBy(['fare', 'price'], true);

        foreach ($groupingOutbound as $keyOutboundFare => $valueOutbound) {
            foreach ($valueOutbound as $keyPriceOutbound => $valuePriceOutbound) {
                foreach ($groupingIbound as $keyInboundFare => $valueInbound) {
                    foreach ($valueInbound as $keyPriceInbound => $valuePriceInbound) {
                        if ($keyOutboundFare === $keyInboundFare) {
                            $group['uniqueId'] = mt_rand();
                            $group['totalPrice'] = $keyPriceOutbound + $keyPriceInbound;
                            $group['outbound'] = $valuePriceOutbound->values()->all();
                            $group['inbound'] = $valuePriceInbound->values()->all();
                            array_push($groups, $group);
                        }
                    }
                }
            }
        }

        if (count($groups) <= 0) {
            return [];
        }

        return $groups;
    }

    public function orderFlights($flightGroup, $orderBy = "ASC")
    {
        if (count($flightGroup) <= 0) {
            return [];
        }

        $flightGroupCollection = new Collection($flightGroup);

        if ($flightGroupCollection->contains('totalPrice')) {
            if ($orderBy == "ASC") {
                $result = $flightGroupCollection->sortBy('totalPrice')->values()->all();
            } else {
                $result = $flightGroupCollection->sortByDesc('totalPrice')->values()->all();
            }
        } else {
            if ($orderBy == "ASC") {
                $result = $flightGroupCollection->sortBy('price')->values()->all();
            } else {
                $result = $flightGroupCollection->sortByDesc('price')->values()->all();
            }
        }

        return $result;
    }

    public function cheapesPrice($flightGroup){

        if (count($flightGroup) <= 0) {
            $result['uniqueId'] = "";
            $result['totalPrice'] = "";

            return $result;
        }

        $flightGroupCollection = new Collection($flightGroup);

        $minPriceFlight = $flightGroupCollection->min('totalPrice');
        $cheapesPrice = $flightGroupCollection->firstWhere('totalPrice', $minPriceFlight);

        $result['uniqueId'] = $cheapesPrice['uniqueId'];
        $result['totalPrice'] = $cheapesPrice['totalPrice'];

        return $result;
    }
}
