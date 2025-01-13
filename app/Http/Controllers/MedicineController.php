<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MedicineController extends Controller
{ 
    protected $httpClient;
    protected $baseUrl;

    public function __construct(Http $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = env('API_BASE_URL');
    }

    protected function getToken()
    {
        $cacheKey = 'api_token';

        if (Cache::has($cacheKey)) {
            $cachedData = Cache::get($cacheKey);
            $token = $cachedData['token'];
            $expiresAt = $cachedData['expires_at'];

            // Check if token is expired
            if ($expiresAt > now()->timestamp) {
                return $token; // Return token if it's still valid
            }
        }

        // Fetch a new token if not cached or expired
        try {
            $response = $this->httpClient::post($this->baseUrl.'/auth', [
                'email' => env('API_AUTH_EMAIL'),
                'password' => env('API_AUTH_PASSWORD')
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // dd($data);
                $token = $data['access_token'];
                $expiresIn = $data['expires_in']; // Token expiration time in seconds

                // Store the new token and expiration time in the cache
                Cache::put($cacheKey, [
                    'token' => $token,
                    'expires_at' => now()->addSeconds($expiresIn)->timestamp
                ], now()->addSeconds($expiresIn)); // Expire the cache at token's expiration

                return $token;
            } else {
                Log::error('Failed to fetch API token', ['response' => $response->body()]);
                return null; // Return null if token fetching failed
            }
        } catch (\Exception $e) {
            Log::error('Error fetching API token', ['error' => $e->getMessage()]);
            return null;
        }
    }


    public function getMedicines(Request $request)
    {
        $jsonString = '{
                        "medicines": [
                            {
                                "id": "9cf72984-047a-4c48-bc12-de0c6437b5ae",
                                "name": "Cholecalciferol 1000 IU Tablet Kunyah (PROVE D3-1000)"
                            },
                            {
                                "id": "9cf72984-075b-464a-86ac-bd6d727763e3",
                                "name": "Desloratadine 5mg Tablet Salut Selaput (DEXA MEDICA)"
                            },
                            {
                                "id": "9cf72984-05b8-40d7-9cee-b326578d67f7",
                                "name": "Diazepam 5mg Tablet (VALISANBE)"
                            },
                            {
                                "id": "9cf72984-0689-497b-adb6-96a7d50931db",
                                "name": "Divalproex Sodium 250mg Tablet Pelepasan Lambat (DEXA MEDICA)"
                            },
                            {
                                "id": "9cf72984-01ed-46fa-8efc-04ce10eae2ed",
                                "name": "Esomeprazole Sodium 20mg Tablet (ESOFERR)"
                            },
                            {
                                "id": "9cf72984-04e0-4d4b-852c-8602ce4cb30b",
                                "name": "Lorazepam 2mg Tablet Salut Selaput (MERLOPAM 2)"
                            },
                            {
                                "id": "9cf72984-033d-4af8-95cb-2b4912602c8a",
                                "name": "Mecobalamin 500 mg Tablet (LAPIBAL)"
                            },
                            {
                                "id": "9cf72984-0411-4b11-969c-e13a4b116bec",
                                "name": "Mefenamic Acid 500mg Tablet Salut Selaput (MEFINAL 500)"
                            },
                            {
                                "id": "9cf72984-054d-4925-b12e-2aaf8d613401",
                                "name": "Metamizole Sodium 500mg Tablet (NOVALGIN)"
                            },
                            {
                                "id": "9cf72984-0622-4a2b-81e8-1b92fbbdeb64",
                                "name": "Methylprednisolone 8mg Tablet (SANEXON 8)"
                            },
                            {
                                "id": "9cf72984-0015-45a4-a2b4-dcf83e8fe144",
                                "name": "Paracetamol 500mg Tablet (SANMOL)"
                            },
                            {
                                "id": "9cf72984-02d4-4270-b659-708bae3c5ca1",
                                "name": "Propranolol Hydrochloride 10mg Tablet (KIMIA FARMA)"
                            },
                            {
                                "id": "9cf72984-0265-4a83-9eba-278eae10ca92",
                                "name": "Ranitidine Hydrochloride 150mg Tablet Salut Selaput (HEXPHARM)"
                            },
                            {
                                "id": "9cf72984-06f4-40e2-b434-efea9ee0d622",
                                "name": "Tranexamic Acid 500mg Tablet Salut Selaput (BERNOFARM)"
                            },
                            {
                                "id": "9cf72984-03a8-43ad-9a57-41b8c6f2ba27",
                                "name": "Vitamin E 30 IU\/ Vitamin C 750mg\/ Vitamin B1 15mg (BECOM - ZET)"
                            }
                        ]
                    }';

        return json_decode($jsonString, true);

        $token = $this->getToken();
        // dd($token);
        if ($token) {
            $response = $this->httpClient::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get($this->baseUrl.'/medicines');

            return $this->apiResponse($response);
        } else {
            return response()->json(['error' => 'Unable to fetch token'], 500);
        }
    }

    public function getMedicinePrices(Request $request, $medicineId)
    {
        $jsonString = '{
                        "prices": [
                            {
                                "id": "9cf72984-1ba7-4c6c-bd4a-332f7404035b",
                                "unit_price": 4574,
                                "start_date": {
                                    "value": "2024-09-09",
                                    "formatted": "09 September 2024"
                                },
                                "end_date": {
                                    "value": "2024-09-13",
                                    "formatted": "13 September 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1bf4-46e4-a979-266d70a32144",
                                "unit_price": 4914,
                                "start_date": {
                                    "value": "2024-09-14",
                                    "formatted": "14 September 2024"
                                },
                                "end_date": {
                                    "value": "2024-09-19",
                                    "formatted": "19 September 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1c41-4628-8964-71a4982febc5",
                                "unit_price": 5254,
                                "start_date": {
                                    "value": "2024-09-20",
                                    "formatted": "20 September 2024"
                                },
                                "end_date": {
                                    "value": "2024-09-23",
                                    "formatted": "23 September 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1c8f-4794-aedf-c178e2201d94",
                                "unit_price": 4901,
                                "start_date": {
                                    "value": "2024-09-24",
                                    "formatted": "24 September 2024"
                                },
                                "end_date": {
                                    "value": "2024-09-27",
                                    "formatted": "27 September 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1cdf-4a80-a165-f7c7ee56852f",
                                "unit_price": 5284,
                                "start_date": {
                                    "value": "2024-09-28",
                                    "formatted": "28 September 2024"
                                },
                                "end_date": {
                                    "value": "2024-10-01",
                                    "formatted": "01 Oktober 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1d2c-4834-9d97-1ad65c4868ad",
                                "unit_price": 5641,
                                "start_date": {
                                    "value": "2024-10-02",
                                    "formatted": "02 Oktober 2024"
                                },
                                "end_date": {
                                    "value": "2024-10-06",
                                    "formatted": "06 Oktober 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1d7c-4f3b-8320-006afaec9fd2",
                                "unit_price": 5091,
                                "start_date": {
                                    "value": "2024-10-07",
                                    "formatted": "07 Oktober 2024"
                                },
                                "end_date": {
                                    "value": "2024-10-10",
                                    "formatted": "10 Oktober 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1dca-4d2d-ba66-0fefbe809894",
                                "unit_price": 5388,
                                "start_date": {
                                    "value": "2024-10-11",
                                    "formatted": "11 Oktober 2024"
                                },
                                "end_date": {
                                    "value": "2024-10-14",
                                    "formatted": "14 Oktober 2024"
                                }
                            },
                            {
                                "id": "9cf72984-1e13-4d68-91b9-0566283fe289",
                                "unit_price": 5829,
                                "start_date": {
                                    "value": "2024-10-15",
                                    "formatted": "15 Oktober 2024"
                                },
                                "end_date": {
                                    "value": null,
                                    "formatted": null
                                }
                            },
                            {
                                "id": "9de66f61-ea9c-4f9a-9de7-a6cac65d826b",
                                "unit_price": 4693,
                                "start_date": {
                                    "value": "2024-12-25",
                                    "formatted": "25 Desember 2024"
                                },
                                "end_date": {
                                    "value": "2024-12-29",
                                    "formatted": "29 Desember 2024"
                                }
                            },
                            {
                                "id": "9de66f61-eae5-4eed-b3bc-db5cb34a183b",
                                "unit_price": 4985,
                                "start_date": {
                                    "value": "2024-12-30",
                                    "formatted": "30 Desember 2024"
                                },
                                "end_date": {
                                    "value": "2025-01-04",
                                    "formatted": "04 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-eb2c-41ba-b79e-9f493ab13386",
                                "unit_price": 5483,
                                "start_date": {
                                    "value": "2025-01-05",
                                    "formatted": "05 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-10",
                                    "formatted": "10 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-eb75-4f0a-8721-bc10a9a2d073",
                                "unit_price": 4978,
                                "start_date": {
                                    "value": "2025-01-11",
                                    "formatted": "11 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-14",
                                    "formatted": "14 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-ebbd-46e0-b223-b08ab9ba5ebc",
                                "unit_price": 5381,
                                "start_date": {
                                    "value": "2025-01-15",
                                    "formatted": "15 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-18",
                                    "formatted": "18 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-ec04-411b-a2f3-65ec930aad0a",
                                "unit_price": 5687,
                                "start_date": {
                                    "value": "2025-01-19",
                                    "formatted": "19 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-22",
                                    "formatted": "22 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-ec4c-4e2c-b892-888adbd930dc",
                                "unit_price": 5152,
                                "start_date": {
                                    "value": "2025-01-23",
                                    "formatted": "23 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-26",
                                    "formatted": "26 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-ec94-44d3-8f6f-4438e90c8376",
                                "unit_price": 5433,
                                "start_date": {
                                    "value": "2025-01-27",
                                    "formatted": "27 Januari 2025"
                                },
                                "end_date": {
                                    "value": "2025-01-30",
                                    "formatted": "30 Januari 2025"
                                }
                            },
                            {
                                "id": "9de66f61-ecd8-4c33-aa35-de38b94212da",
                                "unit_price": 5722,
                                "start_date": {
                                    "value": "2025-01-31",
                                    "formatted": "31 Januari 2025"
                                },
                                "end_date": {
                                    "value": null,
                                    "formatted": null
                                }
                            }
                        ]
                    }';

        return json_decode($jsonString, true);
        $token = $this->getToken();

        if ($token) {
            $response = $this->httpClient::withHeaders([
                'Authorization' => "Bearer $token"
            ])->get($this->baseUrl."/medicines/{$medicineId}/prices");

            return $this->apiResponse($response);
        } else {
            return response()->json(['error' => 'Unable to fetch token'], 500);
        }
    }

    protected function apiResponse($response)
    {
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => $response->body()], $response->status());
    }

}
