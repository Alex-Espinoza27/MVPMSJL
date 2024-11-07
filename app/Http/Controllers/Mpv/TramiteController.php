<?php

namespace App\Http\Controllers\Mpv;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Mpv\Models\Anexo;
use App\Http\Controllers\Mpv\Models\ArchivoPrincipal;
use App\Http\Controllers\Mpv\Models\Solicitud;
use App\Http\Controllers\Mpv\Models\TipoDocumento;
use App\Http\Controllers\Sgd\Models\Tupa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TramiteController extends Controller
{
    // public function __construct()
    // {
    //     $tipoDocumento = TipoDocumento::all(); 
    // }

    public function solicitud()
    {
        // dd("entro");
        $page_data['header_js'] = array(
            // select2 
            'js/js_general.js',
            'js/js_solicitud.js',
            //table
            'plugins/datatables/jquery.dataTables.min.js',
            'plugins/datatables/dataTables.bootstrap5.min.js',
            'pages/jquery.datatable.init.js',
            // repetir anexos
            'plugins/repeater/jquery.repeater.min.js',
            'pages/jquery.form-repeater.js',
            // cargar archivos
            'plugins/dropify/js/dropify.min.js',
            'pages/jquery.form-upload.init.js',
            // form validation 
            'pages/jquery.validation.init.js',
            'plugins/parsleyjs/parsley.min.js',
            //tablas
            'plugins/datatables/dataTables.buttons.min.js',
            'plugins/datatables/buttons.bootstrap5.min.js',
        );

        $page_data['header_css'] = array(
            // select2 - table
            // 'plugins/select2/select2.min.css',
            'plugins/datatables/dataTables.bootstrap5.min.css',
            'plugins/datatables/buttons.bootstrap5.min.css',
            // cargar archivos
            'plugins/dropify/css/dropify.min.css',
            // 'plugins/jvectormap/jquery-jvectormap-2.0.2.css',
            'plugins/datatables/responsive.bootstrap4.min.css',
        );
        $page_data['page_directory'] = 'tramite'; // carpeta
        $page_data['page_name'] = 'solicitud'; // nombre carpeta
        $page_data['page_title'] = 'Mis Tramites';
        $page_data['breadcrumb'] = 'solicitud';

        // dd($SOLICITUDES);
        return view('index', $page_data, );
    }
    public function listarSolicitud()
    {
        $USUARIO = session('user')->USU_NUMERO_DOCUMENTO;
        $SOLICITUDES = DB::select('EXEC MDSJL.MOSTRAR_SOLICITUDES ?', [$USUARIO]);
        // dd($SOLICITUDES);
        return response()->json($SOLICITUDES);
    }
    public function tupa()
    {
        $tupa = Tupa::all();
        return response()->json($tupa);
    }
    public function tipoDocumento()
    {
        $tipoDocumento = TipoDocumento::all();
        return response()->json($tipoDocumento);
    }
    public function registrarSolicitud(Request $request)
    {
        // dd($request);
        $P_TUPA = $request->input('P_TUPA');
        $P_PLAZO_TUPA = $request->input('P_PLAZO_TUPA');
        $P_TIPO_DOCUMENTO = $request->input('P_TIPO_DOCUMENTO');
        $P_NRO_DOCUMENTO = $request->input('P_NRO_DOCUMENTO');
        $P_NRO_EXPEDIENTE = $request->input('P_NRO_EXPEDIENTE');
        $P_ANIO_EXPEDIENTE = $request->input('P_ANIO_EXPEDIENTE');
        $P_ASUNTO = $request->input('P_ASUNTO');

        $SOLICITUD = new Solicitud();

        $CORRELATIVO_ACTUAL = Solicitud::max('SOLI_ID');
        $TEMP = $CORRELATIVO_ACTUAL + 1;
        $CORRELATIVO_NUEVO = str_pad($TEMP, 5, '0', STR_PAD_LEFT);

        if ($P_TUPA != 0) {
            $SOLICITUD->SOLI_COD_TUPA = $P_TUPA;
            // $SOLICITUD->TIPO_DOCUMENTO_ID = 1; //EXPEDIENTE
            $SOLICITUD->SOLI_NU_EMI = 'EXP-' . $P_ANIO_EXPEDIENTE . '-' . $CORRELATIVO_NUEVO;
        } else {
            // $SOLICITUD->TIPO_DOCUMENTO_ID = 2; // SOLICITUD
            $SOLICITUD->SOLI_NU_EMI = 'SOL-' . $P_ANIO_EXPEDIENTE . '-' . $CORRELATIVO_NUEVO;
        }

        $SOLICITUD->SOLI_NU_ANN = $P_ANIO_EXPEDIENTE;
        $SOLICITUD->SOLI_FECHA_EMISION = now()->format('Y-m-d H:i:s');
        $SOLICITUD->SOLI_FECHA = now()->format('Y-m-d H:i:s');
        $SOLICITUD->SOLI_NRO_EXPEDIENTE = $P_NRO_EXPEDIENTE;

        // este campo se puede pasar EXPEDIENTE SOLICITUD -> el numero puede volar
        $SOLICITUD->TIPO_DOCUMENTO_ID = $P_TIPO_DOCUMENTO;
        $SOLICITUD->SOLI_NUMERO_DOCUMENTO = $P_NRO_DOCUMENTO;
        $SOLICITUD->SOLI_ASUNTO = $P_ASUNTO;
        $SOLICITUD->CREATED_AT = now()->format('Y-m-d H:i:s');
        $SOLICITUD->UPDATED_AT = now()->format('Y-m-d H:i:s');
        // $SOLICITUD->DELETED_AT = 
        $SOLICITUD->CREATED_BY = session('user')->USU_NUMERO_DOCUMENTO;
        $SOLICITUD->UPDATED_BY = session('user')->USU_NUMERO_DOCUMENTO;
        $SOLICITUD->COD_USUARIO = session('user')->USU_ID;
        $SOLICITUD->SOLI_ESTADO_ID = 1; //Pendiente

        try {
            $SOLICITUD->save(); 
            $mensaje =  $this->guardarArchivo($request, $SOLICITUD->SOLI_ID);
            return redirect('/tramite/solicitud')->with($mensaje['tipo'],$mensaje['mensaje']);
        } catch (\Exception $e) {
            return ['error', $e->getMessage()]; 
            // return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function guardarArchivo(Request $request, $SOLICITUD_ID)
    {
        try {
            $validator = Validator::make($request->all(), [
                'P_ARCHIVO_PRIN' => 'required|file|mimes:pdf|max:10240', // 10MB máximo
                'LIST_ANEXOS.*.P_ANEXOS' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30000'
            ]);

            if ($validator->fails()) {
                // return response()->json([
                //     'status' => false,
                //     'message' => 'Error de validación',
                //     'errors' => $validator->errors()
                // ], 422);
                // return ['error',$validator->errors()];
                return [ 'tipo' => 'error','mensaje' => $validator->errors()]; 
            }

            $BASE_PATH_MPV = 'ArchivosMPV';
            $USUARIO = session('user')->USU_NUMERO_DOCUMENTO;
            $ARCHIVO_PRIN_FOLDER = 'archivo_principal';
            $ANEXOS_FOLDER = 'anexos';

            // 3. Crear estructura de directorios
            $USUARIO_PATH = "{$BASE_PATH_MPV}/{$USUARIO}/{$SOLICITUD_ID}";
            $ARCHIVO_PRINCIPAL_PATH = "{$USUARIO_PATH}/{$ARCHIVO_PRIN_FOLDER}";
            $ANEXOS_PATH = "{$USUARIO_PATH}/{$ANEXOS_FOLDER}";

            // Crear directorios si no existen
            foreach ([$USUARIO_PATH, $ARCHIVO_PRINCIPAL_PATH, $ANEXOS_PATH] as $PATH) {
                if (!Storage::exists($PATH)) {
                    Storage::makeDirectory($PATH);
                }
            }

            $ARCHIVO_PRINCIPAL = $request->file('P_ARCHIVO_PRIN');
            $NOMBRE_ARCHIVOS_PRINCIPAL = $this->limpiarNombreArchivo($ARCHIVO_PRINCIPAL->getClientOriginalName());
            // $NOMBRE_ARCHIVOS_PRINCIPAL = $ARCHIVO_PRINCIPAL->getClientOriginalName();

            $RUTA_ARCHIVO_PRINCIPAL = Storage::putFileAs(
                $ARCHIVO_PRINCIPAL_PATH,
                $ARCHIVO_PRINCIPAL,
                $NOMBRE_ARCHIVOS_PRINCIPAL
            );
            $ARCHIVO_PRINCIPAL_DATA = [
                'nombre' => $NOMBRE_ARCHIVOS_PRINCIPAL,
                'ruta' => $RUTA_ARCHIVO_PRINCIPAL
            ];
            // dd($ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID);
            $ANEXOS_DATA = [];
            if ($request->has('LIST_ANEXOS')) {
                foreach ($request->file('LIST_ANEXOS') as $anexo) {
                    // Verificar si el archivo existe y es válido
                    if (isset($anexo['P_ANEXOS']) && $anexo['P_ANEXOS'] instanceof \Illuminate\Http\UploadedFile) {
                        $file = $anexo['P_ANEXOS'];
                        $NOMBRE_ANEXO = $this->limpiarNombreArchivo($file->getClientOriginalName());
                        // $NOMBRE_ANEXO = $file->getClientOriginalName();
                        $RUTA_ANEXO = Storage::putFileAs(
                            $ANEXOS_PATH,
                            $file,
                            $NOMBRE_ANEXO
                        );
                        $ANEXOS_DATA[] = [
                            'nombre' => $NOMBRE_ANEXO,
                            'ruta' => $RUTA_ANEXO
                        ];
                    }
                }
            }
            // dd($ANEXOS_DATA,$ARCHIVO_PRINCIPAL_DATA);

            $mensaje = $this->cargarInformacioArchivos($ANEXOS_DATA, $ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID);
            return $mensaje; 
        } catch (\Exception $e) { 
            return [ 'tipo' => 'error','mensaje' => 'Ocurrio un problema al guardar los archivos en el local, comunicate con el administrador']; 
            // return [ 'error','Ocurrio un problema al guardar los archivos en el local, comunicate con el administrador']; 
            //     'error' => $e->getMessage()
        }
    }
    private function cargarInformacioArchivos($ANEXOS_DATA = [], $ARCHIVO_PRINCIPAL_DATA, $SOLICITUD_ID)
    {
        try {
            // ARCHIVO PRINCIPAL
            $ARCHIVO_PRIN = new ArchivoPrincipal();
            $ARCHIVO_PRIN->SOLICITUD_ID = $SOLICITUD_ID;
            $ARCHIVO_PRIN->ARCHIPRIN_NOMBRE_FILE_ORIGEN = $ARCHIVO_PRINCIPAL_DATA['ruta'];
            $ARCHIVO_PRIN->CREATED_AT = now()->format('Y-m-d H:i:s');
            $ARCHIVO_PRIN->UPDATED_AT = now()->format('Y-m-d H:i:s');
            $ARCHIVO_PRIN->ARCHIPRIN_NOMBRE_FILE = $ARCHIVO_PRINCIPAL_DATA['nombre'];
            $ARCHIVO_PRIN->ARCHIPRIN_IS_UPLOAD = 0;
            $ARCHIVO_PRIN->save();

            // ANEXOS
            if (!empty($ANEXOS_DATA)) {
                foreach ($ANEXOS_DATA as $INDICE => $ITEM) {
                    $ANEXO = new Anexo();
                    $ANEXO->ANEX_NUMERO = $INDICE + 1;
                    $ANEXO->SOLICITUD_ID = $SOLICITUD_ID;
                    $ANEXO->ANEX_NOMBRE_FILE_ORIGEN = $ITEM['ruta'];
                    $ANEXO->ANEX_DETALLE = $ITEM['nombre'];
                    $ANEXO->ANEX_IS_UPLOAD = 0;
                    $ANEXO->ANEX_IND_HABILITADO = 1;
                    $ANEXO->CREATED_AT = now()->format('Y-m-d H:i:s');
                    $ANEXO->UPDATED_AT = now()->format('Y-m-d H:i:s');
                    $ANEXO->ANEX_NOMBRE_FILE = $ITEM['nombre'];

                    $ANEXO->save();
                }
            }

            // dd($ANEXOS_DATA);
            $mensaje = ['tipo' => 'success', 'mensaje' =>'Se registro la solicitud exitosamente'];
            // $mensaje = ['success', 'Se registro la solicitud exitosamente'];

            return $mensaje;
        } catch (\Throwable $th) {
            return [ 'tipo' => 'error','mensaje' =>'Ocurrio un error al guardar los archivos en BD, comunicate con el administrador'];
            // return [ 'error','Ocurrio un error al guardar los archivos en BD, comunicate con el administrador'];

        }
    }
    private function generarNombreUnico($nombreOriginal)
    {
        $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
        $nombreBase = pathinfo($nombreOriginal, PATHINFO_FILENAME);
        $timestamp = now()->format('Ymd_His');
        $random = str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT);

        return "{$nombreBase}_{$timestamp}_{$random}.{$extension}";
    }
    private function limpiarNombreArchivo($nombre)
    {
        $nombre = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $nombre);
        // Evitar nombres duplicados de archivo
        return strtolower($nombre);
    }
}