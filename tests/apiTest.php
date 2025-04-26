<?php

use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private static $baseUrl = 'http://localhost:8000/api/index.php';

    private static $datacenterId;
    private static $rackId;
    private static $fabricanteId;
    private static $tipo_dispositivoId;
    private static $dispostivoId;

    private function post_original($accion, $entidad, $data) {
        $url = self::$baseUrl . "?accion={$accion}&entidad={$entidad}";
        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => json_encode($data)
            ]
        ];
        return json_decode(file_get_contents($url, false, stream_context_create($opts)), true);
    }

    private function post($accion, $entidad, $data)
    {
        $url = self::$baseUrl . "?accion={$accion}&entidad={$entidad}";
        $opts = [
            'http' => [
                'method'  => 'POST',
                'header'  => "Content-Type: application/json",
                'content' => json_encode($data),
                'ignore_errors' => true // <- clave para capturar respuestas con código HTTP 4xx/5xx
            ]
        ];

        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);

        // Si hubo error o respuesta vacía
        if ($response === false && empty($http_response_header)) {
            return [
                'http_code' => 0,
                'body' => ['error' => 'Error de conexión o sin respuesta']
            ];
        }

        // Obtener código HTTP de la cabecera
        $httpCode = 0;
        if (isset($http_response_header)) {
            foreach ($http_response_header as $header) {
                if (preg_match('#HTTP/\d+\.\d+ (\d+)#', $header, $matches)) {
                    $httpCode = (int) $matches[1];
                    break;
                }
            }
        }

        return [
            'http_code' => $httpCode,
            'body' => json_decode($response, true)
        ];
    }

    public function test_01_CrearDatacenter()
    {
        $resp = $this->post('crear', 'datacenter', [
            'nombre' => 'DC Test',
            'ubicacion' => 'Ubicacion Test',
            'descripcion' => 'Desc test'
        ]);

        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$datacenterId = $resp['body']['id'];
    }

    public function test_02_CrearDatacenterConError()
    {
        $resp = $this->post('crear', 'datacenter', [
            'nombre' => 'DC Test',
            'ubicacion' => 'Ubicacion Test'
        ]);

        $this->assertEquals(400, $resp['http_code']);
        $this->assertArrayHasKey('error', $resp['body']);
    }
    public function test_03_ModificarDatacenter()
    {
        $resp = $this->post('modificar', 'datacenter', [
            'id' => self::$datacenterId,
            'nombre' => 'DC Test Modificado',
            'ubicacion' => 'Ubicación XZX',
            'descripcion' => 'Nueva desc XZX'
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);
    }

    public function test_04_EliminarDatacenter()
    {

        $resp = $this->post('eliminar', 'datacenter', [
            'id' => self::$datacenterId
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);

    }

    public function test_05_EliminarDatacenterConError()
    {

        $resp = $this->post('eliminar', 'datacenter', [
            'id' => 4 // Id que tiene varios racks asociados
        ]);

        $this->assertEquals(409, $resp['http_code']);

    }


    // Creo un nuevo datacenter para poder crear los otros elementos
    public function test_06_CrearDatacenter()
    {
        $resp = $this->post('crear', 'datacenter', [
            'nombre' => 'DC Test',
            'ubicacion' => 'Ubicacion Test',
            'descripcion' => 'Desc test'
        ]);

        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$datacenterId = $resp['body']['id'];
    }
    
    public function test_07_CrearRack()
    {

        $resp = $this->post('crear', 'rack', [
            'numero' => '1',
            'descripcion' => 'Desc rack test',
            'id_datacenter' => self::$datacenterId
        ]);

        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$rackId = $resp['body']['id'];

    }

    public function test_08_CrearRackConError()
    {

        $resp = $this->post('crear', 'rack', [
            'numero' => '1',
            'descripcion' => 'Desc rack test',
            'id_datacenter' => 99999
        ]);
        $this->assertEquals(404, $resp['http_code']);

    }


    public function test_09_ModificarRack()
    {

        $resp = $this->post('modificar', 'rack', [
            'id' => self::$rackId,
            'numero' => self::$datacenterId,
            'descripcion' => 'Desc rack test modificado',
            'id_datacenter' => self::$datacenterId
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);
    }

    public function test_10_CrearFabricante()
    {

        $resp = $this->post('crear', 'fabricante', [
            'nombre' => 'HUAWEI'
        ]);
        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$fabricanteId = $resp['body']['id'];
    }

    public function test_11_ModificarFabricante()
    {
        $resp = $this->post('modificar', 'fabricante', [
            'id' => self::$fabricanteId,
            'nombre' => 'Desc Facricanmte test modificado',
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);
    }
    

    public function test_12_CrearFabricanteConError()
    {

        $resp = $this->post('crear', 'fabricante', [
            'a'=>'a'
        ]);
        $this->assertEquals(400, $resp['http_code']);

    }

    public function test_13_CrearTipoDispositivo()
    {

        $resp = $this->post('crear', 'tipodispositivo', [
            'descripcion' => 'SWITCH test'
        ]);
        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$tipo_dispositivoId = $resp['body']['id']; 
    }

    public function test_14_ModificarTipoDispositivo()
    {
        $resp = $this->post('modificar', 'tipodispositivo', [
            'id' => self::$tipo_dispositivoId,
            'descripcion' => 'Desc tipodispositivo test modificado',
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);
    }
    

    public function test_15_CrearTipoDispositovoConError()
    {

        $resp = $this->post('crear', 'tipodispositivo', [
            'a'=>'a'
        ]);
        $this->assertEquals(400, $resp['http_code']);

    }

    public function test_16_CrearDispositivo()
    {

        $resp = $this->post('crear', 'dispositivo', [
            'id_tipo_dispositivo' => self::$tipo_dispositivoId,
            'id_rack' => self::$rackId,
            'id_fabricante' => self::$fabricanteId,
            'ubicacion_rack' => 'A1',
            'modelo' => 'Modelo test',
            'nro_serie' => '123456',
            'nombre' => 'Dispositivo test',
            'estado' => 'Activo',
            'observaciones' => 'Observaciones test'

        ]);

        $this->assertEquals(201, $resp['http_code']);
        $this->assertArrayHasKey('id', $resp['body']);
        self::$dispostivoId = $resp['body']['id'];
    }

    public function test_17_CrearDispositivoConError()
    {

        $resp = $this->post('crear', 'dispositivo', [
            'id_tipo_dispositivo' => self::$tipo_dispositivoId,
            'id_rack' => self::$rackId,
            'ubicacion_rack' => 'A1',
            'modelo' => 'Modelo test',
            'nro_serie' => '123456',
            'nombre' => 'Dispositivo test',
            'estado' => 'Activo',
            'observaciones' => 'Observaciones test'

        ]);

        $this->assertEquals(400, $resp['http_code']);
    }

    public function test_18_ModificarDispositivo()
    {
        $resp = $this->post('modificar', 'dispositivo', [
            'id' => self::$dispostivoId,
            'id_tipo_dispositivo' => self::$tipo_dispositivoId,
            'id_rack' => self::$rackId,
            'id_fabricante' => self::$fabricanteId,
            'ubicacion_rack' => 'A1',
            'modelo' => 'Modelo test modificado',
            'nro_serie' => '123456 1234',
            'nombre' => 'Dispositivo test modificado',
            'estado' => 'Inactivo',
            'observaciones' => 'Observaciones test modificada'
        ]);

        $this->assertEquals(200, $resp['http_code']);
        $this->assertArrayHasKey('mensaje', $resp['body']);
    }


/*    
    public function test_03_CrearFabricante()
    {
        $resp = $this->post('crear', 'fabricante', [
            'nombre' => 'Cisco'
        ]);
        $this->assertArrayHasKey('id', $resp);
        self::$fabricanteId = $resp['id'];
    }

    public function test_04_CrearTipoDispositivo()
    {
        $resp = $this->post('crear', 'tipodispositivo', [
            'descripcion' => 'Switch'
        ]);
        $this->assertArrayHasKey('id', $resp);
        self::$tipoId = $resp['id'];
    }

    public function test_05_ModificarDatacenter()
    {
        $resp = $this->post('modificar', 'datacenter', [
            'id' => self::$datacenterId,
            'nombre' => 'DC Test Modificado',
            'ubicacion' => 'Ubicación XZX',
            'descripcion' => 'Nueva desc XZX'
        ]);
        $this->assertArrayHasKey('mensaje', $resp);
        echo ">>>>>>" . $resp['mensaje'];
    }

    public function test_06_EliminarDatacenter()
    {
        $resp = $this->post('eliminar', 'datacenter', ['id' => self::$datacenterId]);
        $this->assertArrayHasKey('mensaje', $resp);
        echo ">>>" . $resp['mensaje'];
    } */
}
