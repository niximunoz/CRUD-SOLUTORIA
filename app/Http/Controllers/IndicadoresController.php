<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class IndicadoresController extends Controller
{
    public function mostrar() //poblar tabla indicadores
    {
        $query      = '';
        $table_data = '';
        $apiService = new ApiService();
        $datos      = $apiService->getIndicadores();
        foreach ($datos as $row) {
            $query .=
                DB::UPDATE(
                    "REPLACE INTO  indicadores VALUES 
                          ('" . $row["id"] . "', '" . $row["nombreIndicador"] . "', 
                          '" . $row["codigoIndicador"] . "','" . $row["unidadMedidaIndicador"] . "',
                          '" . $row["valorIndicador"] . "','" . $row["fechaIndicador"] . "',
                          '" . $row["tiempoIndicador"] . "','" . $row["origenIndicador"] . "'
                        ); "
                );

            $table_data .= '
                          <tr>
                              <td>' . $row["id"] . '</td>
                              <td>' . $row["nombreIndicador"] . '</td>
                              <td>' . $row["codigoIndicador"] . '</td>
                              <td>' . $row["unidadMedidaIndicador"] . '</td>
                              <td>' . $row["valorIndicador"] . '</td>
                              <td>' . $row["fechaIndicador"] . '</td>
                              <td>' . $row["tiempoIndicador"] . '</td>
                              <td>' . $row["origenIndicador"] . '</td>
                          </tr>
                          ';
        }
        return view('indicadores.index');
    }



    public function index(Request $request) //Mostrar datos tabla indicadores
    {
        if ($request->ajax()) {
            $indicadores = DB::select('select id,nombreIndicador,codigoIndicador, unidadMedidaIndicador,
            valorIndicador ,DATE_FORMAT(fechaIndicador, "%d-%m-%Y") as fechaIndicador  ,origenIndicador from indicadores where codigoIndicador = "UF"');
            return DataTables::of($indicadores)
                ->addColumn('action', function ($indicadores) {
                    $acciones = '<a href="javascript:void(0)" onclick="editarIndicadores(' . $indicadores->id . ')" class="btn btn-info btn-sm">Editar<a/>';
                    $acciones .= '&nbsp;&nbsp;<button type="button"  name="delete" id="' . $indicadores->id . '" class="delete btn btn-danger btn-sm"> Eliminar </button>';
                    return $acciones;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('indicadores.index');
    }

    public function registrar(Request $request) //Registrar nuevo indicador
    {
        $indicadores = DB::insert(
            'insert into indicadores (nombreIndicador,codigoIndicador,
        unidadMedidaIndicador,valorIndicador, tiempoIndicador, fechaIndicador,origenIndicador) values (?,?,?,?,null,?,?)',
            [
                $request->nombreIndicador,
                $request->codigoIndicador,
                $request->unidadMedidaIndicador,
                $request->valorIndicador,
                $request->fechaIndicador,
                $request->origenIndicador
            ]
        );
        return back();
    }

    public function eliminar($id)
    {
        $indicadores = DB::delete('delete from indicadores where id = ? ', [$id]);
        return back();
    }
    public function eliminarAll()
    {
        $indicadores = DB::delete('TRUNCATE TABLE indicadores');
        return back();
    }

    public function editar($id)
    {
        $indicadores = DB::select('select id,nombreIndicador,codigoIndicador, unidadMedidaIndicador,
        valorIndicador,fechaIndicador,origenIndicador from indicadores where id = ?', [$id]);
        return response()->json($indicadores);
    }

    public function actualizar(Request $request)
    {
        $indicadores = DB::update(
            'update indicadores set nombreIndicador = ?,codigoIndicador = ?,
        unidadMedidaIndicador = ?,valorIndicador = ?,fechaIndicador=?,
        origenIndicador = ? WHERE id = ?',
            [
                $request->nombreIndicador,
                $request->codigoIndicador,
                $request->unidadMedidaIndicador,
                $request->valorIndicador,
                $request->fechaIndicador,
                $request->origenIndicador,
                $request->id
            ]
        );
        return back();
        
    }



}
