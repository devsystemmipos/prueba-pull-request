<?php


use App\Jobs\SendEmailJob;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => ['jwt.auth']], function() {

    Route::POST('ventasFinDiaKiosko', 'Api\ReportesController@ventasFinDiaKiosko')->name('api_reportes_ventas_FinDiaKiosko');

    Route::post('pedidos/anular', 'Api\PedidoController@anular')->name('api_pedidos_anular');

    Route::get('formaspago', 'Api\FormasPagoController@formasPagoAppKiosko')->name("api_formas_pago");
    Route::get('validaradministrador/{cedula}', 'Api\LoginController@validarCedulaAdministrador')->name('api_validar_administrador');
    Route::get('tiposdocumento','Api\TipoDocumentoController@listar')->name("api_tipos_documento");
    Route::get('configuraciones', 'Api\ConfigController@configuracionesKiosko')->name('api_configuraciones');

    Route::post('pedido/montosparciales', 'Api\PedidoController@montosParciales')->name('api_montos_parciales_pedido');

    Route::get('cliente/{documento}', 'Api\ClienteController@buscar')->name('api_buscar_cliente');

    Route::get('logout', 'Auth\LoginController@logout')->name("api_logout");
    Route::get('menus', 'Api\MenuController@menus')->name("api_menus");

    Route::get('preguntas/{pluid}', 'Api\MenuController@preguntasSugeridas')
        ->where('pluid', '[0-9]+')
        ->name("api_preguntas_sugeridas");

    Route::post('cliente/validar', 'Api\ClienteController@validarCliente')->name('api_validar_cliente');

	Route::get('kiosk/status', 'Api\LoginController@estadoAsignacionKiosko')->name('api_estado_asignacion_kiosko');
	Route::get('reportes/ventas-switch', 'Api\ReportesController@ventasSwitchKiosko')->name('api_reportes_ventas_switch');
    /**
     * Rutas de la version 1, para las imágenes que se mostraban en el kiosko original
     * en las pantallas de historias, en la parte superior de promociones y en la pantalla
     * de inicio

    Route::get('imagenes/promociones', 'Api\ImagenesController@promociones')->name('api_imagenes_promociones');
    Route::get('imagenes/historias', 'Api\ImagenesController@historias')->name('api_imagenes_historias');
    Route::get('imagenes/pantallainicio', 'Api\ImagenesController@pantallaInicio')->name('api_imagenes_pantalla_inicio');
    */

    Route::get('pedidos/listaranulacion', 'Api\PedidoController@listarAnulacion')->name('api_listar_pedidos_anulacion');

});

//Route::post('login', 'Auth\LoginController@login');

Route::get('Node', function () {



    try{
        $client = new Client([
            'base_uri' => 'http://172.17.0.94:3000',
            'json' => [
                'billStatus' => '200',
                "billData"    => [
                    "Autorizacion" => "520132",
                    "MensajeRespuestaAut" => "APROBADA",
                    "NumeroTarjeta" => "416683XXXXXXX318",
                    "TarjetaHabiente" => "PRODUBANCO"
                ]
                ]
        ]);

        $response = $client->put('/conciliation/5dcd71629aa34251b8aba99b', [

                'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);
        dd($response->getBody()->getContents());
    }catch (\GuzzleHttp\Exception\ClientException $e){
        dd($e->getMessage());
    }


});


Route::resource('pedidos','Api\PedidoController', ['only'=> ['index','store']]);
Route::post('iniciarventas', 'Api\LoginController@iniciarControlEstacion')->name('api_iniciar_ventas');
Route::post('finalizarventas', 'Api\LoginController@finalizarControlEstacion')->name('api_finalizar_ventas');

/*
Route::get('sendMail', function(){
    //return 'holamundosssssssss';


    //Carbon::parse('"2019-10-10 22:36:06.000000"');
    //$formato = 'Y-m-d H:i:s';
    //$fecha = DateTime::createFromFormat($formato, '2019-10-10 22:49:06');

    //SendEmailJob::dispatch()
      //  ->delay($fecha);
    //return ('email sent');

    $customFormat = [
        'estado'        =>  'OK',
        'codigo'        =>  'hello',
        'msg'           =>  'dd',
        'data'          =>  'dddd',
        'error'         =>  'dsskddjdj'
    ];

    SendEmailJob::dispatch()
        ->delay(Carbon::now()->AddSeconds(5));
    return ('email sent');
});
Route::get('EnviarCorreo', 'Api\PruebasColas@Enviar')->name('api_Enviar');
*/


//Route::post('register', 'Auth\RegisterController@register');
//Route::post('imagenes/sincronizar/pantallainicio','Api\ImagenesController@sincronizarAzureImagenesPantallaInicio')->name('api_imagenes_sincronizar_pantalla_inicio');